<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
    public $companyName;
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
            array('companyName', 'required', 'message' => '企业会员名不能为空'),
			// username is required
			array('username', 'required', 'message' => '账号不能为空'),
            // password is required
            array('password', 'required', 'message' => '密码不能为空'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'记住登录状态',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
            $company = Company::model()->find("name = '{$this->companyName}'");
            if (!$company || $company->status != Company::COMPANY_STATUS_APPROVED){
                $this->addError('companyName','企业会员不存在或还未开通');
                return;
            }

			$this->_identity=new CompanyIdentity($this->companyName, $this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','帐户名或密码错误.');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
        Yii::app()->user->login($this->_identity, 3600*24*30);
//        $ca = $this->_identity->getUser();
//
//        $ca->genToken();
//        $ca->last_login = time();
//        $ca->save();
//
//        $cookies = Yii::app()->request->getCookies();
//        $cookie = new CHttpCookie('uid', $ca->id);
//        $cookie->expire = time() + 3600 * 24 * 30;
//        $cookies->add('uid', $cookie);
//        $token_cookie = new CHttpCookie('token', $ca->token);
//        $token_cookie->expire = time() + 3600 * 24 * 30;
//        $cookies->add('token', $token_cookie);
        return true;
	}

    public function isAttached(){
        $ca = CompanyAccount::model()->findByPk(Yii::app()->user->getId());
        return !($ca && empty($ca->cid));
    }
}
