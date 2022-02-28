<?php

namespace controllers;

use core\Controller;
use Models\Account;
use models\Bot\Bot;
use models\Bot\BotRunner;

class BotController extends Controller
{
    public function runBot()
    {
//        $account = new Account(['id' => 1]);
//        $account->fetch();
//        $bot = new Bot($account);
//        $account->setOutfit($bot->getCharacterImages());
//        $account->update();

        $accounts = Account::fetchAll(['id' => '1']);
        $bots = $this->createBotsFromAccounts($accounts);
        BotRunner::runBots($bots);
    }

    private function createBotsFromAccounts(array $accounts): array
    {
        $bots = [];

        foreach ($accounts as $account) {
            $bots[] = new Bot($account);
        }

        return $bots;
    }
}
