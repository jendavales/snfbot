<?php

class m0011_profiles
{
    public function init(\core\Database $db): void
    {
        $db->pdo->exec("CREATE TABLE snf_profiles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name TEXT(128),
            quests tinyint(1),
            items tinyint(1),
            items_action tinyint(3),
            items_speed tinyint(3),
            items_sunProtection tinyint(3),
            items_greed tinyint(3),
            quests_gold tinyint(3),
            quests_xp tinyint(3),
            adventures tinyint(1),
            adventures_dinos tinyint(1),
            user INT NOT NULL,
            CONSTRAINT fk_profiles_user FOREIGN KEY (user) REFERENCES snf_users(id) ON DELETE CASCADE
        )  ENGINE=INNODB;");
    }

    public function seed(\core\Database $db): void
    {
        $profiles = [
            \Models\Profile::createDefaultXp(),
            \Models\Profile::createDefaultGold(),
        ];

        $query = $db->pdo->prepare("
            INSERT INTO snf_profiles
                (name, user, items, items_action, items_speed, items_sunProtection, items_greed, quests, quests_xp, quests_gold, adventures, adventures_dinos)
            VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        /** @var \Models\Profile $profile */
        foreach ($profiles as $profile) {
            $profile->user = 1;
            $query->execute(array_values($profile->toArray($profile->dbAttributes())));
        }
    }

    public function drop(\core\Database $db): void
    {
        $db->pdo->exec("DROP TABLE IF EXISTS snf_profiles");
    }
}
