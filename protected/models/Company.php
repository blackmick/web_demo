<?php

/**
 * This is the model class for table "{{company}}".
 *
 * The followings are the available columns in table '{{company}}':
 * @property integer $id
 * @property string  $name
 * @property integer $type
 * @property integer $industry
 * @property integer $scale
 * @property string  $homepage
 * @property string  $desc
 * @property string  $address
 * @property string  $contact
 * @property string  $phone
 * @property string  $mobile
 * @property string  $email
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 *
 */
class Company extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{company}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('type, industry, scale', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
            array('homepage', 'length', 'max'=>128),
            array('desc', 'length', 'max'=>2048),
            array('address', 'length', 'max'=>256),
            array('contact', 'length', 'max'=>32),
            array('phone', 'length', 'max'=>20),
            array('mobile', 'length', 'max'=>20),
            array('email', 'length', 'max'=>256),
            // The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, type, industry', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'type' => 'Type',
			'industry' => 'Industry',
			'homepage' => 'Homepage',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('industry',$this->industry);
//		$criteria->compare('homepage',$this->homepage,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Enterprise the static model class
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
        $attr = $this->getAttributes();
        $oData = $attr;
        return $oData;
    }
}
