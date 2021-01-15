<?php

namespace controllers;

use core\Controller;
use core\Request;
use Models\RegistrationModel;

class HomeController extends Controller
{
    public function home()
    {
        return $this->render('login', [
            'title' => 'SNF bot'
        ]);
    }

    public function registration(Request $request)
    {
        $registerModel = new RegistrationModel();
        if ($request->isPost()) {
            $registerModel->loadData($request->getBody());

            if ($registerModel->validate()) {
            }
        }

        return $this->render('registration', [
            'title' => 'SNF bot | Registrace',
            'registerModel' => $registerModel
        ]);
    }
}
