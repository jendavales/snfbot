<?php

namespace core;

use core\Application;

class Controller
{
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
}
