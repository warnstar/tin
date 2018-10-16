<?php
/**
 * This file is part of Tin.
 */
namespace app\wechat\controllers;

use app\common\helpers\ApiResponse;
use app\common\models\UserWechatFormId;
use Tin\Controller;

class WechatCommonController extends Controller
{
    public function submitFormId()
    {
        $form_ids = $this->request->getParsedBodyParam('form_ids');
        if (!$form_ids) {
            return ApiResponse::error('PARAM', '请传入formid');
        }

        try {
            $oks = [];
            foreach ($form_ids as $form_id) {
                $one = new UserWechatFormId();
                $one->user_id = $this->request->user->id;
                $one->open_id = $this->request->user->identity->open_id;
                $one->form_id = $form_id;

                if ($one->save()) {
                    $oks[] = $one->form_id;
                }
            }

            return $oks;
        } catch (\Exception $e) {
            return ApiResponse::error('PARAM', $e->getMessage());
        }
    }
}
