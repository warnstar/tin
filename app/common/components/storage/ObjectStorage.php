<?php
/**
 * This file is part of Tin.
 */

namespace app\common\components\storage;

use Tin\Component;

abstract class ObjectStorage extends Component
{
    /**
     * 服务端文件上传
     *
     * @param $filePath
     * @param string $savePath
     * @return mixed
     */
    abstract public function upload($filePath, $savePath = '');

    /**
     * 获取上传凭据
     * @return mixed
     */
    abstract public function getUploadToken();

    /**
     * 文件删除
     *
     * @param $key
     * @return mixed
     */
    abstract public function delete($key);

    /**
     * 获取文件格式
     * @param $type
     * @return mixed
     */
    abstract public function getOption($type);
}
