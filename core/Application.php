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

    public function __construct(string $rootPath)
    {
        self::$app = $this;
        $this->database = new Database($GLOBALS['params']['db_server'], $GLOBALS['params']['db_name'], $GLOBALS['params']['db_login'], $GLOBALS['params']['db_password']);
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request);
        $this->session = new Session();
        $this->rootPath = $rootPath;
        $this->user = null;
    }

    public function run(): void
    {
        $callback = $this->router->resolve();
        $callback->addParameter('request', $this->request);

        $className = $callback->getClass();
        $callableClass = new $className ();

        echo call_user_func_array([$callableClass, $callback->getFunctionName()], $this->getOrderedParams($callback));
    }

    private function getOrderedParams(Callback $callback): array
    {
        $method = new \ReflectionMethod($callback->getClass(), $callback->getFunctionName());
        $orderedParams = [];

        foreach ($method->getParameters() as $parameter) {
            $orderedParams[] = $callback->getParameters()[$parameter->getName()];
        }

        return $orderedParams;
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        foreach ($user->primaryKeys() as $primaryKey) {
            $primaryValues[] = $user->{$primaryKey};
        }
        $primaryValue = implode(',', $primaryValues);
        $this->session->set('user', $primaryValue);
    }

    public function logout()
    {
        $this->user = null;
        self::$app->session->remove('user');
    }
}
