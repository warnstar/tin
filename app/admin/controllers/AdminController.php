<?php
/**
 * This file is part of Tin.
 */
namespace app\admin\controllers;

use app\admin\models\Admin;
use app\common\helpers\ApiResponse;
use Tin\Controller;
use Tin\Tin;

class AdminController extends Controller
{
    public function detail()
    {
        $admin = Admin::getOneById($this->request->user->id);

        if ($admin) {
            return ApiResponse::success($admin);
        } else {
            return ApiResponse::error('PARAM', '用户不存在');
        }
    }
}
