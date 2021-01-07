<?php

namespace controllers;

use core\Controller;

class HomeController extends Controller
{
    public function home()
    {
        return $this->render('login', [
            'title' => 'SNF bot'
        ]);
    }

    public function registration()
    {
        return $this->render('registration', [
            'title' => 'SNF bot | Registrace'
        ]);
    }
}
