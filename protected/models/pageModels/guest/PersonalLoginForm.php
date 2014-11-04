<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/28
 * Time: 下午12:31
 */
class PersonalLoginForm extends CFormModel
{
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
    public function authenticate($attribute=null,$params=null)
    {
        if(!$this->hasErrors())
        {
            $this->_identity=new PersonalIdentity($this->username,$this->password);
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
        return Yii::app()->user->login($this->_identity, 3600*24*30);

//        return true;
    }

    public function isAttached(){
        $ca = CompanyAccount::model()->findByPk(Yii::app()->user->getId());
        return !($ca && empty($ca->cid));
    }
}