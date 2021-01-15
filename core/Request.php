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

    public function isPost(): bool
    {
        return $this->getMethod() === self::METHOD_POST;
    }

    public function isGet(): bool
    {
        return $this->getMethod() === self::METHOD_GET;
    }

    public function getBody(): array
    {
        $data = [];
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }
}
