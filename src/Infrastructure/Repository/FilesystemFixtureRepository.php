<?php

namespace App\Infrastructure\Repository;

use App\Domain\FixtureRepositoryInterface;
use RuntimeException;
use function file_exists;
use function file_get_contents;
use function json_decode;
use function sprintf;
use function strtolower;

class FilesystemFixtureRepository implements FixtureRepositoryInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * FilesystemFixtureRepository constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @param string $name
     * @param string $method
     * @return array
     */
    public function get(string $name, string $method)
    {
        $method = strtolower($method);

        $file = sprintf('%s/%s/%s.json', $this->path, $name, $method);

        if (!file_exists($file)) {
            throw new RuntimeException('The fixture file does not exist: ' . $file);
        }

        return json_decode(file_get_contents($file), true);
    }
}
