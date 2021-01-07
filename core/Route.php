<?php

namespace core;

class Route
{
    private $path;
    private $method;
    private $controller;
    private $functionName;
    private $parameters;
    private $regex;

    public function __construct(string $path, string $method, string $controller, string $function)
    {
        $this->path = $path;
        $this->controller = $controller;
        $this->functionName = $function;
        $this->method = $method;
        $this->parameters = [];

        $count = preg_match_all('/{([a-zA-Z]*)}/', $path, $variableNames);
        $regex = $path;

        for ($i = 0; $i < $count; $i++) {
            $this->parameters[] = $variableNames[1][$i];
            $regex = str_replace($variableNames[0][$i], '([0-9a-zA-Z]*)', $regex);
        }

        $this->regex = '~^' . $regex . '$~';
    }

    public function getUrl(array $parameters, bool $absolute = false): string
    {
        if (count($parameters) !== count($this->getParameters())) {
            //todo: create exception
            throw new \Exception('Not enough parameters');
        }

        if (!$absolute) {
            return $this->path;
        }

        return $GLOBALS['params']['server_host'] . $GLOBALS['params']['server_subdirectory'] . $this->path;
    }

    public function getRegex(): string
    {
        return $this->regex;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getCallback(): Callback
    {
        return new Callback($this->controller, $this->functionName);
    }
}
