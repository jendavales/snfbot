<?php

namespace core;

class Request
{
    public const METHOD_POST = 'POST';
    public const METHOD_GET = 'GET';

    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'];

        if (strlen($GLOBALS["params"]['server_subdirectory']) > 0) {
            $path = substr($path, strlen($GLOBALS["params"]['server_subdirectory']));
        }

        $paramPos = strpos($path, '?');

        if ($paramPos === false) {
            return $path;
        }

        return $path;
    }

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
