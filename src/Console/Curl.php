<?php

namespace App\Console;

class Curl
{
    /**
     * @param array $options
     * @return bool|string
     */
    public static function exec(array $options)
    {
        $handle = curl_init();

        curl_setopt_array($handle, $options);

        $response = curl_exec($handle);

        curl_close($handle);

        return $response;
    }
}
