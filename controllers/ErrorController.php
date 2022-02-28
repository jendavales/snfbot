<?php

namespace controllers;

use core\Application;
use core\Controller;

class ErrorController extends Controller
{
    public function error(int $status)
    {
        Application::$app->response->setStatusCode($status);
        return $this->render('error', ['code' => $status], '');
    }
}
