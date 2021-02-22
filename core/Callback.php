<?php

namespace core;

class Callback
{
    private $controller;
    private $functionName;
    private $parameters;

    public function __construct(string $class, string $functionName, array $parameters = [])
    {
        $this->controller = new $class();
        $this->functionName = $functionName;
        $this->parameters = $parameters;
    }

    public function getController(): Controller
    {
        return $this->controller;
    }

    public function getFunctionName(): string
    {
        return $this->functionName;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function addParameter(string $name, $value): void
    {
        $this->parameters[$name] = $value;
    }
}
