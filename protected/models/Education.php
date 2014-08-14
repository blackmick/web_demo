<?php

/**
 * This is the model class for table "{{education}}".
 *
 * The followings are the available columns in table '{{education}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $profile_id
 * @property string $college
 * @property string $major
 * @property integer $degree
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 */
class Education extends CActiveRecord
{
    private $_degreeMap = array(
        '0' => 'N/A',
        '1' =>  'Bachelor',
        '2' =>  'Master',
        '3' =>  'Doctor',
    );
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{education}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, profile_id, college, major, degree, start_time, end_time', 'required'),
			array('user_id, profile_id, degree, start_time, end_time, create_time, update_time, status', 'numerical', 'integerOnly'=>true),
			array('college', 'length', 'max'=>64),
			array('major', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, profile_id, start_time, end_time', 'safe', 'on'=>'search'),
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
//			'id' => 'ID',
//			'user_id' => 'User',
//			'profile_id' => 'Profile',
			'college' => 'College',
			'major' => 'Major',
			'degree' => 'Degree',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
//			'create_time' => 'Create Time',
//			'update_time' => 'Update Time',
//			'status' => 'Status',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('profile_id',$this->profile_id);
		$criteria->compare('college',$this->college,true);
		$criteria->compare('major',$this->major,true);
		$criteria->compare('degree',$this->degree);
//		$criteria->compare('start_time',$this->start_time);
//		$criteria->compare('end_time',$this->end_time);
//		$criteria->compare('create_time',$this->create_time);
//		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserEducation the static model class
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

    public function getData(){
        $oData = $this->getAttributes();
        $oData['degree'] = isset($this->_degreeMap[$oData['degree']]) ?
            $this->_degreeMap[$oData['degree']] : 'N/A';
        $oData['start_time'] = isset($oData['start_time']) ? date("", $oData['start_time']) : '';
        $oData['end_time'] = isset($oData['start_time']) ? date("", $oData['end_time']) : '';

//        unset($oData['create_time']);
//        unset($oData['update_time']);
//        unset($oData['status']);
        return $oData;
    }

}
