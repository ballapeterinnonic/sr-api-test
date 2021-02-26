<?php

namespace App\Domain;

interface ResultRepositoryInterface
{
    /**
     * @param string $name
     * @param string $method
     * @param array|null $payload
     * @return void
     */
    public function save(string $name, string $method, $payload);
}
