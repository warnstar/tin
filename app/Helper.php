<?php
/**
 * This file is part of Tin.
 */

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;

            case 'false':
            case '(false)':
                return false;
        }

        return $value ? $value : $default;
    }
}

if (!function_exists('printConsole')) {
    function printConsole($var)
    {
        dump($var);
    }
}
