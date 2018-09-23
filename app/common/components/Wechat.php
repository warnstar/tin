<?php
namespace app\common\components;

use EasyWeChat\Work\MiniProgram\Application;
use EasyWeChat\Factory;
use Tin\Component;

class Wechat extends Component
{
    public $config;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @var $_app \EasyWeChat\MiniProgram\Application
     */
    private static $_apps;

    public function mina($config = [])
    {
        $config = $config ? $config :  $this->config['mina'];

        if(empty($this->config['mina']) || !$this->config['mina'] instanceof Application){
            self::$_apps['mina'] = Factory::miniProgram($config);
        }

        return self::$_apps['mina'];
    }
}