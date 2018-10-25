<?php
/**
 * This file is part of Tin.
 */

namespace Tin;

class Tin extends BaseTin
{
    public function run()
    {
        self::$app->router->init();
        self::$app->server->run();
    }
}
