<?php
/**
 * This file is part of Tin.
 */
namespace app;

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
     * @param $path
     * @param $data
     */
    public static function file_put_contents($filename, $data, $flags = 0, $context = null)
    {
        if (self::Directory(dirname($filename))) {
            file_put_contents($filename, $data, $flags, $context);
        } else {
            // TODO 异常处理
        }
    }
}
