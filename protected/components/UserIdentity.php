<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;

    private $_account = null;

    private $_companyName;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $account = CompanyAccount::model()->find('username = ?', array($this->username));
        if ($account === null){
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }else if (!$account->validatePassword($this->password)){
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }else{
            $this->_id = $account->id;
            $this->_account = $account;
            $this->errorCode = self::ERROR_NONE;
        }

		return $this->errorCode == self::ERROR_NONE;
	}

    public function getUser(){
        return $this->_account;
    }

    public function getId(){
        return $this->_id;
    }
}