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
}
