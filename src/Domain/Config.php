<?php

namespace App\Domain;

class Config
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $auth;

    /**
     * Config constructor.
     * @param string $url
     * @param array $auth
     */
    public function __construct(string $url, array $auth)
    {
        $this->url = $url;
        $this->auth = $auth;
    }

    /**
     * @param array $config
     * @return static
     */
    public static function fromArray(array $config)
    {
        return new static($config['url'], $config['auth']);
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getAuth(): array
    {
        return $this->auth;
    }
}
