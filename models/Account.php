<?php

namespace Models;

use core\DbModel;

class Account extends DbModel
{
    public const PROFILE_NONE = 'none';
    private const OUTFLIT_DELIMETER = ';';

    public $id;
    public $name;
    public $password;
    public $profile;
    public $adventureTime;
    public $energy;
    public $user;
    public $outfit;
    public $level;
    public $xpNeeded;
    public $actualXp;
    public $adventures;

    public static function tableName(): string
    {
        return 'snf_accounts';
    }

    public static function dbAttributes(): array
    {
        return ['name', 'password', 'profile', 'adventureTime', 'energy', 'user', 'adventures', 'xpNeeded', 'actualXp', 'outfit', 'level'];
    }

    public static function primaryKeys(): array
    {
        return ['id'];
    }

    public function fetch(array $fetchBy = [], array $additionalFields = ['id']): void
    {
        parent::fetch($fetchBy, $additionalFields);

        $this->user = new User(['id' => $this->user]);
        $this->user->fetch();

        if (!is_null($this->profile)) {
            $this->profile = new Profile(['id' => $this->profile]);
            $this->profile->fetch();
        }
    }

    public function setOutfit(array $images): void
    {
        $this->outfit = implode(self::OUTFLIT_DELIMETER, $images);
    }

    public function getOutfitImages(): array
    {
        return explode(self::OUTFLIT_DELIMETER, $this->outfit);
    }

    public function getLevelProgress(int $decimals = 0): string
    {
        return round($this->actualXp / $this->xpNeeded * 100, $decimals);
    }

}
