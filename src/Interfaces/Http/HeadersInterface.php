<?php
/**
 * This file is part of Tin.
 */
namespace Tin\Interfaces\Http;

use Tin\Interfaces\CollectionInterface;

/**
 * Headers Interface
 *
 * @package Tin
 */
interface HeadersInterface extends CollectionInterface
{
    public function add($key, $value);

    public function normalizeKey($key);
}
