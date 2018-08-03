<?php
/**
 * This file is part of Tin.
 */
namespace Tin\Interfaces\Http;

/**
 * Cookies Interface
 *
 * @package Tin
 */
interface CookiesInterface
{
    public function get($name, $default = null);

    public function set($name, $value);

    public function toHeaders();

    public static function parseHeader($header);
}
