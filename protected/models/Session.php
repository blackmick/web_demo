<?php

/**
 * This is the model class for table "{{session}}".
 *
 * The followings are the available columns in table '{{session}}':
 * @property integer $id
 * @property integer $sid
 * @property integer $rid
 * @property integer $state
 * @property string  $msg
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 */
class Session extends CActiveRecord
{
    const SS_NONE           = 0;
    const SS_INVITING       = 1;
    const SS_ESTABLISHED    = 2;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{session}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sid, rid, state', 'required'),
			array('sid, rid, state, create_time, update_time, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sid, rid, state, create_time, update_time, status', 'safe', 'on'=>'search'),
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
			'sid' => 'Sid',
			'rid' => 'Rid',
			'state' => 'State',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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
		$criteria->compare('sid',$this->sid);
		$criteria->compare('rid',$this->rid);
		$criteria->compare('state',$this->state);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Session the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getSession($userCompany, $userNormal, $state = null){
        if ($userCompany->type != User::UT_ENTERPRISE || $userNormal->type != User::UT_NORMAL){
            return fasle;
        }

        $sql = "SELECT * FROM " . $this->tableName(). " WHERE sid = " .$userCompany->id." AND rid = " .$userNormal->id;
        if ($state){
            $sql = $sql. "AND state = ". $state;
        }
        $sessions  = $this->findAllBySql($sql);

        return $sessions;
    }

    public function getLastSession($userCompany, $userNormal, $state = null){
        if ($userCompany->type != User::UT_ENTERPRISE || $userNormal->type != User::UT_NORMAL){
            return fasle;
        }

        $sql = "SELECT * FROM " . $this->tableName(). " WHERE sid = " .$userCompany->id." AND rid = " .$userNormal->id;
        if ($state){
            $sql = $sql. "AND state = ". $state;
        }

        $sql = $sql. " ORDER BY create_time DESC limit 1";
        $session  = $this->findBySql($sql);

        return $session;
    }
}
