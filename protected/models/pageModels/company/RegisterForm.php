<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-17
 * Time: 下午3:16
 */

class RegisterForm extends CFormModel{
    public $username;
    public $password;
    public $verifyCode;

    public $_identity;

    public function rules()
    {
        return array(
            array('username, password, verifyCode', 'required'),
        );
    }

    public function validate($attributes=null, $clearErrors=true){
        return true;
    }

    public function register(){
        $user = CompanyAccount::model()->find("username = '{$this->username}'");
        if ($user){
            return false;
        }

        $user = new CompanyAccount();
        $user->username = $this->username;
        $user->password = $this->password;
        if ($user->save()){
            Yii::app()->user->setId($user->id);
            Yii::app()->user->setName($user->username);
            return true;
        }else{
            return false;
        }
    }
}