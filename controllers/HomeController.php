<?php

namespace controllers;

use core\Controller;
use Middlewares\LoginMiddleware;
use Models\Account;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->registerMiddleware(new LoginMiddleware());
    }

    public function home()
    {
        $accounts = Account::fetchAll(['user' => 1]);

        return $this->render('home', [
            'title' => 'SNF bot',
            'accounts' => $accounts
        ], 'layouts/app');
    }
}
