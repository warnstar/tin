<?php
/**
 * This file is part of Tin.
 */
namespace Tin;

class Component
{
    public function __construct($config = [])
    {
        if ($config && is_array($config)) {
            foreach ($config as $k => $v) {
                if (property_exists(get_class($this), $k)) {
                    $this->$k = $v;
                }
            }
        }
    }
}
