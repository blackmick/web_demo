<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/27
 * Time: 上午10:22
 */

class AdminIdentity extends CUserIdentity{
    private $_id;
    private $account = array(
        'username' => 'admin',
        'password' => 'admin',
    );

    public function authenticate(){
        if ($this->username != $this->account['username']){
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }else if($this->password != $this->account['password']){
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }else{
            $this->_id = 1;
            $this->setState("type", "admin");
            $this->errorCode = self::ERROR_NONE;
        }

        return $this->errorCode == self::ERROR_NONE;
//        $account = AdminAccount::model()->find("username='{$this->username}'");
//
//        if (!$account){
//            $this->errorCode = self::ERROR_USERNAME_INVALID;
//        }else if (!$account->validatePassword($this->password)){
//            $this->errorCode = self::ERROR_PASSWORD_INVALID;
//        }else{
//            $this->_id = $account->id;
//            $this->setState("type", "admin");
//            $this->errorCode = self::ERROR_NONE;
//        }
//        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId(){
        return $this->_id;
    }

    public function getAccount(){
        return $this->_account;
    }

    public function getType(){
        return "admin";
    }
}