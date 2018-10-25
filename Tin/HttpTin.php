<?php
/**
 * This file is part of Tin.
 */

namespace Tin;

class HttpTin extends Tin
{
    public function run()
    {
        self::$app->router->init();
        self::$app->server->run();
    }
}
