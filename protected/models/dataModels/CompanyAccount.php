<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-9
 * Time: 下午7:23
 */

/**
 * This is the model class for table "{{company_account}}".
 *
 * The followings are the available columns in table '{{company_account}}':
 * @property integer $id
 * @property string  $username
 * @property string  $password
 * @property string  $token
 * @property integer $last_login
 * @property string  $cid
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $coin
 * @property integer $status
 */
class CompanyAccount extends UserBase
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{company_account}}';
    }

    public static function getInsByUserName($username){
        return self::model()->find("username = '{$username}'");
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password', 'required'),
            array('username, password', 'length', 'max'=>128),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username', 'safe', 'on'=>'search'),
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
            'username' => 'Username',
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
        $criteria->compare('username',$this->username,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CompanyAccount the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 获取用户详细信息,用户的相关信息都会获取得到
     * @param integer $id
     * @return mixed
     */

    public function getDetail($id = null){
        if ($id){
            $this->findByPk($id);
        }

        $oData['id'] = $this->id;
        $oData['token'] = $this->token;
        $oData['cid'] = empty($this->cid) ? null : $this->cid;
        $oData['last_login'] = $this->last_login;
        $oData['logo'] = Utils::getImgUrl($this->logo);

        return $oData;
    }

    /**
     * @param int $cost
     * @return bool
     */
    public function checkBalance($cost = 0){
        return ($this->coin - $cost) >= 0;
    }

    public function getBalance(){
        return $this->coin;
    }

    public function getList(){
        return new CActiveDataProvider(
            'CompanyAccount',
            array(
                'criteria' => array(
                    'condition' => "cid='{$this->cid}'",
                ),
                'pagination' => array(
                    'pageSize' => 10,
                )
            )
        );
    }
}
