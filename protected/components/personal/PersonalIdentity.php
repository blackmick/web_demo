<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/28
 * Time: 上午11:24
 */
class PersonalIdentity extends CUserIdentity{
    private $_id;

    public function authenticate(){
        $account = User::model()->find("username='{$this->username}'");

        if (!$account){
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }else if (!$account->validatePassword($this->password)){
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }else{
            $this->_id = $account->id;
            $this->setState("type", "personal");
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId(){
        return $this->_id;
    }

    public function getAccount(){
        return $this->_account;
    }

    public function getType(){
        return "personal";
    }
}