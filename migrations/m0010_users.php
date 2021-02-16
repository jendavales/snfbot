<?php

class m0010_users
{
    public function init(\core\Database $db): void
    {
        $db->pdo->exec("CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(80) NOT NULL,
            password VARCHAR(512) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;");
    }

    public function seed(): void
    {
        //todo: add users to seed
    }

    public function drop(\core\Database $db): void
    {
        $db->pdo->exec("DROP TABLE users");
    }
}