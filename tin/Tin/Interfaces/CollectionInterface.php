<?php
/**
 * This file is part of Tin.
 */
namespace Tin\Interfaces;

/**
 * Collection Interface
 *
 * @package Tin
 * @since   3.0.0
 */
interface CollectionInterface extends \ArrayAccess, \Countable, \IteratorAggregate
{
    public function set($key, $value);

    public function get($key, $default = null);

    public function replace(array $items);

    public function all();

    public function has($key);

    public function remove($key);

    public function clear();
}
