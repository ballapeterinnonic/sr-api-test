<?php

namespace App\Infrastructure\Repository;

use App\Domain\Config;
use App\Domain\ResourceRepositoryInterface;
use App\Infrastructure\HttpClient\HttpClientInterface;
use function base64_encode;
use function sprintf;

class HttpClientResourceRepository implements ResourceRepositoryInterface
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var Config
     */
    private $config;

    /**
     * CurlResourceRepository constructor.
     * @param HttpClientInterface $httpClient
     * @param Config $config
     */
    public function __construct(HttpClientInterface $httpClient, Config $config)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    /**
     * @param string $name
     * @return array
     */
    public function get(string $name)
    {
        $url = sprintf('%s/%s', $this->config->getUrl(), $name);

        return $this->httpClient->get($url, [
            'Accept: application/json',
            sprintf('Authorization: Basic %s', self::encodeAuth($this->config->getAuth())),
        ]);
    }

    /**
     * @param array $auth
     * @return string
     */
    private static function encodeAuth(array $auth)
    {
        return base64_encode(sprintf('%s:%s', $auth['username'], $auth['password']));
    }
}
