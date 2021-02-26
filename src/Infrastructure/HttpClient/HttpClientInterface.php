<?php

namespace App\Infrastructure\HttpClient;

interface HttpClientInterface
{
    /**
     * @param string $url
     * @param array $headers
     * @return array
     */
    public function get(string $url, array $headers);

    /**
     * @param string $url
     * @param array $headers
     * @param array $payload
     * @return array
     */
    public function post(string $url, array $headers, array $payload);

    /**
     * @param string $url
     * @param array $headers
     * @param array $payload
     * @return array
     */
    public function put(string $url, array $headers, array $payload);

    /**
     * @param string $url
     * @param array $headers
     * @return array
     */
    public function delete(string $url, array $headers);
}
