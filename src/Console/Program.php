<?php

namespace App\Console;

use function base64_encode;
use function json_decode;
use function sprintf;
use const CURL_HTTP_VERSION_1_1;
use const CURLOPT_CUSTOMREQUEST;
use const CURLOPT_ENCODING;
use const CURLOPT_FOLLOWLOCATION;
use const CURLOPT_HTTP_VERSION;
use const CURLOPT_HTTPHEADER;
use const CURLOPT_MAXREDIRS;
use const CURLOPT_RETURNTRANSFER;
use const CURLOPT_TIMEOUT;
use const CURLOPT_URL;

class Program
{
    /**
     * @param string[] $args
     * @return void
     */
    public static function main(array $args)
    {
        $config = ConfigLoader::load(__DIR__ . '/../../config.json');

        $response = Curl::exec([
            CURLOPT_URL => sprintf('%s/products', $config['url']),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                sprintf('Authorization: Basic %s', self::getAuth($config['auth'])),
            ],
        ]);

        \var_dump(json_decode($response, true));
    }

    /**
     * @param array $auth
     * @return string
     */
    private static function getAuth($auth)
    {
         return base64_encode(sprintf('%s:%s', $auth['username'], $auth['password']));
    }
}
