<?php

namespace core;

use controllers\HomeController;

class Application
{
    public static $app;
    public $router;
    public $request;
    public $response;
    public $rootPath;

    public function __construct(string $rootPath)
    {
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request);
        $this->rootPath = $rootPath;
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
}
