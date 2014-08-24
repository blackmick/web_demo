<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 8/20/14
 * Time: 4:37 PM
 */

class MsgController extends SafeController{
    const MT_MSG        = 0;
    const MT_SESSION    = 1;

    /*
     * 发送(创建)消息,包括:
     * 1.邀请
     * 2.回应
     * 3.普通消息
     *
     * @param sid
     * @param rid
     * @param token
     * @param type
     * @param msg
     */
    public function actionCreate(){
        $msgType = DataHelper::getIntReq('type');
        switch($msgType){
            case self::MT_MSG:
                $this->sendMsg();
                break;
            case self::MT_SESSION:
                $this->startSession();
                break;
            default:
                ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PARAM, 'type');
                break;
        }
    }

    /*
     * 消息列表
     * @param uid [HTTP]
     * @param token
     * @param start
     * @param no
     */
    public function actionList(){
        $viewer = $this->validatePrivilege();
        $sql = 'SELECT cid FROM ${this->tableName()}';
        $msgModel = Msg::model()->findBySql($sql);
    }

    /*
     * 删除消息.删除回复只删除本回复,删除发起的消息,则回复也会被删除
     * @param uid
     * @param mid
     * @param token
     *
     */
    public function actionDelete(){

    }

    /**
     * 发送站内短信,必须有对应的session信息,并且已经处于ESTABLISHED状态
     * @param
     * @param
     * @param
     * 
     */
    private function sendMsg(){

    }

    /*
     * 发送邀请
     * @param sid
     * @param rid
     * @param msg
     *
     *
     */
    private function startSession(){
        $sender = $this->validatePrivilege();
        $receiver = User::model()->findByPk(DataHelper::getIntReq('rid'));

        if (!$this->canInvite($sender, $receiver))
        {
            ErrorHelper::Fatal(ErrorHelper::ERR_INTERNAL_ERROR);
        }

        //$msg = DataHelper::getStrReq('msg');

        $session = new Session();

        $session->sid = $sender->id;
        $session->rid = $receiver->id;
        //$session->msg = $msg;
        $session->state = Session::SS_INVITING;

        $isOk = $session->save();
        if (!$isOk){
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, 'invite message save fail.'.json_encode($session->getErrors()));
        }

        ErrorHelper::Success();
    }

    private function canInvite($sender, $receiver){
        if (!$sender || !$receiver)
        {
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_USER);
        }

        if ($sender->type != User::UT_ENTERPRISE){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE,'sender');
        }
        if ($receiver->type != User::UT_NORMAL){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE,'receiver');
        }

        $lastSession = Session::getLastSession($sender, $receiver);

        if (!$lastSession || $lastSession->state != Session::SS_ESTABLISHED)
        {
            return true;
        }

        if ($lastSession->state == Session::SS_INVITING &&
            (time() - $lastSession->create_time) > $this->config['invite_internal'])
        {
            return true;
        }

        return false;
    }

    /*
     * 获取会话状态,用于判断是否可以发起会话,是否可以发送消息
     *
     */
    public function actionState(){
        $user = $this->validatePrivilege();
        $sender = User::model()->findByPk(DataHelper::getIntReq('sid'));
        $receiver = User::model()->findByPk(DataHelper::getIntReq('rid'));
        if (!$sender || !$receiver || $user->id != $sender->id || $user->id != $receiver->id){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE);
        }

        if ($sender->type == User::UT_NORMAL && $receiver->type == User::UT_ENTERPRISE){
            $session = Session::model()->getSession($receiver, $sender);
            if ($session->state != Session::SS_ESTABLISHED){
                //Invalid Session State
                Pass;
            }else{
                // Ok.
                Pass;
            }
        }else if ($sender->type == User::UT_ENTERPRISE && $receiver->type == User::UT_NORMAL){
            $session = Session::model()->getSession($sender, $receiver);
            if (!$session || $session->state != Session::SS_ESTABLESHED){
                //Invalid Session State
                Pass;
            }else{
                //Ok.
                Pass;
            }
        }else{
            //Invalid Session State.
            Pass;
        }

        //Invalid Session State.
    }
}