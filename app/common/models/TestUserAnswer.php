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
 * @property string $result
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Test $test
 * @property User $user
 *
 * @package app\common\models
 */
class TestUserAnswer extends TinModel
{
    public $table = 'ou_test_user_answer';
    
    public $fillable = [
        'test_id',
        'user_id',
        'result',
        'answers'
    ];

    /**
     * @param $id
     * @return self
     */
    public static function getOneById($id)
    {
        return self::query()->where('id', '=', $id)->first();
    }

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
     * @return User
     */
    public function getUser()
    {
        return User::query()->where(['id' => $this->user_id])->first();
    }

    /**
     * @return Test
     */
    public function getTest()
    {
        return Test::query()->where(['id' => $this->test_id])->first();
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

        return $data;
    }
}