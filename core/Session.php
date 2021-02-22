<?php

namespace core;

class Session
{
    public const FLASH_SUCCESS = 'success';
    public const FLASH_WARNING = 'warning';
    public const FLASH_FAILURE = 'failure';

    public function __construct()
    {
        session_start();
    }

    public function setFlash($key, $message): void
    {
        $_SESSION['flashMessages'][$key][] = $message;
    }

    public function getFlashMessages($key): array
    {
        $return = $_SESSION['flashMessages'][$key] ?? [];
        $_SESSION['flashMessages'][$key] = [];

        return $return;
    }

    public function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): ?string
    {
        if (!array_key_exists($key, $_SESSION)) {
            return null;
        }

        return $_SESSION[$key];
    }

    public function remove($key): void
    {
        unset($_SESSION[$key]);
    }

}
