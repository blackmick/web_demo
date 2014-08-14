<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-11
 * Time: 上午11:21
 */

class SafeController extends Controller{
    public function validatePrivilege(){
        $uid = DataHelper::getIntReq('uid');
        $token = DataHelper::getStrReq('token');

        $opModel = User::model()->findByPk($uid);
        if (!$opModel || !$opModel->validateToken($token)){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE);
        }

        return $opModel;
    }
}