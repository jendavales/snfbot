<?php

namespace controllers;

use core\Application;
use core\Controller;
use core\Request;
use Forms\AddAccountForm;
use Middlewares\LoginMiddleware;
use Models\Account;
use Models\Profile;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->registerMiddleware(new LoginMiddleware());
    }

    public function home()
    {
        $user = Application::$app->user;
        $accounts = Account::fetchAll(['user' => $user->id]);

        return $this->render('home', [
            'title' => 'SNF bot',
            'accounts' => $accounts,
            'profiles' => Profile::fetchAll(['user' => $user->id]),
            'emptyProfile' => Profile::createEmpty(),
            'user' => $user,
        ], 'layouts/app');
    }

    public function addAccountAction(Request $request)
    {
        //todo: check accounts limit

        $form = new AddAccountForm();
        $form->loadData($request->getBody());

        if ($form->validate()) {
            //todo: try login
            $account = new Account($form->toArray());
            //LOAD DATA INSTEAD
            $account->energy = 100;
            $account->outfit = '';
            $account->adventures = 0;
            $account->level = 1;
            $account->xpNeeded = 10;
            $account->actualXp = 9;
            $account->profile = null;
            //END LOAD DATA
            $account->user = Application::$app->user->id;
            $account->insert();
        }

        Application::$app->response->redirect('home');
    }
}
