<?php

namespace App\Console;

use App\Domain\Config;
use App\Domain\Runnable;
use App\Domain\Runner;
use App\Infrastructure\ConfigLoader;
use App\Infrastructure\Repository\FilesystemFixtureRepository;
use App\Infrastructure\Repository\HttpClientFixtureRepository;
use App\Infrastructure\HttpClient\CurlHttpClient;
use App\Infrastructure\Repository\FilesystemResultRepository;
use App\Infrastructure\Repository\HttpClientResourceRepository;
use function dirname;

class Program
{
    /**
     * Composition Root
     * @param string[] $args
     * @return void
     */
    public static function main(array $args)
    {
        $rootDir = dirname(__DIR__, 2);

        $config = Config::fromArray(ConfigLoader::load($rootDir . '/config.json'));

        $httpClient = new CurlHttpClient();
        $resourceRepository = new HttpClientResourceRepository($httpClient, $config);
        $fixtureRepository = new FilesystemFixtureRepository($rootDir . '/fixtures');
//        $fixtureRepository = new HttpClientFixtureRepository($httpClient);
        $resultRepository = new FilesystemResultRepository($rootDir . '/var/php7_2');

        $runnables = [
            'productExtend' => new Runnable('product_extend', 'productExtend', ['GET', 'POST', 'PUT', 'DELETE']),
            'products' => new Runnable('product', 'products', ['GET', 'POST', 'PUT', 'DELETE']),
//            'orderExtend',
            'orders' => new Runnable('order', 'orders', ['GET', 'POST', 'PUT', 'DELETE']),
//            'categoryExtend',
//            'categories',
            'customerExtend' => new Runnable('customer_extend', 'customerExtend', ['GET', 'POST', 'PUT', 'DELETE']),
            'customers' => new Runnable('customer', 'customers', ['GET', 'POST', 'PUT', 'DELETE']),
//            'urlAliases' => ['name' => 'url_alias', 'methods' => ['POST']],
        ];

        $runner = new Runner($fixtureRepository, $resourceRepository, $resultRepository);

        foreach ($runnables as $runnable) {
            $runner->run($runnable);
        }
    }
}
