<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/10/27
 * Time: 0:32
 */

namespace app\common\asyncJob\jobs;

use app\common\asyncJob\JobProcessInterface;

class TestJob implements JobProcessInterface
{
    const KEY = 'TestJob';

    public function process($data = null)
    {
        dump($data);
    }
}