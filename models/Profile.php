<?php

namespace Models;

use core\DbModel;

class Profile extends DbModel
{
    public const MAX_ADVENTURES = 60;

    public $id;
    public $name;
    public $user;

    public static function tableName(): string
    {
        return 'snf_accounts';
    }

    public static function dbAttributes(): array
    {
        return ['name', 'user'];
    }

    public static function primaryKeys(): array
    {
        return ['id'];
    }
}
