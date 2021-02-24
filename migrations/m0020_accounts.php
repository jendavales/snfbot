<?php

class m0020_accounts
{
    public function init(\core\Database $db): void
    {
        $db->pdo->exec("CREATE TABLE snf_accounts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(14) NOT NULL,
            password VARCHAR(60) NOT NULL,
            outfit VARCHAR(800) NOT NULL,
            level INT NOT NULL,
            xpNeeded INT NOT NULL,
            actualXp INT NOT NULL,
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
        $outfit = 'https://snf.piorecky.cz/assets/img/character/body/1.png?version=2019-03-24-13-47-07;https://snf.piorecky.cz/assets/img/character/shoes/4.png?version=2019-04-06-00-21-10;https://snf.piorecky.cz/assets/img/character/shorts/2.png?version=2019-03-24-13-47-07;https://snf.piorecky.cz/assets/img/character/shirt/3.png?version=2019-04-06-00-21-10;https://snf.piorecky.cz/assets/img/character/head/1.png?version=2019-03-24-13-47-07;https://snf.piorecky.cz/assets/img/character/eyes/1.png?version=2019-03-24-13-47-07;https://snf.piorecky.cz/assets/img/character/hair/2.png?version=2019-03-24-14-42-57';

        $accounts = [
            ['test1', 'heslo', 1, 1, $outfit, 42, 120, 54, 25, 12],
            ['test2', 'heslo', null, 1, $outfit, 69, 233, 42, 0, 60]
        ];

        $query = $db->pdo->prepare('
            INSERT INTO snf_accounts 
                (name, password, profile, user, outfit, level, xpNeeded, actualXp, energy, adventures) 
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ');

        foreach ($accounts as $account) {
            $query->execute($account);
        }
    }

    public function drop(\core\Database $db): void
    {
        $db->pdo->exec("DROP TABLE IF EXISTS snf_accounts");
    }
}
