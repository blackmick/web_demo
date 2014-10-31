<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-10
 * Time: 下午3:30
 */

class UserBase extends CActiveRecord
{
    const UT_NORMAL = 1;
    const UT_COMPANY = 2;
    const UT_HUNTER = 3;
    const UT_ADMIN = 4;

    const TOKEN_PERIOD  = 36000000;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function validateToken($token)
    {
        Yii::log("Get Token:".$token, CLogger::LEVEL_INFO);
        $savedToken = $this->getAttribute('token');
        $last_login = $this->getAttribute('last_login');
        $now = time();
        if (time()-$last_login > self::TOKEN_PERIOD){
            Yii::log("token time expired, expired time[{$this->last_login}], now is [{$now}]", CLogger::LEVEL_WARNING);
            return false;
        }

        if ($savedToken == $token){
            return true;
        }else{
            Yii::log("validate token fail, token user passed:[{$token}], token expected:[{$this->token}]", CLogger::LEVEL_WARNING);
        }
    }

    public function genToken(){
        $timestamp = time();
        $ua = Yii::app()->getRequest()->userAgent;
        $token = md5($ua."myjober token".$timestamp);
        $this->token = $token;

        return $token;
    }

    public function validatePassword($password){
        return CPasswordHelper::verifyPassword($password, $this->password);
    }

    public function beforeSave(){
        if (!parent::beforeSave())
            return false;

        if ($this->isNewRecord){
            $this->password = CPasswordHelper::hashPassword($this->password);
            $this->create_time = $this->update_time = time();
        }else{
            $this->update_time = time();
        }

        return true;
    }

    public function generateSalt(){
        return uniqid('', true);
    }
}