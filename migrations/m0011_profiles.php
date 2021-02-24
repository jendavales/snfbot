<?php

class m0011_profiles
{
    public function init(\core\Database $db): void
    {
        $db->pdo->exec("CREATE TABLE snf_profiles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(14) NOT NULL,
            user INT NOT NULL,
            CONSTRAINT fk_profiles_user FOREIGN KEY (user) REFERENCES snf_users(id) ON DELETE CASCADE
        )  ENGINE=INNODB;");
    }

    public function seed(\core\Database $db): void
    {
        $profiles = [['name' => 'profile1', 'user' => 1], ['name' => 'profile2', 'user' => 1]];
        $query = $db->pdo->prepare("INSERT INTO snf_profiles (name, user) VALUES (:name, :user)");

        foreach ($profiles as $profile) {
            $query->bindValue(':name', $profile['name']);
            $query->bindValue(':user', $profile['user']);
            $query->execute();
        }
    }

    public function drop(\core\Database $db): void
    {
        $db->pdo->exec("DROP TABLE IF EXISTS snf_profiles");
    }
}
