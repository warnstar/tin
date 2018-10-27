<?php
/**
 * This file is part of Tin.
 */

namespace Tin;

class ConsoleTin extends Tin
{
    public function run()
    {
        $args = current(func_get_args());

        array_shift($args);
        self::$app->console->execute($args);
    }
}