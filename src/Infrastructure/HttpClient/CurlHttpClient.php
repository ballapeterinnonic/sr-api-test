<?php

namespace App\Infrastructure\HttpClient;

use function curl_close;
use function curl_exec;
use function curl_init;
use function curl_setopt_array;
use function json_decode;
use const CURLOPT_CUSTOMREQUEST;
use const CURLOPT_ENCODING;
use const CURLOPT_FOLLOWLOCATION;
use const CURLOPT_HTTPHEADER;
use const CURLOPT_MAXREDIRS;
use const CURLOPT_RETURNTRANSFER;
use const CURLOPT_TIMEOUT;
use const CURLOPT_URL;

class CurlHttpClient implements HttpClientInterface
{
    /**
     * @param string $url
     * @param array $headers
     * @return array
     */
    public function get(string $url, array $headers)
    {
        $response = self::exec([
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $headers,
        ]);

        return json_decode($response, true);
    }

    /**
     * @param array $options
     * @return bool|string
     */
    private static function exec(array $options)
    {
        $handle = curl_init();

        curl_setopt_array($handle, $options);

        $response = curl_exec($handle);

        curl_close($handle);

        return $response;
    }
}
