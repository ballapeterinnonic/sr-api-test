<?php

namespace App\Domain;

interface FixtureRepositoryInterface
{
    /**
     * @param string $name
     * @param string $method
     * @return array
     */
    public function get(string $name, string $method);
}
