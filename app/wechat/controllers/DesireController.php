<?php
/**
 * This file is part of Tin.
 */
namespace app\wechat\controllers;

use app\common\helpers\ApiResponse;
use app\common\models\Desire;
use app\common\models\DesireUser;
use app\common\models\Test;
use Tin\Controller;

class DesireController extends Controller
{
    public function index()
    {
        $res = Desire::query()->get();

        return ApiResponse::success($res);
    }

    public function userSave()
    {
        $post = $this->request->getParsedBody();

        if (empty($post['test_id'])) {
            return ApiResponse::error('PARAM', '请传入test_id');
        } else {
            if (!Test::getOneById($post['test_id'])) {
                return ApiResponse::error('NOT_FOUND', '测试对象不存在');
            }
        }

        if (empty($post['selects'])) {
            return ApiResponse::error('PARAM', '请传入selects');
        }

        $validSelectsObj = Desire::getValidIds($post['selects']);
        $validSelects = $validSelectsObj ? array_column($validSelectsObj->toArray(), 'id') : [];

        if ($validSelects) {
            $one = new DesireUser();
            $one->user_id = $this->request->user->id;
            $one->test_id = $post['test_id'];
            $one->selects = json_encode($validSelects, JSON_UNESCAPED_UNICODE);

            try {
                if ($one->save()) {
                    return ApiResponse::success();
                } else {
                    return ApiResponse::error('PARAM', '入库失败');
                }
            } catch (\Exception $e) {
                return ApiResponse::error('PARAM', $e->getMessage());
            }
        } else {
            return ApiResponse::error('PARAM', '请提交有效选择');
        }
    }
}
