<?php

namespace App\Infrastructure;

use RuntimeException;
use function file_exists;
use function file_get_contents;
use function json_decode;

class ConfigLoader
{
    /**
     * @param string $path
     * @return array
     */
    public static function load($path)
    {
        if (!file_exists($path)) {
            throw new RuntimeException('The config file does not exist!');
        }

        $file = file_get_contents($path);

        return json_decode($file, true);
    }
}
