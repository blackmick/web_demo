<?php

/**
 * This is the model class for table "{{user_baseinfo}}".
 *
 * The followings are the available columns in table '{{user_baseinfo}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $mid_name
 * @property integer $location
 * @property integer $industry
 * @property string $title
 * @property integer $head
 * @property string $phone
 * @property string $address
 * @property string $email
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 */
class UserBaseinfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_baseinfo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('first_name, last_name, mid_name, location, industry, title, phone, create_time, update_time', 'required'),
            array('user_id', 'required'),
			array('user_id, location, industry, head, create_time, update_time, status', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, mid_name', 'length', 'max'=>32),
			array('title', 'length', 'max'=>128),
			array('phone', 'length', 'max'=>64),
			array('address, email', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, first_name, last_name, mid_name, phone, email, status', 'safe', 'on'=>'search'),
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
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'mid_name' => 'Mid Name',
//			'location' => 'Location',
//			'industry' => 'Industry',
			'title' => 'Title',
//			'head' => 'Head',
			'phone' => 'Phone',
			'address' => 'Address',
			'email' => 'Email',
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
        $criteria->compare('user_id', $this->user_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('mid_name',$this->mid_name,true);
//		$criteria->compare('location',$this->location);
//		$criteria->compare('industry',$this->industry);
//		$criteria->compare('title',$this->title,true);
//		$criteria->compare('head',$this->head);
		$criteria->compare('phone',$this->phone,true);
//		$criteria->compare('address',$this->address,true);
		$criteria->compare('email',$this->email,true);
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
	 * @return UserBaseinfo the static model class
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

        //location
        if (!isset($oData['location']) || $oData['location'] > 0){
            $locModel = Location::model()->findByPk($oData['location']);
            $oData['location'] = $locModel->getAttribute('name');
        }else{
            $oData['location'] = 'N/A';
        }

        if (!isset($oData['industry']) || $oData['industry'] > 0){
            $indModel = Industry::model()->findByPk($oData['industry']);
            $oData['industry'] = $indModel->getAttribute('name');
        }else{
            $oData['industry'] = 'N/A';
        }

        $oData['head'] = Utils::getImgUrl($oData['head']);
        return $oData;
    }
}
