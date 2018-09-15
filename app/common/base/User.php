<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/9/15
 * Time: 14:30
 */

namespace app\common\base;

class User
{
    use ErrorTrait;

    public $id;

    public $identity;
    /**
     * @param $identity
     */
    public function loginByIdentity($identity)
    {
        $this->id = $identity->id;
        $this->identity = $identity;
    }
}