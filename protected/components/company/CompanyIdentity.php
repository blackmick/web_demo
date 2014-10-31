<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/26
 * Time: 上午10:19
 */

class CompanyIdentity extends CUserIdentity{
    private $_accountId;
    private $_companyName;
    private $_account;

    const ERROR_COMPANY_NOT_EXIST = 10;
    const ERROR_COMPANY_NOT_APPROVED = 11;

    public function __construct($companyName, $username, $password){
        $this->_companyName = $companyName;
        $this->username = $username;
        $this->password = $password;
    }

    public function authenticate(){
        $company = Company::model()->find("name='{$this->_companyName}'");
        if (!$company){
            $this->errorCode = self::ERROR_COMPANY_NOT_EXIST;
            return false;
        }

        $account = CompanyAccount::model()->find("username='{$this->username}' and cid='{$company->id}'");

        if ($company->status != Company::COMPANY_STATUS_APPROVED){
            $this->errorCode = self::ERROR_COMPANY_NOT_APPROVED;
        }else if (!$account || $account->cid != $company->id){
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }else if (!$account->validatePassword($this->password)){
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }else{
            $this->_accountId = $account->id;
            $this->_account = $account;
            $this->setState("cid", $company->id);
            $this->setState("type", "company");
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId(){
        return $this->_accountId;
    }

    public function getName(){
        return $this->_companyName."[".$this->username."]";
    }

    public function getAccount(){
        return $this->_account;
    }

    public function getType(){
        return "company";
    }
}