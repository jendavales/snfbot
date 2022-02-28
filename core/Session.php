<?php

namespace core;

class Session
{
    public const FLASH_SUCCESS = 'success';
    public const FLASH_WARNING = 'warning';
    public const FLASH_FAILURE = 'failure';
    public const FLASH_INFO = 'info';
    private const LAST_URL = 'lastUrl';
    private const TWO_STEPS_BACK_URL = 'lastUrl2';

    public function __construct()
    {
        session_start();
    }

    public function setFlash($key, $message): void
    {
        foreach ($_SESSION['flashMessages'][$key] as $msg) {
            if ($msg === $message) {
                return;
            }
        }
        $_SESSION['flashMessages'][$key][] = $message;
    }

    public function getFlashMessages($key): array
    {
        $return = $_SESSION['flashMessages'][$key] ?? [];
        $_SESSION['flashMessages'][$key] = [];

        return $return;
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key)
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

    public function getLastUrl(): ?string
    {
        return $this->get(self::LAST_URL);
    }

    public function getTwoStepsBackUrl(): ?string
    {
        return $this->get(self::TWO_STEPS_BACK_URL);
    }

    public function setLastUrl(string $url): void
    {
        $this->set(self::TWO_STEPS_BACK_URL, $this->getLastUrl() ?? null);
        $this->set(self::LAST_URL, $url);
    }

}
