<?php

namespace Middlewares;

use core\Application;
use core\Middleware;
use core\Session;

class LoginMiddleware extends Middleware
{
    public function verify(): bool
    {
        return !is_null(Application::$app->getUser());
    }

    public function handleFailure(): void
    {
        Application::$app->session->setFlash(Session::FLASH_WARNING, 'Pro pokračování se musíš přihlásit.');
        Application::$app->response->redirect('login');
    }
}