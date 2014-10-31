<?php

/**
 * This is the model class for table "{{invite}}".
 *
 * The followings are the available columns in table '{{invite}}':
 * @property integer $id
 * @property integer $uid
 * @property integer $cid
 * @property string  $msg
 * @property integer $state 1:inviting 2:accepted 3:rejected
 * @property integer $create_time
 * @property integer $update_time
 */
class Invite extends CActiveRecord
{
    const IS_INVITING = 1;
    const IS_ACCEPT = 2;
    const IS_REJECT = 3;

    const COST_INVITE = 1;
    const COST_ACCEPT = 10;

    static $_periodMap = array(
        // time => period
        3600,
        7200,
        36000,
        72000
    );
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{invite}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, cid, create_time, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, uid, cid, create_time, status', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'uid' => 'Uid',
			'cid' => 'Cid',
			'create_time' => 'Create Time',
			'status' => 'Status',
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
		$criteria->compare('uid',$this->uid);
		$criteria->compare('cid',$this->cid);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('msg',$this->msg);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Invite the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave(){
        if (parent::beforeSave()){
            if ($this->isNewRecord){
                $this->create_time = $this->update_time = time();
            }else{
                $this->update_time = time();
            }
            return true;
        }

        return false;
    }

    /**
     * @param $company
     * @param $user
     * @return int
     */
    public static function getCount($company, $user){
        $sql = "SELECT count(*) as c FROM tbl_invite WHERE uid = '{$user->id}' and cid = '{$company->id}'";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $result = $command->query();
        if ($result){
            return $result['c'];
        }else{
            return 0;
        }
    }

    public static function getInstance($company, $user){
        $sql = "SELECT * FROM tbl_invite WHERE uid = '{$user->id}' and cid = '{$company->id}'";
        return Invite::model()->findBySql($sql);
    }

    /**
     * @param $company
     * @param $user
     * @return Invite
     */
    public static function getLastInstance($company, $user){
        $sql = "SELECT * FROM tbl_invite WHERE uid = '{$user->id}' and cid = '{$company->id}' ORDER BY create_time DESC limit 1";
        return Invite::model()->findBySql($sql);
    }

    /**
     * @param CompanyAccount $companyAccount
     * @param User $user
     * @param int $last_time
     * @return boolean
     */
    public static function check($companyAccount, $user, $last_time){
        if (empty($companyAccount->cid)){
            Yii::log("company account[{$companyAccount->username}] has not attach any company", CLogger::LEVEL_WARNING);
            return false;
        }

        //1.balance of company account check
        if (!$companyAccount->checkBalance(self::COST_INVITE)){
            Yii::log("company account[{$companyAccount->username}] has not enough balance,balance remain[{$companyAccount->getBalance()}]", CLogger::LEVEL_WARNING);
            return false;
        };

        //2.invite times check
        $company = Company::model()->findByPk($companyAccount->cid);
        if (!$company){
            Yii::log("the company attached to account[{$companyAccount->username}] not found", CLogger::LEVEL_WARNING);
            return false;
        }

        $count = Invite::getCount($company, $user);
        if ($count > count(self::$_periodMap)){
            Yii::log("the company invite the candidate exceeded", CLogger::LEVEL_WARNING);
            return false;
        }

        //3.invite period check
        $cur_time = time();
//        $invite = Invite::getLastInstance($companyAccount, $user);
        if (($cur_time - $last_time) < self::$_periodMap[$count]){
            Yii::log("can not send invitation because of the period", CLogger::LEVEL_WARNING);
            return false;
        }

        return true;
    }

    public function getDetail(){
        $oData['id'] = $this->id;
        $oData['uid'] = $this->uid;
        $oData['cid'] = $this->cid;
        $oData['msg'] = $this->msg;
        $oData['create_time'] = $this->create_time;
        $oData['update_time'] = $this->update_time;
        $oData['state'] = $this->state;

        return $oData;
    }

    public function getListByUser($user, $lastId, $reqNo){
        if ($lastId < 0){
            $sql = "SELECT * FROM tb_invite WHERE uid = '{$user->id}' ORDER BY create_time DESC limit {$reqNo}";
        }else{
            $sql = "SELECT * FROM tb_invite WHERE uid = '{$user->id}' and id < '{$lastId}' ORDER BY create_time DESC limit {$reqNo}";
        }

        return $this->findAllBySql($sql);
    }

    public function getListByCompany($company, $lastId, $reqNo){
        if ($lastId < 0){
            $sql = "SELECT * FROM tb_invite WHERE cid = '{$company->id}' ORDER BY create_time DESC limit {$reqNo}";
        }else{
            $sql = "SELECT * FROM tb_invite WHERE cid = '{$company->id}' and id < '{$lastId}' ORDER BY create_time DESC limit {$reqNo}";
        }

        return $this->findAllBySql($sql);
    }
}
