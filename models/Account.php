<?php

namespace Models;

use core\DbModel;

class Account extends DbModel
{
    public $id;
    public $name;
    public $password;
    public $profile;
    public $adventureTime;
    public $energy;
    public $user;

    public static function tableName(): string
    {
        return 'snf_accounts';
    }

    public static function dbAttributes(): array
    {
        return ['name', 'password', 'profile', 'adventureTime', 'energy', 'user'];
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

}
