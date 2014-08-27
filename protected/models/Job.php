<?php

/**
 * This is the model class for table "{{job}}".
 *
 * The followings are the available columns in table '{{job}}':
 * @property integer $id
 * @property string  $title
 * @property integer $company_id
 * @property integer $industry
 * @property integer $functype
 * @property string  $department
 * @property integer $m_ratio
 * @property integer $location
 * @property integer $degree
 * @property integer $hc
 * @property string  $age
 * @property string  $description
 * @property string  $responsibility
 * @property string  $other
 * @property string  $keyword
 * @property string  $filter
 * @property integer $publish_time
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
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
            array('title', 'required'),
			array('company_id, create_time, publish_time, update_time, location, industry', 'numerical', 'integerOnly'=>true),
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
			'company_id' => '公司id',
			'create_time' => 'Create Time',
			'publish_time' => 'Publish Time',
			'update_time' => 'Update Time',
			'location' => 'Location',
			'industry' => 'Industry',
			'description' => 'Description',
            'responsibility' => '职责描述',
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
		$criteria->compare('e_id',$this->company_id);
//		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('publish_time',$this->publish_time);
//		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('location',$this->location);
		$criteria->compare('industry',$this->industry);
//		$criteria->compare('description',$this->description,true);

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

    public function getByCompany($arrCompany){

    }

    public function getByIndustry($arrIndustry){
        $oData = array();
        $criteria = new CDbCriteria();
        $count = $this->count($criteria);
        $pages = new CPagination($count);
        $pages->pageCount = 20;
    }
}
