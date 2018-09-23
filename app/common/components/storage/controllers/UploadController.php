<?php
/**
 * This file is part of Insurance.
 *
 */
namespace app\common\components\storage\controllers;

use app\common\helpers\ApiResponse;
use Tin\Controller;
use Tin\Tin;

class UploadController extends Controller
{
    /**
     * 上传--用户单文件
     * @return mixed
     */
    public function upload()
    {
        $files = $this->request->getUploadedFiles();

        if ($files) {
            $file = array_pop($files);

            $res = Tin::$app->storage->upload($file);

            if (is_object($res)) {
                return ApiResponse::error('PARAM', $res->message());
            } else {
                $info = [
                    'key'   =>  $res,
                    'url'    =>  Tin::$app->storage->getLink($res)
                ];
                return ApiResponse::success($info);
            }
        }
        return ApiResponse::error('PARAM', '上传失败');
    }
}
