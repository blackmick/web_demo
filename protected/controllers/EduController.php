<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-7
 * Time: 下午3:25
 */

/**
 * Class EduController 教育经历，只针对普通用户
 */
class EduController extends SafeController{
    /**
     * 创建教育信息
     */
    public function actionCreate(){
        $user_id = DataHelper::getIntReq('user_id');
        $uid = DataHelper::getIntReq('uid');
        $token = DataHelper::getStrReq('token');
        $profile_id = DataHelper::getIntReq('profile_id');
        $college = DataHelper::getStrReq('college');
        $major = DataHelper::getStrReq('major');
        $degree = DataHelper::getIntReq('degree');
        $start_time = Yii::app()->request->getParam('start_time');
        $end_time = Yii::app()->request->getParam('end_time');

        $viewer = User::model()->findByPk($uid);
        if (!$viewer)
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_USER);
        if (!$viewer->validateToken($token))
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_TOKEN);

        $userModel = User::model()->findByPk($user_id);
        if (!$userModel){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_USER);
        }

        $profileModel = Profile::model()->findByPk($profile_id);
        if (!$profileModel || $profileModel->user_id != $user_id){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_RESUME);
        }

        $eduModel = new Education();
        $start_time = strtotime($start_time);
        if ($end_time == 'now')
        {
            $end_time = -1;
        }else{
            $end_time = strtotime($end_time);
        }

        $eduModel->user_id = $user_id;
        $eduModel->profile_id = $profile_id;
        $eduModel->college = $college;
        $eduModel->major = $major;
        $eduModel->degree = $degree;
        $eduModel->start_time = $start_time;
        $eduModel->end_time = $end_time;
        $eduModel->create_time = time();
        $eduModel->update_time = time();
        $eduModel->status = 0;

        $isSaveOk = $eduModel->save();
        if ($isSaveOk === true){
            $oldEdu = $profileModel->edu;
            $newEdu = strlen($oldEdu) > 0 ? $oldEdu.",".$eduModel->id : $eduModel->id;
            $profileModel->edu = $newEdu;
            $isOk = $profileModel->save();
            if (!$isOk)
            {
                $eduModel->status = 1;
                $eduModel->save();
                ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, "link edu to resume fail---".json_encode($profileModel->getErrors()));
            }
            ErrorHelper::Success();
        }else{
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, serialize($eduModel->getErrors()));
        }
    }

    public function actionDetail(){
        $user = $this->validatePrivilege();
        $edu = $this->loadModel(DataHelper::getIntReq('id'));
        if ($user->type != User::UT_NORMAL || $user->id != $edu->uid){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE,'not the same user');
        }
        $data = $edu->getData();
        $this->render(null, $data, false, 'data');
    }

    public function loadModel($id)
    {
        $model=Education::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

}