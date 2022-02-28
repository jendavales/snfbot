<?php

namespace core;

class Callback
{
    private $controllerClass;
    private $functionName;
    private $parameters;

    public function __construct(string $class, string $functionName, array $parameters = [])
    {
        $this->controllerClass = $class;
        $this->functionName = $functionName;
        $this->parameters = $parameters;
    }

    public function getControllerClass(): string
    {
        return $this->controllerClass;
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
