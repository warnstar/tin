<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/10/27
 * Time: 0:32
 */

namespace app\common\asyncJob\jobs;

use app\common\asyncJob\JobFailException;
use app\common\asyncJob\JobProcessInterface;
use Tin\Tin;

class MinaTplMsgJob implements JobProcessInterface
{
    const KEY = 'MinaTplMsgJob';

    public function process($data = null)
    {
        $res = Tin::$app->wechat->mina()->template_message->send($data);

        if (isset($res['errcode']) && $res['errcode'] == 0) {

        } else {
            dump($res);
            throw new JobFailException($res['errmsg']);
        }
    }
}