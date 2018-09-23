<?php
namespace app\common\components;

use EasyWeChat\Work\MiniProgram\Application;
use EasyWeChat\Factory;
use Tin\Component;

class Wechat extends Component
{
    protected $config;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @var $_app \EasyWeChat\MiniProgram\Application
     */
    private static $_app;

    public function mina($config = [])
    {
        $config = $config ? $config :  $this->config['mina'];
        if(!self::$_app || !self::$_app instanceof Application){
            self::$_app = Factory::miniProgram($config);
        }

        return self::$_app;
    }
}