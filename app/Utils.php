<?php
/**
 * This file is part of Tin.
 */
namespace app;

use Swoole\Async;

class Utils
{
    /**
     * @param $dir
     * @return bool
     */
    public static function Directory($dir)
    {
        return  is_dir($dir) or self::Directory(dirname($dir)) and  mkdir($dir, 0777);
    }

    /**
     * @param $filename
     * @param $data
     * @param int $flags
     * @param callable|null $callback
     * @return bool
     */
    public static function file_put_contents($filename, $data, $flags = 0,  callable $callback = null)
    {
        if (self::Directory(dirname($filename))) {
            if (Async::writeFile($filename, $data, $callback, $flags)) {
                return true;
            }
        }

        return false;
    }
}
