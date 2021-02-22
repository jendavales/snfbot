<?php

namespace core;

class Database
{
    public $pdo;

    public function __construct(string $server, $name, string $user, string $password)
    {
        $dsn = "mysql:dbname=$name;host=$server";
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}
