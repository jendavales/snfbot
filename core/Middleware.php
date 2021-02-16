<?php

namespace core;

abstract class Middleware
{
    public abstract function verify(): bool;

    public abstract function handleFailure(): void;
}
