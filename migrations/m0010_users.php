<?php

class m0010_users
{
    public function init(\core\Database $db): void
    {
        $db->pdo->exec("CREATE TABLE snf_users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(80) NOT NULL,
            accountsLimit SMALLINT NOT NULL,
            password VARCHAR(512) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;");
    }

    public function seed(\core\Database $db): void
    {
        $users = [
            ['jenda.vales@seznam.cz', password_hash('asdasd', PASSWORD_DEFAULT), 5],
        ];
        $query = $db->pdo->prepare("INSERT INTO snf_users (email, password, accountsLimit) VALUES (?, ?, ?)");

        foreach ($users as $user) {
            $query->execute($user);
        }
    }

    public function drop(\core\Database $db): void
    {
        $db->pdo->exec("DROP TABLE IF EXISTS snf_users");
    }
}