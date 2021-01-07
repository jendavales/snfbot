<?php

namespace core;

class Response
{
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect(string $routeName)
    {
        $url = Application::$app->router->resolve();
        header("Location: ");
    }
}
