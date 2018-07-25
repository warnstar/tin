<?php
/**
 * This file is part of Tin.
 */

require __DIR__ . '/Tin/BaseTin.php';


class Tin extends Tin\BaseTin
{
}

spl_autoload_register(['Tin', 'autoload'], true, true);

define('TIN_BASE_PATH', __DIR__);

require_once  __DIR__ . '/Tin/Bootstrap.php';

require_once  __DIR__ . '/Tin/Helper.php';
