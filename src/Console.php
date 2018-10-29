<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/10/24
 * Time: 23:28
 */
namespace Tin;

class Console
{
    private static $routes;

    const ExitOk = 0;
    const ExitError = 1;

    public function __construct(array $routes)
    {
        self::$routes = $routes;
    }

    public function execute($args)
    {
        $action = trim(array_shift($args));

        if (!$action || empty(self::$routes[$action])) {
            $str = "";
            if (self::$routes) foreach (self::$routes as $k => $v) {
                $str .= sprintf("\t\t  %s \n", $k);
            }
            echo sprintf("\e[33m请运行以下命令：\n \033[32m %s\n\033[0m", $str);

            exit(self::ExitOk);
        }

        /**
         * @var $actionObj ConsoleActionInterface
         */
        $actionObj = new self::$routes[$action]();

        return $actionObj->run($args);
    }
}