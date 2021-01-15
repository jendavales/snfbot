<?php

namespace core;

class Route
{
    private $path;
    private $methods;
    private $controller;
    private $functionName;
    private $parameters;
    private $regex;

    public function __construct(string $path, array $methods, string $controller, string $function)
    {
        $this->path = $path;
        $this->controller = $controller;
        $this->functionName = $function;
        $this->methods = $methods;
        $this->parameters = [];

        $count = preg_match_all('/{([0-9a-zA-Z]*)}/', $path, $variableNames);
        $regex = $path;

        for ($i = 0; $i < $count; $i++) {
            $this->parameters[] = $variableNames[1][$i];
            $regex = str_replace($variableNames[0][$i], '([0-9a-zA-Z]*)', $regex);
        }

        $this->regex = '~^' . $regex . '$~';
    }

    public function getUrl(array $parameters = [], bool $absolute = false): string
    {
        if (count($parameters) !== count($this->getParameters())) {
            throw new \Exception('Not enough parameters');
        }

        $url = $this->path;

        foreach ($parameters as $name => $value) {
            $url = str_replace("{$name}", $value, $url);
        }

        if (!$absolute) {
            return $GLOBALS['params']['server_subdirectory'] . $url;
        }

        return $GLOBALS['params']['server_host'] . $GLOBALS['params']['server_subdirectory'] . $url;
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

    public function hasMethod(string $method)
    {
        return in_array($method, $this->methods);
    }
}
