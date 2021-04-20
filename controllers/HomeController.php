<?php

namespace controllers;

use core\Application;
use core\Controller;
use core\Request;
use core\Session;
use Forms\AddAccountForm;
use Middlewares\LoginMiddleware;
use Models\Account;
use models\Bot\Bot;
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
        $accounts = Account::fetchAll(['user' => Application::$app->user->id]);
        if (Application::$app->user->accountsLimit <= count($accounts)) {
            Application::$app->session->setFlash(Session::FLASH_WARNING, 'Pro přidání více účtů zaplať');
            Application::$app->response->redirect('home');
        }

        $form = new AddAccountForm();
        $form->loadData($request->getBody());

        if ($form->validate()) {
            $account = new Account($form->toArray());
            $bot = new Bot($account);
            if (!$bot->isLogged()) {
                Application::$app->session->setFlash(Session::FLASH_FAILURE, 'Na účet se nepodařilo přihlásit');
                Application::$app->response->redirect('home');
            }
            $account->setOutfit($bot->getCharacterImages());
            //LOAD DATA INSTEAD
            $account->energy = 100;
            $account->adventures = 0;
            $account->level = 1;
            $account->xpNeeded = 10;
            $account->actualXp = 9;
            //END LOAD DATA
            $account->profile = null;
            $account->user = Application::$app->user->id;
            $account->insert();
        }

        Application::$app->response->redirect('home');
    }
}
