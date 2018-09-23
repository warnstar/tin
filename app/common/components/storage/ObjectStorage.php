<?php
/**
 * This file is part of Insurance.
 *
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
    abstract protected function upload($filePath, $savePath = '');

    /**
     * 获取上传凭据
     * @return mixed
     */
    abstract protected function getUploadToken();

    /**
     * 文件删除
     *
     * @param $key
     * @return mixed
     */
    abstract protected function delete($key);

    /**
     * 获取文件格式
     * @param $type
     * @return mixed
     */
    abstract protected function getOption($type);
}
