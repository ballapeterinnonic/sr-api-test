<?php

namespace App\Infrastructure\Filesystem;

use RuntimeException;
use function dirname;
use function file_exists;
use function is_dir;
use function mkdir;
use function sprintf;

class Directory
{
    /**
     * @var string
     */
    private $path;

    /**
     * Directory constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = is_dir($path) ? $path : dirname($path);
    }

    /**
     * @return bool
     */
    public function isExists()
    {
        return file_exists($this->path);
    }

    /**
     * @return void
     */
    public function create()
    {
        if (!mkdir($this->path, 0777, true) && !is_dir($this->path)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $this->path));
        }
    }
}
