<?php

namespace core;

class Request
{
    public const METHOD_POST = 'POST';
    public const METHOD_GET = 'GET';

    private $urlParameters;
    private $currentRouteName;

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

        return substr($path,0, $paramPos);
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
            $return = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
            return is_null($return) ? [] : $return;
        }

        if ($this->isPost() && $_SERVER['CONTENT_TYPE'] === 'application/json') {
            $_POST = json_decode(file_get_contents('php://input'), true);
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            return $data;
        }

        $return = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        return is_null($return) ? [] : $return;
    }

    public function setUrlParameters(array $parameters): void
    {
        $this->urlParameters = $parameters;
    }

    public function getUrlParameters(): array
    {
        return $this->urlParameters;
    }

    public function getCurrentRouteName(): string
    {
        return $this->currentRouteName;
    }

    public function setCurrentRouteName(string $currentRoute): void
    {
        $this->currentRouteName = $currentRoute;
    }
}
