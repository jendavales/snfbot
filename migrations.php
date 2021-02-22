<?php

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config/parameters.php';
require_once __DIR__ . '/core/Database.php';

$db = new \core\Database($GLOBALS['params']['db_server'], $GLOBALS['params']['db_name'], $GLOBALS['params']['db_login'], $GLOBALS['params']['db_password']);

$shouldDoAll = in_array('all', $argv);
$shouldSeed = in_array('seed', $argv);

$completedMigrations = loadCompletedMigrations($db);
$existingMigrations = scandir(__DIR__ . '/migrations/');
$filesToBeApplied = $shouldDoAll ? $existingMigrations : array_diff($existingMigrations, $completedMigrations);

$newMigrations = [];
foreach ($filesToBeApplied as $migration) {
    if ($migration === '.' || $migration === '..') {
        continue;
    }

    processMigration($migration, $db, $shouldDoAll, $shouldSeed);
    $newMigrations[] = $migration;
}

saveNewMigrations($newMigrations, $db, $shouldDoAll);

function loadCompletedMigrations(\core\Database $db): array
{
    $db->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;");

    $result = $db->pdo->query('SELECT migration FROM migrations')->fetchAll(PDO::FETCH_COLUMN);

    if ($result === false) {
        return [];
    }

    return $result;
}

function processMigration(string $migration, \core\Database $db, bool $shouldDoAll = false, bool $shouldSeed = false): void
{
    require_once __DIR__ . '/migrations/' . $migration;
    $className = pathinfo($migration, PATHINFO_FILENAME);
    $instance = new $className();

    if ($shouldDoAll) {
        echo 'Dropping ' . $migration . PHP_EOL;
        $db->pdo->exec('SET FOREIGN_KEY_CHECKS=0;');
        $instance->drop($db);
        $db->pdo->exec('SET FOREIGN_KEY_CHECKS=1;');
    }

    echo 'Migrating ' . $migration . PHP_EOL;
    $instance->init($db);

    if ($shouldSeed) {
        $instance->seed($db);
        echo 'Seeding ' . $migration . PHP_EOL;
    }
}

function saveNewMigrations(array $migrations, \core\Database $db, bool $deleteOld = false): void
{
    if ($deleteOld) {
        $query = $db->pdo->exec('DELETE FROM migrations');
    }

    $query = $db->pdo->prepare('INSERT INTO migrations (migration) VALUES (:migration)');

    foreach ($migrations as $migration) {
        $query->bindValue(':migration', $migration);
        $query->execute();
    }
}
