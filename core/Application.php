<?php

namespace core;

use controllers\ErrorController;

class Application
{
    private const ERROR_LOG = '../var/error_log.txt';
    public static $app;
    public $router;
    public $request;
    public $response;
    public $rootPath;
    public $database;
    public $session;
    private $user;
    public $userClass;

    public function __construct(string $rootPath)
    {
        self::$app = $this;
        $this->userClass = $GLOBALS['params']['userClass'];
        $this->database = new Database($GLOBALS['params']['db_server'], $GLOBALS['params']['db_name'], $GLOBALS['params']['db_login'], $GLOBALS['params']['db_password']);
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request);
        $this->session = new Session();
        $this->rootPath = $rootPath;
        $this->user = null;

        try {
            $userId = Application::$app->session->get('user');
            if ($userId) {
                $primaryKeys = unserialize($userId);
                $this->user = new $this->userClass();
                $this->user->loadPropertiesFromArray($primaryKeys);
                $this->user->fetch();
            }
        } catch (\Error | \Exception $e) {
            $this->handleError($e->getMessage() . " in " . $e->getFile(), Response::ERROR);
        }
    }

    public function run(): void
    {
        try {
            $callback = $this->router->resolve();
            $this->request->setUrlParameters($callback->getParameters());
            $controllerClass = $callback->getControllerClass();
            $controller = new $controllerClass();
            $middlewares = $controller->getMiddlewares();
            /** @var Middleware $middleware */
            foreach ($middlewares as $middleware) {
                if (!$middleware->verify()) {
                    $middleware->handleFailure();
                }
            }

            $callback->addParameter('request', $this->request);

            echo call_user_func_array([$controller, $callback->getFunctionName()], $this->getOrderedParams($callback, $controller));
            $this->session->setLastUrl($_SERVER['REQUEST_URI']);
        } catch (NotFoundException $e) {
            $this->handleError('', Response::NOT_FOUND);
        } catch (\Error | \Exception $e) {
            $this->handleError($e->getMessage() . " in " . $e->getFile() . " on " . $e->getLine(), Response::ERROR);
        }
    }

    private function getOrderedParams(Callback $callback, Controller $controller): array
    {
        $method = new \ReflectionMethod($controller, $callback->getFunctionName());
        $orderedParams = [];

        foreach ($method->getParameters() as $parameter) {
            $orderedParams[] = $callback->getParameters()[$parameter->getName()];
        }

        return $orderedParams;
    }

    public function login(DbModel $user): void
    {
        $this->user = $user;
        foreach ($user->primaryKeys() as $primaryKey) {
            $primaryValues[$primaryKey] = $user->{$primaryKey};
        }
        $primaryValue = serialize($primaryValues);
        $this->session->set('user', $primaryValue);
    }

    public function logout(): void
    {
        $this->user = null;
        self::$app->session->remove('user');
    }

    //returns user class set in config or null
    public function getUser(): ?DbModel
    {
        return $this->user;
    }

    public function handleError(string $message, int $code)
    {
        if ($code !== Response::NOT_FOUND) {
            $stack = debug_backtrace();
            //create stack trace
            $output = $message . PHP_EOL . 'Stack trace:' . PHP_EOL;

            $stackLen = count($stack);
            for ($i = 1; $i < $stackLen; $i++) {
                $entry = $stack[$i];

                $func = $entry['function'] . '(';
                $argsLen = count($entry['args']);
                for ($j = 0; $j < $argsLen; $j++) {
                    $func .= $entry['args'][$j];
                    if ($j < $argsLen - 1) $func .= ', ';
                }
                $func .= ')';

                $output .= '#' . ($i - 1) . ' ' . $entry['file'] . ':' . $entry['line'] . ' - ' . $func . PHP_EOL;
            }
            $output .= $_SERVER['REQUEST_URI'] . PHP_EOL;
            if (!is_null($this->user)) {
                $output .= $this->user->email . PHP_EOL;
            }

            file_put_contents(self::ERROR_LOG, $output . PHP_EOL, FILE_APPEND);
            if ($GLOBALS['params']['env'] == 'dev') {
                echo $output;
                exit();
            }
        }
        $controller = new ErrorController();
        echo $controller->error($code);
        exit();
    }
}
