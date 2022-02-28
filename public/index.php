<?php

require_once '../autoload.php';

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

$app = new \core\Application(dirname(__DIR__));

if ($GLOBALS['params']['env'] === 'dev') {
    shell_exec('php ../routes.php');
}

$app->run();
