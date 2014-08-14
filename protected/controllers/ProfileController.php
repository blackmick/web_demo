<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-7
 * Time: 下午1:11
 */

class ProfileController extends SafeController{
    public function actionCreate()
    {
        $operatorModel = $this->validatePrivilege();

        $user_id = Yii::app()->request->getParam('user_id');
//        $uid = Yii::app()->request->getParam('uid');
//        $token = Yii::app()->request->getParam('token');
        $language = DataHelper::getStrReq('language');
        $keyword = DataHelper::getStrReq('keyword');

//        $operatorModel = User::model()->findByPk($uid);
//        if (!$operatorModel)
//            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_USER);
//        if (!$operatorModel->validateToken($token))
//            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_TOKEN);

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

    public function actionUpdate(){
        $uid = Yii::app()->request->getParam('uid');
        $token = Yii::app()->request->getParam('token');

        $opModel = User::model()->findByPk($uid);
        if (!$opModel || $opModel->validateToken($token)){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE);
        }
    }

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
}