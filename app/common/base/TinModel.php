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


    public function load($data = [])
    {
        $attrs = $this->getAttributes();
        foreach ($attrs as $one) {
            if (isset($data[$one])) {
                $this->setAttribute($one, $data[$one]);
            }
        }

        return true;
    }
}
