<?php

namespace App\Domain;

interface ResourceRepositoryInterface
{
    /**
     * @param string $name
     * @return array
     */
    public function get(string $name);
}
