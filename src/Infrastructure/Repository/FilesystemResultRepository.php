<?php

namespace App\Infrastructure\Repository;

use App\Domain\ResultRepositoryInterface;
use App\Infrastructure\Filesystem\Directory;
use function json_encode;
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

        $dir = new Directory($file);

        if (!$dir->isExists()) {
            $dir->create();
        }

        file_put_contents($file, self::replace(json_encode($payload, JSON_PRETTY_PRINT)));
    }

    /**
     * @param string $subject
     * @return string
     */
    private static function replace(string $subject)
    {
        $today = \date("Y-m-d");
        $pattern = \sprintf('/"%sT..:..:.."/i', $today);
        $replacement = '"2021-01-01T12:00:00"';

        return \preg_replace($pattern, $replacement, $subject);
    }
}
