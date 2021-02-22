<?php

namespace core;

use controllers\IndexController;

class Application
{
    public static $app;
    public $router;
    public $request;
    public $response;
    public $rootPath;
    public $database;
    public $session;
    public $user;
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

        $userId = Application::$app->session->get('user');
        if ($userId) {
            $primaryKeys = unserialize($userId);
            $this->user = new $this->userClass();
            $this->user->loadPropertiesFromArray($primaryKeys);
            $this->user->fetch();
        }
    }

    public function run(): void
    {
        $callback = $this->router->resolve();

        $controller = $callback->getController();
        $middlewares = $controller->getMiddlewares();
        /** @var Middleware $middleware */
        foreach ($middlewares as $middleware) {
            if (!$middleware->verify()) {
                $middleware->handleFailure();
            }
        }


        $callback->addParameter('request', $this->request);

        echo call_user_func_array([$controller, $callback->getFunctionName()], $this->getOrderedParams($callback));
    }

    private function getOrderedParams(Callback $callback): array
    {
        $method = new \ReflectionMethod($callback->getController(), $callback->getFunctionName());
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
    public function getUser()
    {
        return $this->user;
    }
}
