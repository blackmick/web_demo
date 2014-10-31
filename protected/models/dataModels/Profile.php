<?php

/**
 * This is the model class for table "{{resume}}".
 *
 * The followings are the available columns in table '{{resume}}':
 * @property integer $id
 * @property integer $uid
 * @property integer $language
 * @property string  $name
 * @property string  $first_name
 * @property string  $last_name
 * @property integer $location
 * @property integer $industry
 * @property string  $title
 * @property string  $phone
 * @property string  $email
 * @property string  $edu
 * @property string  $exp
 * @property string  $tags
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
			array('uid', 'required'),
			array('uid, language', 'numerical', 'integerOnly'=>true),
			array('edu', 'length', 'max'=>64),
			array('exp', 'length', 'max'=>128),
			array('tags', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, uid, language', 'safe', 'on'=>'search'),
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
//			'language' => 'Language',
//			'edu' => 'Education',
//			'exp' => 'Experience',
//			'keyword' => 'Keyword',
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
		$criteria->compare('language',$this->language);
//        $criteria->compare('title', $this->title);
		$criteria->compare('edu',$this->edu,true);
		$criteria->compare('exp',$this->exp,true);
		$criteria->compare('tags',$this->tags,true);

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

    /**
     * @return array
     */
    public function getData($id = null){
//        $oData = $this->getAttributes();
        if ($id){
            $this->findByPk($id);
        }

        $oData['id'] = $this->id;
        $oData['name'] = $this->name;
        $oData['first_name'] = $this->first_name;
        $oData['last_name'] = $this->last_name;
        $oData['location'] = $this->location;
        $oData['industry'] = $this->industry;
        $oData['industry_name'] = Industry::getName($this->industry);
        $oData['title'] = $this->title;
        $oData['phone'] = $this->phone;
        $oData['email'] = $this->email;
        $oData['create_time'] = strftime("%Y-%m-%d %H:%S:%M", $this->create_time);
        $oData['update_time'] = strftime("%Y-%m-%d %H:%S:%M", $this->update_time);
        $eduData = $this->getEduData();
        $expData = $this->getExpData();
        $oData['education'] = $eduData ? $eduData : null;
        $oData['experience'] = $expData ? $expData : null;
        $oData['language'] = $this->language;// $this->_langMap[$this->language];

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
            $oData[]= $eduM->getData();
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
            $oData[]= $eduM->getData();
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

    public function addEdu($edu){
        if ($this->edu != ''){
            //$this->edu = $this->edu . ',' . $edu->id;
            $eduList = explode(',', $this->edu);
            if (!in_array($edu->id, $eduList)){
                array_push($eduList, $edu->id);
                $this->edu = implode(',', $eduList);
            }
        }else{
            $this->edu = $edu->id;
        }
        $this->save() or ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, 'save edu fail.'.json_encode($this->getErrors()));
    }

    public function addExp($exp){
        if ($this->exp != ''){
//            $this->exp = $this->edu . ',' . $exp->id;
            $expList = explode(',', $this->exp);
            if (!in_array($exp->id, $expList)){
                array_push($expList, $exp->id);
                $this->exp = implode(',', $expList);
            }
        }else{
            $this->exp = $exp->id;
        }
        $this->save() or ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, 'save exp fail.'.json_encode($this->getErrors()));
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
