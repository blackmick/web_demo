<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-2
 * Time: 8:58
 */

class UserController extends SafeController
{
    /**
     * 用户注册/创建
     */
    public function actionCreate()
    {
        $username = Yii::app()->request->getParam('username');
        $password = Yii::app()->request->getParam('password');
        $type = DataHelper::getIntReq('type');
        $userModel = User::model()->find("username='${username}' and status='0'");

        if ($userModel && $userModel->username === $username){
            ErrorHelper::Fatal(ErrorHelper::ERR_DUP_USER);
        }

        $userModel = new User();
        $userModel->username = $username;
        $userModel->password = $password;
        $userModel->type = $type;

        $isOk = $userModel->save();
        if (!$isOk) {
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL,
                'save user info fail:'.json_encode($userModel->getErrors()));
        }

        $user_id = $userModel->id;
        $userBaseModel = UserBaseinfo::model()->find("user_id='${user_id}' and status = '0'");
        if (!$userBaseModel) {
            $userBaseModel = new UserBaseinfo();
            $userBaseModel->user_id = $user_id;
            $isOk = $userBaseModel->save();
            if (!$isOk) {
                ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL,
                    'save user base info fail:'.json_encode($userBaseModel->getErrors()));
            }
        } else {
            ErrorHelper::Fatal(ErrorHelper::ERR_DUP_USER_BASE_INFO);
        }

        $userModel->base_info = $userBaseModel->id;
        $isOk = $userModel->save();
        if (!$isOk) {
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL,
                'save user info fail:'.json_encode($userModel->getErrors()));
        }

        ErrorHelper::Success();
    }

    /**
     * 用户登录,产生登录token
     */
    public function actionLogin(){
//        $begin = microtime(true);
        $username = DataHelper::getStrReq('username');
        $password = DataHelper::getStrReq('password');

        $userModel = User::model()->find("username='${username}'");
        if (!$userModel)
        {
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_USER);
        }

//        $start_time = microtime(true);
        if (!$userModel->validatePassword($password))
        {
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PASSWORD);
        }
//        $end_time = microtime(true);
//        Yii::log('validate password uses: '.($end_time - $start_time).'s', CLogger::LEVEL_TRACE);

        $token = $userModel->genToken();

        if($token == false){
            ErrorHelper::Fatal(ErrorHelper::ERR_INTERNAL_ERROR);
        }

        $userModel->last_login = time();

        if (!$userModel->save()){
            ErrorHelper::Fatal(ErrorHelper::ERR_LOGIN_FAIL, json_encode($userModel->getErrors()));
        }

        $oData['uid'] = $userModel->id;
        $oData['token'] = $token;

        $this->render(null, $oData, false, 'data');
//        $end = microtime(true);
//        Yii::log('total time use: '.($end - $begin).'s', CLogger::LEVEL_TRACE);
    }

    /**
     * 用户登出，清除token
     */
    public function actionLogout(){
        $user = $this->validatePrivilege();
        $user->token = '';
        $isOk = $user->save();
        if (!$isOk){
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, 'save token fail.'.json_encode($user->getErrors()));
        }

        ErrorHelper::Success();
    }

    /**
     * 用户详细信息
     */
    public function actionDetail(){
        $oData = array();

        $user_id = Yii::app()->request->getParam('id');
        $uid = Yii::app()->request->getParam('uid');
        $token = Yii::app()->request->getParam('token');


        $viewer = User::model()->findByPk($uid);
        if (!$viewer)
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_USER);
        if (!$viewer->validateToken($token))
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_TOKEN);

        $userModel = User::model()->findByPk($user_id);
        if (!$userModel){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_USER);
        }

        $userData = $userModel->getAttributes();

        //get user base info.
        $userBaseModel = UserBaseinfo::model()->findByPk($userModel->base_info);
        if (!$userBaseModel)
            ErrorHelper::Fatal(ErrorHelper::ERR_NO_USER_BASE_INFO);
        $userData['base_info'] = $userBaseModel->getData();

        //get profile for normal user.
        if ($userModel->type != User::UT_ENTERPRISE) {
            $profileIds = $userModel->profile ? explode(',', $userModel->profile) : array();
            $profileModel = Profile::model()->findAllByPk($profileIds);
//        var_dump($profileModel);
            $proData = array();
            if ($profileModel) {
                foreach ($profileModel as $profileM) {
                    $profileData = $profileM->getData();
                    $proData[] = $profileData;
                }
            }
            $userData['profile data'] = $proData;
        }

        $oData[] = $userData;

        $this->render(null, $oData, false, 'data');
    }

    /**
     * 更改用户信息,目前只针对password
     */
    public function actionUpdate(){
        $this->layout = 'user_update';
        $userModel = new User();
        $baseInfoModel = new UserBaseinfo();

        $this->render('update',
            array(
                'userModel' => $userModel,
                'baseInfoModel' => $baseInfoModel
            )
            ,false, 'page');
    }
}