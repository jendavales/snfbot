<?php

namespace core;

use controllers\HomeController;

class RoutesCollector
{
    public static function getRoutes(): array
    {
        return [
            'home' => new Route('/', Request::METHOD_GET, HomeController::class, 'home'),
        ];
    }
}
