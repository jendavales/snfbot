<?php

require_once '../autoload.php';

$app = new \core\Application(dirname(__DIR__));

if ($GLOBALS['params']['env'] === 'dev') {
    shell_exec('php ../routes.php');
}

$app->run();
