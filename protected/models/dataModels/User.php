<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string  $username
 * @property string  $password
 * @property string  $nickname
 * @property string  $token
 * @property integer $last_login
 * @property integer $pro_state
 * @property string  $head
 * @property integer $reg_from 0-normal
 * @property string  $profile
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 */
class User extends CActiveRecord
{
    // User type
//    const UT_NORMAL     = 0;
//    const UT_ENTERPRISE = 1;
//    const UT_HUNTER     = 2;
//    const UT_ADMIN      = 3;


    const TOKEN_PERIOD  = 36000000;

//    private static $_userType = array(
//        self::UT_NORMAL => "普通用户",
//        self::UT_ENTERPRISE => "企业用户",
//        self::UT_HUNTER => "猎头用户",
//        self::UT_ADMIN => "管理员",
//    );
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
			array('reg_from', 'numerical', 'integerOnly'=>true),
			array('username, password', 'length', 'max'=>128),
			array('profile', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, reg_from', 'safe', 'on'=>'search'),
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
			'username' => 'Username',
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
		$criteria->compare('reg_from',$this->reg_from);

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

    /**
     * 获取用户详细信息,用户的相关信息都会获取得到
     * @return mixed
     */
    public function getDetail($id = null){
        if ($id){
            $this->findByPk($id);
        }

        $oData['id'] = $this->id;
        $oData['username'] = $this->username;
        $oData['last_login'] = strftime("%Y-%m-%d %H:%S:%M", $this->last_login);
        $oData['nickname'] = $this->nickname;
        $oData['pro_state'] = $this->pro_state;
        $oData['head'] = Utils::getImgUrl($this->head);

        //普通用户的简历信息,企业用户关联的公司信息
        if (!empty($this->profile)){
            $pk = explode(',', $this->profile);
            $profiles = Profile::model()->findAllByPk($pk);
            if (is_array($profiles)){
                foreach($profiles as $pf){
                    $oData['profile'][] = $pf->getData();
                }
            }
        }

        return $oData;
    }

    public function getSummary($id = null){
        if ($id){
            $this->findByPk($id);
        }
        $oData['id'] = $this->id;
        $oData['username'] = $this->username;
        $oData['last_login'] = $this->last_login;
        $oData['nickname'] = $this->nickname;
        $oData['pro_state'] = $this->pro_state;
        $oData['head'] = Utils::getImgUrl($this->head);

        return $oData;
    }

    public function addProfile($profile){
        if (!empty($this->$profile)){
            $this->profile = $this->profile. ','. $profile->id;
            $pfArr = explode(',', $this->profile);
            $pfArr = array_unique(array_merge($pfArr, array($profile->id)));
            $this->profile = implode(',', $pfArr);
        }else{
            $this->profile = $profile->id;
        }

        $this->save() or ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, 'save info fail.'. json_encode($this->getErrors()));
    }

    public function getProfileList(){
        return new CActiveDataProvider(
            'Profile',
            array(
                'criteria' => array(
                    'condition' => "uid='".$this->id."'",
                ),
                'pagination' => array(
                    'pageSize' => 10,
                )
            )
        );
    }

    public function getHeadUrl(){
        $url = Utils::getImgUrl($this->head);
        if (empty($url)){
            return Yii::app()->baseUrl.'/images/Users.png';
        }
        return $url;
    }

    public function getProfiles(){
        return Profile::model()->findByAttributes(array('uid'=>$this->id));
    }
}
