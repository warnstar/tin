<?php
/**
 * This file is part of Tin.
 */
namespace app\common\components\storage\instance;

use app\common\components\storage\ObjectStorage;
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

/**
 * ~~~
 * composer require "qiniu/php-sdk": "^7.2"
 * ~~~
 * env配置：
    qiniu.https = true
    qiniu.domain = oss.aaa.com/
    qiniu.bucket = aaa
    qiniu.access_key = aaa
    qiniu.secret_key = aaa
    qiniu.server_addr = http://7xob9a.com2.z0.glb.qiniucdn.com/

 * @author wchuang <wchuang@aliyun.com>
 */
class Qiniu extends ObjectStorage
{
    public $auth;

    public $domain = '';

    public $bucket = '';

    private $_token = '';

    public $accessKey = '';             //访问Key

    public $secreKey = '';

    //空间名
    public $server_address = '';             //服务器地址

    public $format = [
        'icon' => '?imageView2/2/w/240/h/240',
        'list' => '?imageView2/2/w/480',
        'view' => '?imageView2/2/w/640',
        'detail' => '?imageView2/2/w/1280',
    ];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->init();
    }

    public function init()
    {
        //初始化
        $this->auth = new Auth($this->accessKey, $this->secreKey);

        $this->_token = $this->auth->uploadToken($this->bucket);
    }

    public function upload($file, $savePath = '')
    {
        //存入的文件路径
        $path = $savePath . date('Y-m-d', time()) . ':' . uniqid('', false) . '.jpg';

        //初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($this->_token, $path, $file->file, null, 'application/octet-stream', false);


        if ($err !== null) {
            return $err;
        } else {
            //返回url
            return $ret['key'];
        }
    }

    /**
     * 获取上传token
     * @return string
     */
    public function getUploadToken()
    {
        return $this->_token;
    }

    /**
     * 图片删除
     *
     * @param $object ，图片的存储路径
     * @return mixed 成功返回NULL，失败返回对象{"error" => "<errMsg string>", ...}
     */
    public function delete($key, $checkUrl = true)
    {
        if ($checkUrl) {
            $arr1 = explode('[', $key);
            if (isset($arr1[1])) {
                $key = '[' . $arr1[1];
            }
        }

        //去掉七牛的链接，取到文件名
        $bucket = $this->bucket;

        $bucketManager = new BucketManager($this->auth);
        return $bucketManager->delete($bucket, $key);
    }

    /**
     * 获取图片格式
     * @param string $type
     * @return mixed
     */
    public function getOption($type = '')
    {
        if (in_array($type, $this->format, null)) {
            return $this->format[$type];
        } else {
            return $this->format['view'];
        }
    }

    /**
     * 可以传输的base64编码
     * @param $str
     * @return mixed
     */
    public static function urlBase64Encode($str)
    {
        $find = ['+', '/'];
        $replace = ['-', '_'];
        return str_replace($find, $replace, base64_encode($str));
    }

    /**
     * 获取文件下载资源链接
     * @param string $key
     * @return string
     */
    public function getLink($key = '')
    {
        $https = getenv('qiniu.https') == 'false' ? false : true;

        return ($https ? 'https://' : 'http://') . rtrim($this->domain, '/') . "/{$key}";
    }

    /**
     * 检查对象
     * @param $key
     * @return mixed
     */
    public function checkObject($key, $bucket = '')
    {
        //初始化BucketManager
        $bucketMgr = new BucketManager($this->auth);

        $bucket = $bucket ? $bucket : $this->bucket;
        //获取文件的状态信息a
        list($ret, $err) = $bucketMgr->stat($bucket, $key);
        if ($err !== null) {
            return $err;
        } else {
            return $ret;
        }
    }
}
