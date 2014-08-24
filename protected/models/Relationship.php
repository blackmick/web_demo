<?php

/**
 * This is the model class for table "{{relationship}}".
 *
 * The followings are the available columns in table '{{relationship}}':
 * @property integer $id
 * @property integer $uid1
 * @property integer $uid2
 * @property integer $state
 * @property integer $history
 *
 */
class Relationship extends CActiveRecord
{
    const RS_NONE       = 0;
    const RS_FOLLOW     = 1;
    const RS_INVITING   = 2;
    const RS_INVITED    = 3;
    const RS_AGREED     = 4;

    /**
     *  STATE
     *  NONE:       无关系,当用户与企业间解除了任何关联后回到此状态,INVITING状态
     *  INVITING:   用户被企业邀请,但未对此邀请做出回应
     *  AGREE:      用户接受了企业邀请,此时企业可以给用户发送站内消息
     *  FOLLOW:     用户主动关注企业,此时用户会收到企业推送,企业可以给该用户发送站内消息
     *
     *
     *
     */


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{relationship}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid1, uid2, state', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, uid1, uid2, state', 'safe', 'on'=>'search'),
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
			'uid1' => 'Uid1',
			'uid2' => 'Uid2',
			'state' => 'State',
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
		$criteria->compare('uid1',$this->uid1);
		$criteria->compare('uid2',$this->uid2);
		$criteria->compare('state',$this->state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Relationship the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function get($user1, $user2){
        if ($user1 && $user1->type==User::UT_NORMAL){

        }
        if ($user2 && $user2->type == User::UT_ENTERPRISE){

        }


        $sql = 'SELECT * FROM ${this->tableName()} WHERE (uid1= AND uid2 =)  OR (uid1= AND uid2=)';
        $model = $this->findAllBySql($sql);
        if (!$model){

        }
    }
}
