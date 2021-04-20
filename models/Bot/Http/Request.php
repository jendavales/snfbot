<?php

namespace models\Bot\Http;

use models\Bot\Bot;

class Request
{
    public $bot;
    public $curl;
    public $result;

    public function __construct(Bot $bot, $curl) {
        $this->bot = $bot;
        $this->curl = $curl;
        $this->result = null;
    }

    public function setResult(string $result) {
        $this->result = $result;
        $this->bot->setLastDownload($result);
    }
}
