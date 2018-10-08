<?php
/**
 * This file is part of Tin.
 */

namespace app\common\base;

use Illuminate\Database\Eloquent\Model;

class TinModel extends Model
{
    use ErrorTrait;

    /**
     * @param $id
     * @return self
     */
    public static function getOneById($id)
    {
        return self::query()->where('id', '=', $id)->first();
    }

    public function __get($key)
    {
        $value =  parent::__get($key);
        if (!$value) {
            $method = 'get'. ucfirst($key);
            if (method_exists($this, $method)) {
                $res = call_user_func([$this, $method]);
                $this->setAttribute($key, $res);
                return $res;
            }
        }

        return $value;
    }
}
