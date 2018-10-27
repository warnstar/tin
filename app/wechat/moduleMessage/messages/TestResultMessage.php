<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/10/27
 * Time: 15:39
 */
namespace app\wechat\moduleMessage\messages;

use app\wechat\moduleMessage\Message;

class TestResultMessage extends Message
{
    public static function getPage()
    {
        return "pages/index/index";
    }

    public static function getTplId()
    {
        return 'dKsjwA7dEoGJOCyaOw16PrLGoN2Rpj3PYa4eQ96VQlo';
    }

    public function buildData($data = null)
    {
        $this->data = array_merge($this->data, [
            'keyword1' => $this->user->nickname,
            'keyword2' => $data['test_result'],
            'keyword3' => $data['test_time'],
            'keyword4' => '进入小程序后“查看我的测试结果”',
        ]);

        return $this;
    }
}