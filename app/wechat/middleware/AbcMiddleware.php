<?php
/**
 * This file is part of Tin.
 */
namespace app\middleware;

use Tin\Http\Request;
use Tin\Middleware\Middleware;

class AbcMiddleware extends Middleware
{
    public function handle(Request $request)
    {
        echo __CLASS__ . "\n";
        yield;
        echo __CLASS__ . "end \n";
    }
}
