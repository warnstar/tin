<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/9/17
 * Time: 20:25
 */
namespace app\common\models;

use app\common\base\TinModel;

/**
 * Class Desire
 * @property int $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 *
 * @package app\common\models
 */
class Desire extends TinModel
{
    public $table = 'ou_desire';
    
    public $fillable = [
        'title',
    ];

    /**
     * @param int[] $ids
     */
    public static function getValidIds(array $ids)
    {
        $ids = self::query()->whereIn("id", $ids)
            ->select("id")
            ->get();

        return $ids;
    }

    /**
     * @param $user_id
     * @return self[]
     */
    public static function getUserLast($user_id)
    {
        $query = DesireUser::query();
        $query->where(['user_id' => $user_id]);

        $query->orderBy("id", "DESC");

        $last = $query->first();

        $data = [];
        if ($last) {
            $selectIds = json_decode($last->selects, true);
            $desireSql = Desire::query()
                ->whereIn("id", $selectIds);

            $data = $desireSql->getModels();
        }


        return $data;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function search($params = [])
    {
        $query = Desire::query();

        $page = $query->paginate();


        if (isset($params['page'])) {
            $query->offset($page->perPage() * $params['page']);
        }

        $query->orderByDesc("id");

        $data = $query->get();

        $res['data'] = $data;
        $res['page'] = [
            'current_page' => $page->currentPage(),
            'per_page' => $page->perPage(),
            'total' => $page->total()
        ];

        return $res;
    }
}