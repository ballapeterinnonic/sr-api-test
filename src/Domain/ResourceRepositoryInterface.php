<?php

namespace App\Domain;

interface ResourceRepositoryInterface
{
    /**
     * @param string $name
     * @return array
     */
    public function get(string $name);

    /**
     * @param string $name
     * @param array $payload
     * @return array
     */
    public function post(string $name, array $payload);
}
