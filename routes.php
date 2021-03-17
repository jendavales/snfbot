<?php

include_once 'core/Route.php';
include_once 'core/Request.php';
include_once 'core/RoutesCollector.php';

$routes = core\RoutesCollector::getRoutes();
$compiledRoutes = [];

foreach ($routes as $routeName => $route) {
    $routeArray = $route->toArray();
    $routeArray['name'] = $routeName;
    $routeArray['regex'] = substr($routeArray['regex'], 2, strlen($routeArray['regex']) - 4);
    $routeArray['parameters'] = $route->getParameters();
    $compiledRoutes[] = $routeArray;
}

$file = fopen(__DIR__."/public/assets/router/compiledRoutes.js", "w");
fwrite($file, 'let routes = '.json_encode($compiledRoutes).';');
fclose($file);
