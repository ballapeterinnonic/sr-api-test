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
}
