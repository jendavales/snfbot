<?php

namespace models\Bot\Http;

use models\Bot\Bot;

class RequestCreator
{
    public static function preparePost(Bot $bot, string $url, array $data = []): Request
    {
        $data_string = http_build_query($data);
        $curl = self::prepareCurl($bot->getCookiesFile());
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        return new Request($bot, $curl);
    }

    public static function prepareGet(Bot $bot, string $url): Request
    {
        $curl = self::prepareCurl($bot->getCookiesFile());
        curl_setopt($curl, CURLOPT_URL, $url);

        return new Request($bot, $curl);
    }

    private static function prepareCurl(string $cookies)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookies);

        return $ch;
    }
}
