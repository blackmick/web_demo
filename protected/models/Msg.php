<?php

/**
 * This is the model class for table "{{msg}}".
 *
 * The followings are the available columns in table '{{msg}}':
 * @property integer $id
 * @property integer $sid
 * @property integer $rid
 * @property integer $tid
 * @property string $cid
 * @property integer $type
 * @property string $msg
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 */
class Msg extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{

		return '{{msg}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sid, rid, tid, type, create_time, update_time, status', 'numerical', 'integerOnly'=>true),
			array('msg', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sid, rid, tid, type, status', 'safe', 'on'=>'search'),
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
			'sid' => 'Sender',
			'rid' => 'Receiver',
            'tid' => 'Target',
			'type' => 'Type',
			'msg' => 'Msg',
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
        $criteria->compare('tid',$this->tid);
        $criteria->compare('cid',$this->cid);
        $criteria->compare('type',$this->type);
		//$criteria->compare('msg',$this->msg,true);
		//$criteria->compare('create_time',$this->create_time);
		//$criteria->compare('update_time',$this->update_time);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Msg the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    private function getCid(){
        if ($this->sid && $this->rid){
            $tmp = md5($this->sid).md5($this->rid);
            return md5($tmp);
        }
        return false;
    }

    public function beforeSave(){
        if (parent::beforeSave()){
            $this->cid = $this->getCid();
            if (!$this->cid){
                ErrorHelper::Error(ErrorHelper::ERR_SAVE_FAIL, 'can not make cid');
                return false;
            }
            if ($this->isNewRecord){
                $this->create_time = $this->update_time = time();
            }else{
                $this->update_time = time();
            }

            return true;
        }
        return false;
    }
}
