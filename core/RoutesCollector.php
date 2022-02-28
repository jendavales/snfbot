<?php

namespace core;

use controllers\BotController;
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
            'addAccount' => new Route('/account/add', [Request::METHOD_POST], HomeController::class, 'addAccountAction'),
            'saveProfile' => new Route('/profile/save', [Request::METHOD_POST], ProfilesController::class, 'saveProfile'),
            'setProfile' => new Route('/profile/set', [Request::METHOD_POST], ProfilesController::class, 'setProfile'),
            'botRun' => new Route('/bot/run', [Request::METHOD_GET], BotController::class, 'runBot')
        ];
    }
}
