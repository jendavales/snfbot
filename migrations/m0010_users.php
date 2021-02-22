<?php

class m0010_users
{
    public function init(\core\Database $db): void
    {
        $db->pdo->exec("CREATE TABLE snf_users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(80) NOT NULL,
            password VARCHAR(512) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;");
    }

    public function seed(\core\Database $db): void
    {
        $users = [['email' => 'jenda.vales@seznam.cz', 'password' =>'asdasd']];
        $query = $db->pdo->prepare("INSERT INTO snf_users (email, password) VALUES (:email, :password)");

        foreach ($users as $user) {
            $query->bindValue(':email', $user['email']);
            $query->bindValue(':password', password_hash( $user['password'], PASSWORD_DEFAULT));
            $query->execute();
        }
    }

    public function drop(\core\Database $db): void
    {
        $db->pdo->exec("DROP TABLE IF EXISTS snf_users");
    }
}