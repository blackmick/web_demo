<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-7
 * Time: 下午1:11
 */

/**
 * Class ProfileController 普通用户的简历信息
 */

class ProfileController extends SafeController{

    /**
     * 创建简历
     */
    public function actionCreate()
    {
        $operatorModel = $this->validatePrivilege();
        if($operatorModel->type != User::UT_NORMAL){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE,'not the user own');
        }

        $user_id = Yii::app()->request->getParam('user_id');
        $language = DataHelper::getStrReq('language');
        $keyword = DataHelper::getStrReq('keyword');

        $userModel = User::model()->findByPk($user_id);
        if (!$userModel){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_USER);
        }

        $profileModel = new Profile();
        $profileModel->user_id = $user_id;
        $profileModel->language = $language ? $language : 0;
        $profileModel->edu = '';
        $profileModel->exp = '';
        $profileModel->keyword = $keyword ? $keyword : '';

        $isSaveOk = $profileModel->save();
        if (!$isSaveOk){
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL,
                "save profile fail:".json_encode($profileModel->getErrors()));
        }

        $userModel->profile = strlen($userModel->profile) > 0 ?
            $userModel->profile . "," . $profileModel->id :
            $profileModel->id;

        $isSaveOk = $userModel->save();
        if (!$isSaveOk) {
            $profileModel->status = 1;
            $profileModel->save();
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, "link resume to user fail");
        }

        ErrorHelper::Success();
    }

    /**
     * 更新简历
     * TODO not finished.
     */
    public function actionUpdate(){
        $uid = Yii::app()->request->getParam('uid');
        $token = Yii::app()->request->getParam('token');

        $opModel = User::model()->findByPk($uid);
        if (!$opModel || $opModel->validateToken($token)){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE);
        }
    }

    /**
     * 删除简历
     */
    public function actionDelete(){
        $this->validatePrivilege();

        $profile_id = DataHelper::getIntReq('id');
        $profileModel = Profile::model()->findByPk($profile_id);
        if (!$profileModel){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PROFILE);
        }

        $ownerModel = User::model()->findByPk($profileModel->user_id);
        if (!$ownerModel){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_USER,"Invalid user for this profile");
        }

        $profile_list = explode(',',$ownerModel->profile);
        $new_profile_list = array_diff($profile_list, array($profile_id));
        $new_profile = implode(',', $new_profile_list);
        var_dump($new_profile);
        $ownerModel->profile = $new_profile;
        $isOk = $ownerModel->save();
        if (!$isOk){
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, 'save user fail:'.json_encode($ownerModel->getErrors()));
        }

        $profileModel->delete();

        ErrorHelper::Success();
    }

    /**
     * 简历详细信息
     */
    public function actionDetail(){
        $user = $this->validatePrivilege();
        $profile = $this->loadModel(DataHelper::getIntReq('id'));

        if ($user->type != User::UT_NORMAL || $user->type != $profile->uid){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE);
        }

        $data = $profile->getData();
        $this->render(null, $data, false, 'data');
    }

    public function loadModel($id)
    {
        $model=Profile::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}