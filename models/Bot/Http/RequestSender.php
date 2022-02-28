<?php

namespace models\Bot\Http;

class RequestSender
{
    public static function sendOne(Request $request): void
    {
        $request->setResult(curl_exec($request->curl));
        curl_close($request->curl);
        $request->curl = null;
    }

    public static function sendMulti(array $requests): void
    {
        $curlMulti = curl_multi_init();

        /** @var Request $request */
        foreach ($requests as $request) {
            curl_multi_add_handle($curlMulti, $request->curl);
        }

        $index = null;
        do {
            curl_multi_exec($curlMulti, $index);
        } while ($index > 0);

        /** @var Request $request */
        foreach ($requests as $request){
            $request->setResult(curl_multi_getcontent($request->curl));
            curl_multi_remove_handle($curlMulti, $request->curl);
            $request->curl = null;
        }

        curl_multi_close($curlMulti);
    }
}
