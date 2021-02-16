<?php

require_once __DIR__.'/functions.php';
require_once __DIR__.'/config/parameters.php';

function autoload(string $class) {
    include $class.'.php';
}

spl_autoload_register('autoload');
