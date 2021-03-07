<?php

namespace Models;

use core\Application;
use core\DbModel;
use core\Model;
use core\ValidationRules\RequiredRule;
use core\ValidationRules\SameAsRule;

class User extends DbModel
{
    public const DEFAULT_ACCOUNTS_LIMIT = 5;

    public $id;
    public $email;
    public $password;
    public $accountsLimit;

    public static function tableName(): string
    {
        return 'snf_users';
    }

    public static function dbAttributes(): array
    {
        return ['email', 'accountsLimit'];
    }

    public static function primaryKeys(): array
    {
        return ['id'];
    }

    public function insert(): void
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        parent::insert();
        $this->id = Application::$app->database->pdo->lastInsertId();
    }
}