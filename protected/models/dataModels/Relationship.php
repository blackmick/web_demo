<?php

/**
 * This is the model class for table "{{relationship}}".
 *
 * The followings are the available columns in table '{{relationship}}':
 * @property integer $uid
 * @property integer $cid
 * @property integer $state
 * @property integer $last_invite
 *
 */
class Relationship extends CActiveRecord
{
    const INVITE_PERIOD = 3600; // seconds.

    const FSM_STATE_NONE       = 1;
    const FSM_STATE_FOLLOW_WITH_PUBLIC     = 2;
    const FSM_STATE_FOLLOW_WITHOUT_PUBLIC = 3;
    const FSM_STATE_FOLLOW_WITH_RESTRICT = 4;
    const FSM_STATE_RESTRICT = 5;
    const FSM_STATE_INVITING_FROM_NONE = 6;
    const FSM_STATE_INVITING_FROM_FOLLOW_WITHOUT_PUBLIC = 7;

    const FSM_ACTION_INVITE = 1;
    const FSM_ACTION_ACCEPT = 2;
    const FSM_ACTION_REJECT = 3;
    const FSM_ACTION_FOLLOW_WITH_PUBLIC = 4;
    const FSM_ACTION_FOLLOW_WITHOUT_PUBLIC = 5;
    const FSM_ACTION_UNFOLLOW = 6;
    const FSM_ACTION_PUBLIC = 7;
    const FSM_ACTION_UNPUBLIC = 8;


    /**
     * FSM 定义:
     *
     */
    static $FSM_ENGINE = array(
        self::FSM_STATE_NONE => array(
            self::FSM_ACTION_INVITE => array(
                'target' => self::FSM_STATE_INVITING_FROM_NONE,
                'action' => 'doInvite',
                'check' => 'checkInvite',
            ),
            self::FSM_ACTION_FOLLOW_WITH_PUBLIC => array(
                'target' => self::FSM_STATE_FOLLOW_WITH_PUBLIC,
                'action' => 'doFollowWithPublic',
            ),
            self::FSM_ACTION_FOLLOW_WITHOUT_PUBLIC => array(
                'target' => self::FSM_STATE_FOLLOW_WITHOUT_PUBLIC,
                'action' => 'doFollowWithoutPublic',
            ),
        ),

        self::FSM_STATE_INVITING_FROM_NONE => array(
            self::FSM_ACTION_ACCEPT => array(
                'target' => self::FSM_STATE_RESTRICT,
                'action' => 'doAccept',
            ),
            self::FSM_ACTION_REJECT => array(
                'target' => self::FSM_STATE_NONE,
                'action' => 'doReject',
            ),
            self::FSM_ACTION_FOLLOW_WITH_PUBLIC => array(
                'target' => self::FSM_STATE_FOLLOW_WITH_PUBLIC,
                'action' => 'doFollowWithPublic',
            ),
            self::FSM_ACTION_FOLLOW_WITHOUT_PUBLIC => array(
                'target' => self::FSM_STATE_FOLLOW_WITHOUT_PUBLIC,
                'action' => 'doFollowWithoutPublic',
            ),
        ),
        self::FSM_STATE_RESTRICT => array(
            self::FSM_ACTION_FOLLOW_WITH_PUBLIC => array(
                'target' => self::FSM_STATE_FOLLOW_WITH_PUBLIC,
                'action' => 'doFollowWithPublic',
            ),
            self::FSM_ACTION_FOLLOW_WITHOUT_PUBLIC => array(
                'target' => self::FSM_STATE_FOLLOW_WITH_RESTRICT,
                'action' => 'doFollowWithoutPublic',
            ),
        ),
        self::FSM_STATE_FOLLOW_WITH_RESTRICT => array(
            self::FSM_ACTION_UNFOLLOW => array(
                'target' => self::FSM_STATE_NONE,
                'action' => 'doUnfollow',
            ),
        ),
        self::FSM_STATE_INVITING_FROM_FOLLOW_WITHOUT_PUBLIC=>array(
            self::FSM_ACTION_ACCEPT => array(
                'target' => self::FSM_STATE_FOLLOW_WITH_RESTRICT,
                'action' => 'doAccept',
            ),
            self::FSM_ACTION_REJECT => array(
                'target' => self::FSM_STATE_FOLLOW_WITHOUT_PUBLIC,
                'action' => 'doReject',
            ),
            self::FSM_ACTION_FOLLOW_WITHOUT_PUBLIC => array(
                'target' => self::FSM_STATE_FOLLOW_WITH_PUBLIC,
                'action' => 'doFollowWithPublic',
            ),
        ),
        self::FSM_STATE_FOLLOW_WITHOUT_PUBLIC =>array(
            self::FSM_ACTION_INVITE => array(
                'target' => self::FSM_STATE_INVITING_FROM_FOLLOW_WITHOUT_PUBLIC,
                'action' => 'doInvite',
                'check' => 'checkInvite',
            ),
            self::FSM_ACTION_UNFOLLOW => array(
                'target' => self::FSM_STATE_NONE,
                'action' => 'doUnfollow',
            ),
            self::FSM_ACTION_PUBLIC => array(
                'target' => self::FSM_STATE_FOLLOW_WITH_PUBLIC,
                'action' => 'doFollowWithPublic',
            ),
        ),
        self::FSM_STATE_FOLLOW_WITH_PUBLIC => array(

            self::FSM_ACTION_UNFOLLOW => array(
                'target' => self::FSM_STATE_NONE,
                'action' => 'doUnfollow',
            ),
            self::FSM_ACTION_UNPUBLIC =>array(
                'target' => self::FSM_STATE_FOLLOW_WITHOUT_PUBLIC,
                'action' => 'doAntiPublic',
            ),
        ),
    );

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
			array('uid, cid, state', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
//			array('id, uid1, uid2, state', 'safe', 'on'=>'search'),
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
//			'uid1' => 'Uid1',
//			'uid2' => 'Uid2',
//			'state' => 'State',
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

//		$criteria->compare('id',$this->id);
//		$criteria->compare('uid',$this->uid);
//		$criteria->compare('cid',$this->cid);
//		$criteria->compare('state',$this->state);

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

    /**
     * @param $user
     * @param $company
     * @return bool|mixed
     */
    public function get($user, $company){
        $sql = "SELECT * FROM tbl_relationship WHERE uid='{$user->id}' AND cid = {$company->id}";
        $relationShip = $this->findBySql($sql);
        if ($relationShip){
            return $relationShip->state;
        }else{
            return false;
        }
    }

    /**
     * check the relationship between user and company, whether they can do the action.
     * @param $user
     * @param $company
     * @param $action
     *
     * @return boolean
     */
    public function check($user, $company, $action){
        $sql = "SELECT * FROM tbl_relationship WHERE uid = {$user->id} AND cid = {$company->id}";
        $rel = $this->findBySql($sql);
        if($rel){
            $cur_state = $rel->state;

        }else{
            $cur_state = self::FSM_STATE_NONE;
        }
        $doCheck = self::$FSM_ENGINE[$cur_state][$action]['check'];
        return $this->$doCheck($user,$company);
    }

    public function add($user, $company, $action){
        $sql = "SELECT * FROM tbl_relationship WHERE uid = {$user->id} AND cid = {$company->id}";
        $rel = $this->findBySql($sql);
        if($rel){
            $cur_state = $rel->state;

        }else{
            $this->uid = $user->id;
            $this->cid = $company->id;
            $cur_state = self::FSM_STATE_NONE;
        }


        if (isset(self::$FSM_ENGINE[$cur_state][$action])){
            // do the check
            if (isset(self::$FSM_ENGINE[$cur_state][$action]['check'])){
                $checkFunc = self::$FSM_ENGINE[$cur_state][$action]['check'];
                $check = $this->$checkFunc($company, $user, $action);
                if (!$check)
                    return false;
            }

            // take the action and transfer the state.
            $target_state = self::$FSM_ENGINE[$cur_state][$action]['target'];
            $doAction = self::$FSM_ENGINE[$cur_state][$action]['action'];
            $this->state = $target_state;
            $this->$doAction();
            $this->save() or ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL);
            Yii::log("RELATIONSHIP FSM:[{$cur_state}]->[{$target_state}] action[{$doAction}]", CLogger::LEVEL_INFO);
            return true;
        }else{
            return false;
        }
    }

    public function doNothing(){

    }

    public function actionError(){

    }

    private function doInvite(){
        $this->last_invite = time();
    }

    private function checkInvite($company, $user, $action){
        return Invite::check($company, $user, $this->last_invite);
    }

    static public function getInstance($company, $user){
        $instance = new self;
        $tbl_name = $instance->tableName();
        $sql = "SELECT * FROM ${tbl_name} WHERE uid = '{$user->id}' and cid = '{$company->id}'";

        $instance = $instance->findBySql($sql);

        if (!$instance){
            $instance = new Relationship();
            $instance->uid = $user->id;
            $instance->cid = $company->id;
            $instance->state = Relationship::FSM_STATE_NONE;
            $instance->last_invite = 0;
            $instance->save() or ErrorHelper::Fatal(ErrorHelper::ERR_CREATE_RELATIONSHIP_FAIL,array($instance->getErrors()));
        }

        return $instance;
    }
}
