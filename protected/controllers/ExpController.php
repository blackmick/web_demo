<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-7
 * Time: 下午3:42
 */

/**
 * Class ExpController
 * 工作经历,只针对普通用户创建
 */
class ExpController extends SafeController{

    /**
     * Create a work expirence information for a specified profile for specified user.
     * @param None
     * @Return None
     *
     */
    public function actionCreate(){

        $opModel = $this->validatePrivilege();

        //check user privilege
        $token = Yii::app()->request->getParam('token');
        $opModel->validateToken($token);
        //get parameters from the request.
//        $uid = Yii::app()->request->getParam('uid');

        $owner_id = Yii::app()->request->getParam('user_id');
        $profile_id = Yii::app()->request->getParam('profile_id');
        $start_time = Yii::app()->request->getParam('start_time');
        $end_time = Yii::app()->request->getParam('end_time');
        $company = Yii::app()->request->getParam('company');
        $description = Yii::app()->request->getParam('desc');
        $keyword = Yii::app()->request->getParam('keyword');

        //check models
        $ownerModel = User::model()->findByPk($owner_id);
//        $userModel = User::model()->findByPk($uid);
        $profileModel = Profile::model()->findByPk($profile_id);

        if (!$ownerModel){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_USER);
        }

        if (!$profileModel){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PROFILE);
        }


        //create a new UserWorkExperience instance.
        $expModel = new Experience();

        $expModel->user_id = $owner_id;
        $expModel->profile_id = $profile_id;
        $expModel->start_time = strtotime($start_time);
        $expModel->end_time =strtotime($end_time);
        $expModel->company = $company;
        $expModel->description = $description;
        $expModel->keyword = $keyword;


        $isSaveOk = $expModel->save();
        if (!$isSaveOk)
        {
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL,
            "save experience fail.".serialize($expModel->getErrors()));
        }

        if (strlen($profileModel->exp) > 0){
            $profileModel->exp = $profileModel->exp.",".$expModel->id;
        }else{
            $profileModel->exp = $expModel->id;
        }

        $isSaveOk = $profileModel->save();
        if (!$isSaveOk){
            $expModel->status=1;
            $expModel->save();
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, "save profile fail.".serialize($profileModel->getErrors()));
        }

        ErrorHelper::Success();
    }

    public function actionUpdate(){

    }

    public function actionDelete(){

    }

    public function actionDetail(){

    }
}