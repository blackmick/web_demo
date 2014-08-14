<?php

/**
 * This is the model class for table "{{resume}}".
 *
 * The followings are the available columns in table '{{resume}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $language
 * @property string title
 * @property string $edu
 * @property string $exp
 * @property string $keyword
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 */
class Profile extends CActiveRecord
{
    private $_langMap = array(
        '1' => 'Chinese',
        '2' => 'English',
    );
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{profile}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id, language', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>32),
			array('edu', 'length', 'max'=>32),
			array('exp', 'length', 'max'=>64),
			array('keyword', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, language', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'language' => 'Language',
			'edu' => 'Education',
			'exp' => 'Experience',
			'keyword' => 'Keyword',
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
		$criteria->compare('language',$this->language);
//        $criteria->compare('title', $this->title);
		$criteria->compare('edu',$this->edu,true);
		$criteria->compare('exp',$this->exp,true);
		$criteria->compare('keyword',$this->keyword,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Resume the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getData(){
        $oData = $this->getAttributes();
        $eduData = $this->getEduData();
        $expData = $this->getExpData();

//        if (!$eduData && !$expData){
//            return false;
//        }

        if ($eduData){
            $oData['education'] = $eduData;
        }

        if ($expData){
            $oData['experience'] = $expData;
        }

        $oData['language'] = $this->_langMap[$oData['language']];
        unset($oData['create_time']);
        unset($oData['update_time']);
        unset($oData['status']);

        return $oData;
    }

    public function getEduData(){
        if (strlen($this->edu) <= 0)
            return false;

        $oData = array();
        $ids = explode(',', $this->edu);
        //var_dump($ids);
        $eduModels = Education::model()->findAllByPk($ids);
        if (!$eduModels)
            return false;

        foreach($eduModels as $eduM){
            $oData[]= $eduM->getAttributes();
        }
        return $oData;
    }

    public function getExpData(){
        if (strlen($this->exp) <= 0)
            return false;

        $oData = array();
        $ids = explode(',', $this->exp);
        $expModel = Experience::model()->findAllByPk($ids);
        if (!$expModel)
            return false;
        foreach($expModel as $eduM){
            $oData[]= $eduM->getAttributes();
        }
        return $oData;
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

    public function beforeDelete(){
        if (parent::beforeDelete()){
            $this->deleteEdu();
            $this->deleteExp();
            return true;
        }

        return false;
    }

    public function deleteEdu(){
        $edu_list = explode(',', $this->edu);
        $arrEdu = Education::model()->findAllByPk($edu_list);
        if (!$arrEdu)
            return;

        foreach ($arrEdu as $edu){
            $edu->delete();
        }
    }

    public function deleteExp(){
        $exp_list = explode(',', $this->exp);
        $arrExp = Experience::model()->findAllByPk($exp_list);
        if (!$arrExp)
            return;

        foreach($arrExp as $exp){
            $exp->delete();
        }
    }
}
