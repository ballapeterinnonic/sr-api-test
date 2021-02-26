<?php

namespace App\Infrastructure\Fixture;

use App\Domain\FixtureRepositoryInterface;
use App\Infrastructure\HttpClient\HttpClientInterface;
use function str_replace;
use function strtolower;

class HttpClientFixtureRepository implements FixtureRepositoryInterface
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var string
     */
    private $url;

    /**
     * HttpClientFixtureRepository constructor.
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->url = 'https://raw.githubusercontent.com/Shoprenter/sr-api-docs/master/fixtures/api/{{name}}/request/{{method}}.json';
    }

    /**
     * @param string $name
     * @param string $method
     * @return array
     */
    public function get(string $name, string $method)
    {
        $method = strtolower($method);

        $url = str_replace(['{{name}}', '{{method}}'], [$name, $method], $this->url);

        return $this->httpClient->get($url, []);
    }
}
