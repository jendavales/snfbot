<?php

namespace controllers;

use core\Application;
use core\Controller;
use core\Request;
use core\Session;
use Forms\LoginForm;
use Forms\RegistrationForm;
use Models\User;

class IndexController extends Controller
{
    public function home(Request $request)
    {
        $loginForm = new LoginForm();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate()) {
                $user = new User();
                $user->fetch(['email' => $loginForm->email], ['password', 'id']);
                if (password_verify($loginForm->password, $user->password)) {
                    Application::$app->login($user);
                    Application::$app->response->redirect('home');
                }

                $loginForm->addError('login', 'Nesprávné jméno nebo heslo!');
            }
        }

        return $this->render('login', [
            'loginForm' => $loginForm,
            'title' => 'SNF bot'
        ]);
    }

    public function registration(Request $request)
    {
        $registrationForm = new RegistrationForm();
        if ($request->isPost()) {
            $registrationForm->loadData($request->getBody());

            if ($registrationForm->validate()) {
                $user = new User();
                $user->fetch(['email' => $registrationForm->email]);
                if (!empty($user->id)) {
                    $registrationForm->addError('email', 'Email již existuje!');

                    return $this->render('registration', [
                        'title' => 'SNF bot | Registrace',
                        'user' => $user
                    ]);
                }

                $user->loadPropertiesFromArray($registrationForm->toArray());
                $user->insert();
                Application::$app->session->setFlash(Session::FLASH_SUCCESS, 'Registrace byla úspěšná! Nýní se můžeš přihlásit.');
                Application::$app->response->redirect('login');
            }
        }

        return $this->render('registration', [
            'title' => 'SNF bot | Registrace',
            'registrationForm' => $registrationForm
        ]);
    }
}
