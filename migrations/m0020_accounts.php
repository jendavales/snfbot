<?php

class m0020_accounts
{
    public function init(\core\Database $db): void
    {
        $db->pdo->exec("CREATE TABLE snf_accounts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(14) NOT NULL,
            password VARCHAR(60) NOT NULL,
            profile INT DEFAULT NULL,
            energy float DEFAULT NULL,
            adventures tinyint DEFAULT NULL,
            adventureTime time DEFAULT NULL, 
            user INT NOT NULL,
            CONSTRAINT fk_accounts_user FOREIGN KEY (user) REFERENCES snf_users(id) ON DELETE CASCADE,
            CONSTRAINT fk_accounts_profile FOREIGN KEY (profile) REFERENCES snf_profiles(id) ON DELETE SET NULL
        )  ENGINE=INNODB;");
    }

    public function seed(\core\Database $db): void
    {
        $accounts = [
            ['test1', 'heslo', 1, 1],
            ['test2', 'heslo', null, 1]
        ];

        $query = $db->pdo->prepare('INSERT INTO snf_accounts (name, password, profile, user) VALUES (?, ?, ?, ?)');

        foreach ($accounts as $account) {
            $query->execute($account);
        }
    }

    public function drop(\core\Database $db): void
    {
        $db->pdo->exec("DROP TABLE IF EXISTS snf_accounts");
    }
}
