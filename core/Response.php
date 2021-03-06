<?php

namespace core;

class Response
{
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect(string $routeName, array $params = [])
    {
        $url = Application::$app->router->generateUrl($routeName, $params);
        header("Location: $url");
        exit;
    }
}
