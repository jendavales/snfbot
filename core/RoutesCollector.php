<?php

namespace core;

use controllers\HomeController;
use controllers\IndexController;
use controllers\ProfilesController;

class RoutesCollector
{
    public static function getRoutes(): array
    {
        return [
            'login' => new Route('/', [Request::METHOD_GET, Request::METHOD_POST], IndexController::class, 'home'),
            'registration' => new Route('/registration', [Request::METHOD_GET, Request::METHOD_POST], IndexController::class, 'registration'),
            'home' => new Route('/home', [Request::METHOD_GET, Request::METHOD_POST], HomeController::class, 'home'),
            'logout' => new Route('/logout', [Request::METHOD_GET], IndexController::class, 'logout'),
            'addAccount' => new Route('/add-account', [Request::METHOD_POST], HomeController::class, 'addAccountAction'),
        ];
    }
}
