<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-2
 * Time: 8:52
 */

class FollowController extends SafeController
{
    private $_modelMap = array(
        '1' => 'FollowJob',
        '2' => 'FollowCompany',
        '3' => 'FollowIndustry',
    );

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

    }

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
            case 1:
                $followModel = FollowJob::model()->findAllByAttributes($attr, $condition);
                break;
            case 2:
                $followModel = FollowCompany::model()->findAllByAttributes($attr, $condition);
                break;
            case 3:
                $followModel = FollowIndustry::model()->findAllByAttributes($attr, $condition);
                break;
            default:
                break;
        }

        $oData = $followModel->getData();

        $this->render(null, $oData, false, 'data');
    }
}