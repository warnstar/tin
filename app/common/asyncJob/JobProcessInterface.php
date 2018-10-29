<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/10/26
 * Time: 23:54
 */
namespace app\common\asyncJob;


interface JobProcessInterface {

    /**
     * @param $data
     * @throws JobFailException
     */
    public function process($data = null);
}