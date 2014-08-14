<?php

/**
 * This is the model class for table "{{job}}".
 *
 * The followings are the available columns in table '{{job}}':
 * @property integer $id
 * @property string $title
 * @property integer $e_id
 * @property integer $create_time
 * @property integer $publish_time
 * @property integer $insert_time
 * @property integer $update_time
 * @property integer $location_id
 * @property integer $industry_id
 * @property string $description
 */
class Job extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{job}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('e_id, create_time, publish_time, insert_time, update_time, location_id, industry_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>128),
			array('description', 'length', 'max'=>2048),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, e_id, publish_time, location_id, industry_id, description', 'safe', 'on'=>'search'),
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
			'title' => '职位描述',
			'e_id' => 'E',
			'create_time' => 'Create Time',
			'publish_time' => 'Publish Time',
			'insert_time' => 'Insert Time',
			'update_time' => 'Update Time',
			'location_id' => 'Location',
			'industry_id' => 'Industry',
			'description' => 'Description',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('e_id',$this->e_id);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('publish_time',$this->publish_time);
		$criteria->compare('insert_time',$this->insert_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('location_id',$this->location_id);
		$criteria->compare('industry_id',$this->industry_id);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Job the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
