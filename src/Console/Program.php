<?php

namespace App\Console;

use App\Domain\Config;
use App\Infrastructure\ConfigLoader;
use App\Infrastructure\HttpClient\CurlHttpClient;
use App\Infrastructure\Repository\HttpClientResourceRepository;

class Program
{
    /**
     * Composition Root
     * @param string[] $args
     * @return void
     */
    public static function main(array $args)
    {
        $config = Config::fromArray(ConfigLoader::load(__DIR__ . '/../../config.json'));

        $httpClient = new CurlHttpClient();

        $repository = new HttpClientResourceRepository($httpClient, $config);

        \var_dump($repository->get('products'));
    }
}
