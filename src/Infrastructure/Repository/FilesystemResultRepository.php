<?php

namespace App\Infrastructure\Repository;

use App\Domain\ResultRepositoryInterface;
use RuntimeException;
use function dirname;
use function file_exists;
use function is_dir;
use function json_encode;
use function mkdir;
use function sprintf;
use function strtolower;
use const JSON_PRETTY_PRINT;

class FilesystemResultRepository implements ResultRepositoryInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * FilesystemResultRepository constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @param string $name
     * @param string $method
     * @param array|null $payload
     * @return void
     */
    public function save(string $name, string $method, $payload)
    {
        $name = strtolower($name);
        $method = strtolower($method);

        $file = sprintf('%s/%s/%s.json', $this->path, $name, $method);

        $dir = dirname($file);

        if (!file_exists($dir)) {
            $this->createDir($dir);
        }

        file_put_contents($file, json_encode($payload, JSON_PRETTY_PRINT));
    }

    /**
     * @param string $dir
     * @return void
     */
    private function createDir(string $dir)
    {
        if (!mkdir($dir, 0777, true) && !is_dir($dir)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }
    }
}
