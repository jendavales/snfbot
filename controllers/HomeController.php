<?php

namespace controllers;

use core\Controller;

class HomeController extends Controller
{
    public function home()
    {
        return $this->render('home', [
            'title' => 'SNF bot'
        ], 'layouts/app');
    }
}
