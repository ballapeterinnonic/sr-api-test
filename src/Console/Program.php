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
//        $fixtureRepository = new FilesystemFixtureRepository($rootDir . '/fixtures');
        $fixtureRepository = new HttpClientFixtureRepository($httpClient);
        $resultRepository = new FilesystemResultRepository($rootDir . '/var/php7_4');

        $runnables = [
            //ONLY WORKS WITH FilesystemResultRepository
//            'productExtend' => new Runnable('product_extend', 'productExtend', ['GET', 'POST', 'PUT', 'DELETE']),
//            'products' => new Runnable('product', 'products', ['GET', 'POST', 'PUT', 'DELETE']),
//            'orders' => new Runnable('order', 'orders', ['GET', 'POST', 'PUT', 'DELETE']),
//            'categoryExtend' => new Runnable('category_extend', 'categoryExtend', ['GET', 'POST', 'PUT', 'DELETE']),
//            'categories' => new Runnable('category', 'categories', ['GET', 'POST', 'PUT', 'DELETE']),
//            'customerExtend' => new Runnable('customer_extend', 'customerExtend', ['GET', 'POST', 'PUT', 'DELETE']),
//            'customers' => new Runnable('customer', 'customers', ['GET', 'POST', 'PUT', 'DELETE']),
//            'urlAliases' => new Runnable('url_alias', 'urlAliases', ['GET', 'POST', 'PUT', 'DELETE']),
//            'attributeDescriptions' => new Runnable('attribute_description', 'attributeDescriptions', ['GET', 'POST', 'PUT', 'DELETE']),

        //ONLY WORKS WITH HttpClientFixtureRepository
            'attributeWidgetCategoryRelations' => new Runnable('attribute_widget_category_relation', 'attributeWidgetCategoryRelations', ['GET', 'POST', 'PUT', 'DELETE']),
            'attributeWidgetDescriptions' => new Runnable('attribute_widget_description', 'attributeWidgetDescriptions', ['GET', 'POST', 'PUT', 'DELETE']),
            'listAttributes' => new Runnable('list_attribute', 'listAttributes', ['GET', 'POST', 'PUT', 'DELETE']),
            'listAttributeValues' => new Runnable('list_attribute_value', 'listAttributeValues', ['GET', 'POST', 'PUT', 'DELETE']),
            'listAttributeValueDescriptions' => new Runnable('list_attribute_value_description', 'listAttributeValueDescriptions', ['GET', 'POST', 'PUT', 'DELETE']),
            'listAttributeWidgets' => new Runnable('list_attribute_widget', 'listAttributeWidgets', ['GET', 'POST', 'PUT', 'DELETE']),
            'numberAttributes' => new Runnable('number_attribute', 'numberAttributes', ['GET', 'POST', 'PUT', 'DELETE']),
            'numberAttributeValues' => new Runnable('number_attribute_value', 'numberAttributeValues', ['GET', 'POST', 'PUT', 'DELETE']),
            'numberAttributeWidgets' => new Runnable('number_attribute_widget', 'numberAttributeWidgets', ['GET', 'POST', 'PUT', 'DELETE']),
            'numberAttributeWidgetLimits' => new Runnable('number_attribute_widget_limit', 'numberAttributeWidgetLimits', ['GET', 'POST', 'PUT', 'DELETE']),
            'textAttributes' => new Runnable('text_attribute', 'textAttributes', ['GET', 'POST', 'PUT', 'DELETE']),
            'textAttributeValues' => new Runnable('text_attribute_value', 'textAttributeValues', ['GET', 'POST', 'PUT', 'DELETE']),
            'textAttributeValueDescriptions' => new Runnable('text_attribute_value_description', 'textAttributeValueDescriptions', ['GET', 'POST', 'PUT', 'DELETE']),
        ];

        $runner = new Runner($fixtureRepository, $resourceRepository, $resultRepository);

        foreach ($runnables as $runnable) {
            $runner->run($runnable);
        }
    }
}
