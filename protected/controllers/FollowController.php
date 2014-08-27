<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-2
 * Time: 8:52
 */

class FollowController extends SafeController
{
    const FT_JOB = 1;
    const FT_COMPANY = 2;
    const FT_INDUSTRY = 3;

    private $_modelMap = array(
        self::FT_JOB => 'FollowJob',
        self::FT_COMPANY => 'FollowCompany',
        self::FT_INDUSTRY => 'FollowIndustry',
    );

    /**
     * 创建一个follow关系
     */
    public function actionCreate()
    {
        $opModel = $this->validatePrivilege();

        $user_id = DataHelper::getIntReq('user_id');

        if ($opModel->id != $user_id)
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE);

        $type = DataHelper::getIntReq('type');
        if (!isset($this->_modelMap[$type]))
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PARAM, 'invalid type');

        $id = DataHelper::getIntReq('id');

        $attr = array();
        $cond = array();
        $followModel = $$this->_modelMap[$type]::model()->findAllByAttributes($attr, $cond);

        if ($followModel){
            $oldList = $followModel->getAttribute();
            $newList = $oldList.','.$id;
            $followModel->list = $newList;
        }else{
            $followModel = new $this->_modelMap[$type];
            $followModel->uid = $user_id;
            $followModel->list = $id;
        }
        $isOk = $followModel->save();
        if (!$isOk){
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, 'save follow ship fail:'.json_encode($followModel->getErrors()));
        }

        ErrorHelper::Success();
    }

    public function actionDelete(){
        $opModel = $this->validatePrivilege();
        $user_id = DataHelper::getIntReq('user_id');
        $follow_id = DataHelper::getIntReq('id');
        $type = DataHelper::getIntReq('type');

        $followModel = $$this->_modeMap[$type]::model()->findByPk($user_id);
        if (!$followModel || $followModel->uid != $opModel->id){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE);
        }

        $oldList = $followModel->list;
        $newList = array_diff($oldList, array($follow_id));

        $followModel->list = $newList;

        if (!$followModel->save()){
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, 'modify follow model list fail.'.json_encode($followModel->getErrors()));
        }

        ErrorHelper::Success();
    }

    /*
     * 普通用户的关注列表
     *
     */
    public function actionList(){
        $opModel = $this->validatePrivilege();

        $user_id = DataHelper::getIntReq('user_id');

        if ($opModel->id != $user_id)
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE);

        $type = DataHelper::getIntReq('type');

        $followModel = null;
        $condition = array("uid = '${user_id}'", "status = '0'");
        $attr = array('list');
        switch($type){
            case self::FT_JOB:
                $followModel = FollowJob::model()->findAllByAttributes($attr, $condition);
                break;
            case self::FT_COMPANY:
                $followModel = FollowCompany::model()->findAllByAttributes($attr, $condition);
                break;
            case self::FT_INDUSTRY:
                $followModel = FollowIndustry::model()->findAllByAttributes($attr, $condition);
                break;
            default:
                ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PARAM, 'type');
                break;
        }

        $oData = $followModel->getData();

        $this->render(null, $oData, false, 'data');
    }

    /**
     * 检查用户是否关注了某xxx
     * @param uid
     * @param user_id
     * @param target_id
     * @param type
     */
    public function check($uid, $tid, $type){
        $user = User::model()->findByPk($uid);
        $target = $this->loadTarget($user->id, $type);
        if ($user->type != User::UT_NORMAL){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE);
        }

        $arr = explode(',', $target->list);
        if (in_array($tid, $arr))
            return true;
        else
            return false;
    }

    private function loadTarget($uid, $type){
        switch($type){
            case self::FT_JOB:
                $target = FollowJob::model()->findByPk($uid);
                break;
            case self::FT_COMPANY:
                $target = FollowCompany::model()->findByPk($uid);
                break;
            case self::FT_INDUSTRY:
                $target = FollowIndustry::model()->findByPk($uid);
                break;
            default:
                ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PARAM);
                break;
        }

        return $target;
    }
}