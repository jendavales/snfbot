<?php

namespace core;

use core\Application;

class Controller
{
    private $middlewares;

    public function __construct()
    {
        $this->middlewares = [];
    }

    public function render(string $view, array $params = [], string $layout = 'layouts/main')
    {
        $view = $this->renderView($view, $params);

        if ($layout === '') {
            return $view;
        }

        $layout = $this->renderView($layout, $params);

        return str_replace('{{content}}', $view, $layout);
    }

    public function renderView(string $view, array $params): string
    {
        foreach ($params as $key => $param) {
            $$key = $param;
        }
        ob_start();
        include_once Application::$app->rootPath . '/views/' . $view . '.php';

        return ob_get_clean();
    }

    public function registerMiddleware(Middleware $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
