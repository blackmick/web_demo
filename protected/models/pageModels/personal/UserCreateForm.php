<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/28
 * Time: 下午1:21
 */
class UserCreateForm extends CFormModel{
    public $username;
    public $password;
    public $password_repeat;
    public $verify;

    public $_identity;

    public function rules()
    {
        return array(
            array('username','required','message'=>'用户名不能为空'),
//            array('password', 'PasswordValidator'),
            array('password_repeat','compare','compareAttribute'=>'password', 'message'=>'两次输入的密码要一致'),
            array('username, password, password_repeat, verfiy', 'safe'),
        );
    }

//    public function validate($attributes=null, $clearErrors=true){
//        return true;
//    }

    public function register(){
        $user = User::model()->find("username = '{$this->username}'");
        if ($user){
            return false;
        }

        $user = new User();
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