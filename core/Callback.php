<?php

namespace core;

class Callback
{
    private $class;
    private $functionName;
    private $parameters;

    public function __construct(string $class, string $functionName, array $parameters = [])
    {
        $this->class = $class;
        $this->functionName = $functionName;
        $this->parameters = $parameters;
    }

    public function getClass(): string
    {
        return $this->class;
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
