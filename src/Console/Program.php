<?php

namespace App\Console;

use App\Domain\Config;
use App\Domain\ResourceRepositoryInterface;
use App\Infrastructure\ConfigLoader;
use App\Infrastructure\Fixture\HttpClientFixtureRepository;
use App\Infrastructure\HttpClient\CurlHttpClient;
use App\Infrastructure\Repository\HttpClientResourceRepository;
use RuntimeException;
use function var_dump;

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
        $fixtureRepository = new HttpClientFixtureRepository($httpClient);

        $resources = [
//            'productExtend' => ['name' => 'product_extend', 'methods' => ['POST']],
//            'productExtend' => ['name' => 'product_extend', 'methods' => ['GET', 'POST', 'PUT', 'DELETE']],
//            'products',
//            'orderExtend',
//            'orders',
//            'categoryExtend',
//            'categories',
//            'customerExtend',
//            'customers',
            'urlAliases' => ['name' => 'url_alias', 'methods' => ['POST']],
        ];

        foreach ($resources as $route => $data) {
            $fixture = $fixtureRepository->get($data['name'], 'post');

            foreach ($data['methods'] as $method) {
                var_dump(self::call($resourceRepository, $method, $route, $fixture));
            }
        }
    }

    private static function call(ResourceRepositoryInterface $repository, string $method, string $route, array $fixture = [])
    {
        switch ($method) {
            case 'GET':
                return $repository->get($route);
            case 'POST':
                return $repository->post($route, $fixture);
//            case 'PUT':
//                return $repository->put($route, $fixture);
//            case 'DELETE':
//                return $repository->delete($route);
            default:
                throw new RuntimeException('Invalid method given: ' . $method);
        }
    }
}
