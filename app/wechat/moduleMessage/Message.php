<?php
/**
 * Created by PhpStorm.
 * User: wchua
 * Date: 2018/10/27
 * Time: 15:58
 */
namespace app\wechat\moduleMessage;

use app\common\asyncJob\AsyncJob;
use app\common\asyncJob\jobs\MinaTplMsgJob;
use app\common\models\User;
use app\common\models\UserWechatFormId;

abstract class Message
{
    const PAGE = "pages/index/index";

    const TPL_ID = '';

    /**
     * @var $user User
     */
    protected $user;
    protected $open_id;
    protected $form_id;

    protected $data = [];

    /**
     * @param int $user_id
     * @return $this
     */
    public function setUser(int $user_id)
    {
        $this->user = User::getOneById($user_id);

        $formInfo = UserWechatFormId::getOneByUserId($user_id);
        $formInfo->used();

        $this->open_id = $formInfo->open_id;
        $this->form_id = $formInfo->form_id;

        return $this;
    }

    public function send()
    {
        $data = [
            'touser' => $this->open_id,
            'template_id' => $this::getTplId(),
            'page' => $this::getPage(),
            'form_id' => $this->form_id,
            'data' => $this->data,
        ];

        return AsyncJob::createJob(MinaTplMsgJob::KEY, $data);
    }

    /**
     * @return string
     */
    abstract static public function getTplId();

    /**
     * @return string
     */
    abstract static public function getPage();


    /**
     * @param null $data
     * @return $this
     */
    abstract public function buildData($data = null);
}