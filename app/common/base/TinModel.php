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
}
