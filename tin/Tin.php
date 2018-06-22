<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18-6-22
 * Time: 上午10:51
 */

require __DIR__ . '/tin/BaseTin.php';


class Tin extends \tin\base\BaseTin
{
}

spl_autoload_register(['Tin', 'autoload'], true, true);