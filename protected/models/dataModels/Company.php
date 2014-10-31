<?php

/**
 * This is the model class for table "{{company}}".
 *
 * The followings are the available columns in table '{{company}}':
 * @property integer $id
 * @property string  $accounts
 * @property string  $name
 * @property integer $type
 * @property integer $industry
 * @property integer $scale
 * @property string  $homepage
 * @property string  $description
 * @property integer $location
 * @property string  $address
 * @property string  $contact
 * @property string  $phone
 * @property string  $mobile
 * @property string  $email
 * @property string  $logo
 * @property string  $certification
 * @property string  $tags
 * @property integer $flag
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
    static private $_typeMap=array(
        '1' => '外资(欧美)',
        '2' => '外资(非欧美)',
        '3' => '合资',
        '4' => '民营公司',
        '5' => '其他性质',
    );

    private static $_scaleMap = array(
        '1' => '少于50人',
        '2' => '50-150人',
        '3' => '150-500人',
        '4' => '500-1000人',
        '5' => '1000-5000人',
        '6' => '5000-10000人',
        '7' => '10000人以上'
    );

    const   COMPANY_STATUS_NEW = 0;
    const   COMPANY_STATUS_APPROVED = 1;
    const   COMPANY_STATUS_DENIED = 2;

    const   CF_NONE = 0;
    const   CF_SHOW_EXT = 1;

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
			array('type, industry, scale, location', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
            array('homepage', 'length', 'max'=>128),
            array('description', 'length', 'max'=>2048),
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
//	public function attributeLabels()
//	{
//		return array(
//			'id' => 'ID',
//			'name' => 'Name',
//			'type' => 'Type',
//			'industry' => 'Industry',
//			'homepage' => 'Homepage',
//		);
//	}

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
	public function search($request)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

//		$criteria=new CDbCriteria;
//
//		$criteria->compare('id',$this->id);
//		$criteria->compare('name',$this->name, true);
//		$criteria->compare('type',$this->type);
//		$criteria->compare('industry',$this->industry);
////		$criteria->compare('homepage',$this->homepage,true);

        if (!is_array($request)){
            return false;
        }

        if (!isset($request['type']))
            $request['type'] = 'name';

        switch($request['type']){
            case 'name':
                return new CActiveDataProvider($this, array(
                    'criteria'=> array(
                        'condition' => "name like '%{$request['keyword']}%'"
                    ),
                    'pagination' => array(
                        'pageSize' => 10
                    )
                ));
                break;
            default:
                return false;
                break;
        }

        return false;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Company the static model class
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

    public function getData($id = null, $roll = 'user'){
        if ($id){
            $this->findByPk($id);
        }

        $oData['id'] = $this->id;
        $oData['name'] = $this->name;
        $oData['industry'] = $this->industry;
        $oData['industry_name'] = Industry::getName($this->industry);
        $oData['scale'] = $this->scale;
        $oData['type'] = $this->type;
        $oData['type_name'] = self::getTypeName($this->type);
        $oData['homepage'] = $this->homepage;
        $oData['desc'] = $this->description;
        if ($roll == 'owner'
            ||($this->flag | self::CF_SHOW_EXT && $roll == 'user')){
            $oData['address'] = $this->address;
            $oData['contact'] = $this->contact;
            $oData['phone'] = $this->phone;
            $oData['mobile'] = $this->mobile;
            $oData['email'] = $this->email;
        }

        return $oData;
    }

    public static function getTypeName($type){
        return self::$_typeMap[$type];
    }

    public static function getTypeList(){
        return self::$_typeMap;
    }

    public function attachAccount($account)
    {
        if ($this->accounts == ''){
            $this->accounts = $account->id;
        }else{
            $accountList = explode(',', $this->accounts);
            if (!in_array($account->id, $accountList)) {
                array_push($accountList, $account->id);

                $this->accounts = implode(',', $accountList);
            }
        }
        $account->cid = $this->id;

        return $this->save() && $account->save();
    }

    public function detachAccount($account){
        $accountList =  explode(',', $this->accounts);
        if (is_array($accountList)){
            $newList = array_diff($accountList, array($account->id));
            $this->accounts = implode(',', $newList);
            $account->cid = 0;
            return $this->save() && $account->save();
        }

        return true;
    }

    public function isAttached($account){
        if ($this->id == $account->cid){
            return true;
        }

        return false;
    }

    private function getBaseDetail($id = null){
        if ($id){
            $this->findByPk($id);
        }

        $oData['id'] = $this->id;
        $oData['name'] = $this->name;
        $oData['type'] = $this->type;
        $oData['industry'] = $this->industry;
        $oData['scale'] = $this->scale;
        $oData['homepage'] = $this->homepage;
        $oData['desc'] = $this->description;
        $oData['logo'] = empty($this->logo) ? null : Utils::getImgUrl($this->logo);

        return $oData;

    }

    private function getExtendDetail($id = null){
        if ($id){
            $this->findByPk($id);
        }

        $oData['address'] = $this->address;
        $oData['contact'] = $this->contact;
        $oData['phone'] = $this->phone;
        $oData['mobile'] = $this->mobile;
        $oData['email'] = $this->email;
        $oData['tags'] = $this->tags;

        return $oData;
    }

    public function getDetailForUser($id = null){
        $oData = $this->getBaseDetail($id);

        if ($this->flag == 1){
            $oData += $this->getExtendDetail();
        }

        return $oData;
    }

    public function getDetailForCompanyAccount($id = null){
        $oData = $this->getBaseDetail($id) + $this->getExtendDetail();
        return $oData;
    }

    //TODO:还需要定义哪些可以显示,哪些不能显示
    public function getDetailForHunter($id = null){
        $oData = $this->getBaseDetail($id);

        if ($this->flag == 1){
            $oData += $this->getExtendDetail();
        }

        return $oData;
    }

    public function getDetailForAdmin($id = null){
        $oData = $this->getBaseDetail($id) + $this->getExtendDetail();

        return $oData;
    }

    public function getSummary($id = null){
        return $this->getBaseDetail($id);
    }

    public static function getList($lastId, $reqNo){
        if ($lastId < 0){
            $sql = "SELECT * FROM tbl_company ORDER BY id DESC limit {$reqNo}";
        }else{
            $sql = "SELECT * FROM tbl_company WHERE id < '{$lastId}' ORDER BY id DESC limit {$reqNo}";
        }

        $list = self::model()->findAllBySql($sql);

        return $list;
    }

    public static function getScale($scale){
        if (isset(self::$_scaleMap[$scale])){
            return self::$_scaleMap[$scale];
        }else{
            return 'N/A';
        }
    }

    public static function create(){

    }

    public function approve(){
        $this->status = self::COMPANY_STATUS_APPROVED;
        return $this->save();
    }

    public function deny(){
        $this->status = self::COMPANY_STATUS_DENIED;
        return $this->save();
    }
}
