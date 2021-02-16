<?php

namespace controllers;

use core\Application;
use core\Controller;
use Middlewares\LoginMiddleware;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->registerMiddleware(new LoginMiddleware());
    }

    public function home()
    {
        return $this->render('home', [
            'title' => 'SNF bot'
        ], 'layouts/app');
    }
}
