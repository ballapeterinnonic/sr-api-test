<?php

namespace App\Console;

use App\Domain\Config;
use App\Domain\Runable;
use App\Domain\Runner;
use App\Infrastructure\ConfigLoader;
use App\Infrastructure\Repository\FilesystemFixtureRepository;
use App\Infrastructure\Repository\HttpClientFixtureRepository;
use App\Infrastructure\HttpClient\CurlHttpClient;
use App\Infrastructure\Repository\FilesystemResultRepository;
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
        $resourceRepository = new HttpClientResourceRepository($httpClient, $config);
        $fixtureRepository = new FilesystemFixtureRepository(__DIR__ . '/../../fixtures');
//        $fixtureRepository = new HttpClientFixtureRepository($httpClient);
        $resultRepository = new FilesystemResultRepository(__DIR__ . '/../../var/php7_2');

        $resources = [
//            'productExtend',
//            'products',
//            'orderExtend',
//            'orders',
//            'categoryExtend',
//            'categories',
//            'customerExtend',
            'customers' => new Runable('customer', 'customers', ['GET', 'POST', 'PUT', 'DELETE']),
//            'urlAliases' => ['name' => 'url_alias', 'methods' => ['POST']],
        ];

        $runner = new Runner($fixtureRepository, $resourceRepository, $resultRepository);

        foreach ($resources as $runable) {
            $runner->run($runable);
        }
    }
}
