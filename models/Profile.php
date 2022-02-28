<?php

namespace Models;

use core\Application;
use core\DbModel;

class Profile extends DbModel
{
    public const MAX_ADVENTURES = 60;
    public const ITEM_ACTION_DELETE = 1;
    public const ITEM_ACTION_STORE = 2;
    public const PROFILE_NONE = 'none';

    public $id;
    public $name;
    public $user;
    public $quests;
    public $items;
    public $adventures;
    public $quests_xp;
    public $quests_gold;
    public $items_action;
    public $items_speed;
    public $items_sunProtection;
    public $items_greed;
    public $adventures_dinos;

    public static function tableName(): string
    {
        return 'snf_profiles';
    }

    public static function dbAttributes(): array
    {
        return ['name', 'user', 'items', 'items_action', 'items_speed', 'items_sunProtection', 'items_greed', 'quests', 'quests_xp', 'quests_gold', 'adventures', 'adventures_dinos'];
    }

    public static function primaryKeys(): array
    {
        return ['id'];
    }

    public static function createEmpty(): Profile
    {
        return new Profile(
            [
                'name' => 'Založit nový',
                'items' => false,
                'items_greed' => 50,
                'items_speed' => 50,
                'items_sunProtection' => 50,
                'items_action' => Profile::ITEM_ACTION_DELETE,
                'adventures' => false,
                'adventures_dinos' => false,
                'quests' => false,
                'quests_xp' => 50,
                'quests_gold' => 50,
            ]
        );
    }

    public static function createDefaultXp(): Profile
    {
        return new Profile(
            [
                'name' => 'Co nejvíc XP',
                'items' => true,
                'items_greed' => 50,
                'items_speed' => 50,
                'items_sunProtection' => 50,
                'items_action' => Profile::ITEM_ACTION_DELETE,
                'adventures' => false,
                'adventures_dinos' => false,
                'quests' => true,
                'quests_xp' => 100,
                'quests_gold' => 0,
            ]
        );
    }

    public static function createDefaultGold(): Profile
    {
        return new Profile(
            [
                'name' => 'Co nejvíc Goldů',
                'items' => true,
                'items_greed' => 50,
                'items_speed' => 50,
                'items_sunProtection' => 50,
                'items_action' => Profile::ITEM_ACTION_DELETE,
                'adventures' => false,
                'adventures_dinos' => false,
                'quests' => true,
                'quests_xp' => 0,
                'quests_gold' => 100,
            ]
        );
    }

    public function insert(): void
    {
        $user = $this->user;
        $this->user = $user->id;
        parent::insert();
        $this->user = $user;
        $this->id = Application::$app->database->pdo->lastInsertId();
    }

    public function update(array $fieldsToUpdate = []): void
    {
        $user = $this->user;
        $this->user = $user->id;
        parent::update($fieldsToUpdate);
        $this->user = $user;
    }

    protected function afterFetch(): void
    {
        $this->user = new User(['id' => $this->user]);
        $this->user->fetch();
    }
}
