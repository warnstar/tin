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
 * Class QuestionItem
 * @property int $test_id
 * @property int $user_id
 * @property string $answers
 * @property string $created_at
 * @property string $updated_at
 *
 * @package app\common\models
 */
class TestUserAnswer extends TinModel
{
    public $table = 'ou_test_user_answer';
    
    public $fillable = [
        'test_id',
        'user_id',
        'answers'
    ];

    /**
     * @param $user_id
     * @return self
     */
    public static function getLastOneByUser($user_id)
    {
        return self::query()
            ->where([
                'user_id' => $user_id
            ])
            ->orderBy("id", "DESC")
            ->first();
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function search($params = [])
    {
        $query = self::query();
        $query->select("ou_test_user_answer.*");

        if (isset($params['user_id'])) {
            $query->where(['user_id' => $params['user_id']]);
        }

        if (isset($params['test_id'])) {
            $query->where(['test_id' => $params['test_id']]);
        }

        if (isset($params['status'])) {
            if ($params['status'] === 0 || $params['status'] === '0') {
                $query->whereNull("result");
            } else if ($params['status'] === 1 || $params['status'] === '1') {
                $query->whereNotNull("result");
            }
        }

        if (!empty($params['search'])) {
            $query->leftjoin('ou_user AS u','u.id','=','ou_test_user_answer.user_id');

            $query->where("u.nickname", 'like', "%s{$params['search']}%s");
        }

        $query->orderBy("ou_test_user_answer.id", "ASC");

        $data = $query->get();

        $page = $query->paginate();
        if (isset($params['page'])) {
            $query->offset($page->perPage() * $params['page']);
        }

        $res['data'] = $data;
        $res['page'] = [
            'current_page' => $page->currentPage(),
            'per_page' => $page->perPage(),
            'total' => $page->total()
        ];

        return $res;
    }
}