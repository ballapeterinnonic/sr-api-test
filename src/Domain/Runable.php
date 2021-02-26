<?php

namespace App\Domain;

use function in_array;
use function strtoupper;

class Runable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $route;

    /**
     * @var array
     */
    private $methods;

    /**
     * Runable constructor.
     * @param string $name
     * @param string $route
     * @param array $methods
     */
    public function __construct(
        string $name,
        string $route,
        array $methods
    ) {
        $this->name = $name;
        $this->route = $route;
        $this->methods = $methods;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $method
     * @return bool
     */
    public function isMethodAvailable(string $method): bool
    {
        return in_array(strtoupper($method), $this->methods, true);
    }
}
