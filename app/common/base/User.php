<?php
/**
 * This file is part of Tin.
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
