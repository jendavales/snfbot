<?php

namespace models\Bot\Http;

use models\Bot\Item\DeleteMove;
use models\Bot\Item\EquipMove;

class SnfUrlResolver
{
    public static function login(): string
    {
        return "https://snf.piorecky.cz?action=login";
    }

    public static function menu(): string
    {
        return "https://snf.piorecky.cz/menu.php";
    }

    public static function index(): string
    {
        return "https://snf.piorecky.cz";
    }

    public static function quests(): string
    {
        return "https://snf.piorecky.cz/quests.php";
    }

    public static function collectQuest(): string
    {
        return "https://snf.piorecky.cz/quests.php?collect";
    }

    public static function acceptQuest($qid): string
    {
        return "https://snf.piorecky.cz/quests.php?accept=$qid";
    }

    public static function logout(): string
    {
        return "https://snf.piorecky.cz/?logout";
    }

    public static function deleteItem(DeleteMove $move): string
    {
        return "https://snf.piorecky.cz/api/delete_item.php?slot=$move->fromSlot&location=$move->fromLocation";
    }

    public static function moveItem(EquipMove $move): string
    {
        return "https://snf.piorecky.cz/api/move_item.php?fromslot=$move->fromSlot&fromlocation=$move->fromLocation&toslot=$move->toSlot&tolocation=$move->toLocation";
    }

    public static function adventures(): string
    {
        return "https://snf.piorecky.cz/adventures.php";
    }

    public static function acceptAdventure(): string
    {
        return "https://snf.piorecky.cz/api/get_adventure_fight_results.php";
    }
}
