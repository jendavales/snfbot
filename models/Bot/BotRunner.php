<?php

namespace models\Bot;

use models\Bot\Http\RequestCreator;
use models\Bot\Http\RequestSender;
use models\Bot\Http\SnfUrlResolver;
use models\Bot\Item\DeleteMove;
use models\Bot\Item\EquipMove;
use Models\Profile;

class BotRunner
{
    public static function runBots(array $bots)
    {
        self::performLogin($bots);
//        self::doQuests($bots); //todo: fix warnings
//        self::doAdventures($bots);
//        self::updateStats($bots);
        self::doItems($bots);
//        self::updateAccounts($bots);
    }

    private static function performLogin(array $bots): void
    {
        $requests = [];
        /** @var Bot $bot */
        foreach ($bots as $bot) {
            $data = [
                'name' => $bot->getAccount()->name,
                'password' => $bot->getAccount()->password,
            ];
            $requests[] = RequestCreator::preparePost($bot, SnfUrlResolver::login(), $data);
        }
        RequestSender::sendMulti($requests);
    }

    private static function doQuests(array $bots): void
    {
        $requests = [];
        /** @var Bot $bot */
        foreach ($bots as $bot) {
            if (!$bot->getAccount()->getProfile()->quests) {
                continue;
            }
            $requests[] = RequestCreator::prepareGet($bot, SnfUrlResolver::collectQuest());
        }
        RequestSender::sendMulti($requests);

        $requests = [];
        /** @var Bot $bot */
        foreach ($bots as $bot) {
            if (!$bot->getAccount()->getProfile()->quests) {
                continue;
            }
            $quests = Parser::getQuests($bot->getLastPath());
            if (is_null($quests)) {
                continue;
            }
            $bestQuest = $quests->bestQuest($bot->getAccount()->getProfile());
            $requests[] = RequestCreator::prepareGet($bot, SnfUrlResolver::acceptQuest($bestQuest->id));
        }
        RequestSender::sendMulti($requests);
    }

    private static function doAdventures(array $bots): void
    {
        $requests = [];
        /** @var Bot $bot */
        foreach ($bots as $bot) {
            if (!$bot->getAccount()->getProfile()->adventures) {
                continue;
            }
            $requests[] = RequestCreator::prepareGet($bot, SnfUrlResolver::adventures());
        }
        RequestSender::sendMulti($requests);

        //todo: updating dinos

        $requests = [];
        /** @var Bot $bot */
        foreach ($bots as $bot) {
            if (!$bot->getAccount()->getProfile()->adventures) {
                continue;
            }

            if (Parser::containsAdventuresToken($bot->getLastPath())) {
                $requests[] = RequestCreator::preparePost($bot, SnfUrlResolver::acceptAdventure());
            }
        }
        RequestSender::sendMulti($requests);
    }

    private static function doItems(array $bots): void
    {
        $deleteRequests = [];
        $equipRequests = [];

        /** @var Bot $bot */
        foreach ($bots as $bot) {
            if (!$bot->getAccount()->getProfile()->items) {
                continue;
            }
            $inventory = Parser::getInventory($bot->getLastDownload());
            $itemMoves = $inventory->calculateItemMoves($bot->getAccount()->getProfile());
            if ($bot->getAccount()->getProfile()->items_action == Profile::ITEM_ACTION_DELETE) {
                $deleteRequests = array_merge($deleteRequests, self::createRequestsDeleteForMoves($bot, $itemMoves->getDeleteMoves()));
            }
            $equipRequests = array_merge($equipRequests, self::createRequestsForEquipMoves($bot, $itemMoves->getEquipMoves()));
        }

        //Make sure to delete first then equip (so that items positions dont change)
        RequestSender::sendMulti($deleteRequests);
        RequestSender::sendMulti($equipRequests);
    }

    //REQUIRES HOMEPAGE DOWNLOADED
    private static function updateStats(array $bots): void
    {
        /** @var Bot $bot */
        foreach ($bots as $bot) {
            $bot->updateHomePageStats();
        }
    }

    private static function updateAccounts(array $bots): void
    {
        /** @var Bot $bot */
        foreach ($bots as $bot) {
            $bot->getAccount()->update();
        }
    }

    private static function createRequestsForEquipMoves(Bot $bot, array $moves): array
    {
        $equipRequests = [];
        /** @var EquipMove $move */
        foreach ($moves as $move) {
            $equipRequests[] = RequestCreator::prepareGet($bot, SnfUrlResolver::moveItem($move));
        }
        return $equipRequests;
    }

    private static function createRequestsDeleteForMoves(Bot $bot, array $moves): array
    {
        $deleteRequests = [];
        /** @var DeleteMove $move */
        foreach ($moves as $move) {
            $deleteRequests[] = RequestCreator::prepareGet($bot, SnfUrlResolver::deleteItem($move));
        }
        return $deleteRequests;
    }
}
