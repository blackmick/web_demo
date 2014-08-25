<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string  $username
 * @property string  $password
 * @property string  $cookie
 * @property string  $salt
 * @property string  $token
 * @property integer $last_login
 * @property integer $type
 * @property integer $reg_from 0-normal
 * @property integer $base_info
 * @property string  $profile
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 */
class User extends CActiveRecord
{
    // User type
    const UT_NORMAL     = 0;
    const UT_ENTERPRISE = 1;
    const UT_HUNTER     = 2;
    const UT_ADMIN      = 3;


    const TOKEN_PERIOD  = 3600;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'required'),
			array('type, reg_from', 'numerical', 'integerOnly'=>true),
			array('username, password', 'length', 'max'=>128),
			array('profile', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, type, reg_from', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			//'id' => 'ID',
			'username' => 'Username',
			//'password' => 'Password',
			//'type' => 'Type',
			//'reg_from' => 'Reg From',
			//'base_info' => 'Base Info',
			//'profile' => 'Profile',
            //'token' => 'Token',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
//		$criteria->compare('password',$this->password,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('reg_from',$this->reg_from);
//		$criteria->compare('base_info',$this->base_info);
//		$criteria->compare('profile',$this->profile,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function validateToken($token)
    {
        Yii::log("Get Token:".$token, CLogger::LEVEL_INFO);
        $savedToken = $this->getAttribute('token');
        $last_login = $this->getAttribute('last_login');
        if (time()-$last_login > self::TOKEN_PERIOD){
            return false;
        }
        return $savedToken == $token;
    }

    public function genToken(){
//        $token = 'test token';
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

    public function getData(){
        $oData = $this->getAttributes();

        //$oData['reg_from'] =
        return $oData;
    }
}
