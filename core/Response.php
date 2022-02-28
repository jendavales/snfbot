<?php

namespace core;

class Response
{
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const ERROR = 500;

    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect(string $routeName, array $params = []): void
    {
        $url = Application::$app->router->generateUrl($routeName, $params);
        header("Location: $url");
        exit;
    }

    public function redirectBack(): void
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function redirectUrl(string $url): void
    {
        header("Location: $url");
        exit;
    }
}
