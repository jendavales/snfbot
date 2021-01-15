<?php

namespace core;

use controllers\HomeController;

class Router
{
    const HTTP_NOT_FOUND = 404;

    public $request;
    private $routes;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->routes = RoutesCollector::getRoutes();
    }

    public function generateUrl(string $routeName, array $parameters = [], bool $absolute = false): string
    {
        return $this->routes[$routeName]->getUrl($parameters, $absolute);
    }

    public function resolve(): Callback
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->getCallback($method, $path);
        if (is_null($callback)) {
            //todo: return 404;
            Application::$app->response->setStatusCode(self::HTTP_NOT_FOUND);
            vdx('404');
        }

        return $callback;
    }

    private function getCallback(string $method, string $path): ?Callback
    {
        $pathNoQuery = $this->getPathNoQuery($path);

        foreach ($this->routes as $route) {
            if (preg_match_all($route->getRegex(), $pathNoQuery, $parameters) && $route->hasMethod($method)) {
                $callback = $route->getCallback();
                if (count($parameters) === 1) {
                    return $callback;
                }

                for ($i = 1; $i < count($parameters); $i++) {
                    $callback->addParameter($route->getParameters()[$i - 1], $parameters[$i][0]);
                }

                return $callback;
            }
        }

        return null;
    }

    private function getPathNoQuery(string $path): string
    {
        $queryPos = strpos($path, '?');

        if ($queryPos === false) {
            return $path;
        }

        return substr($path, 0, $queryPos);
    }
}
