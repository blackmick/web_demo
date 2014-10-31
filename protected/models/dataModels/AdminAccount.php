<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-10
 * Time: 下午3:14
 */
/**
 * This is the model class for table "{{admin_account}}".
 *
 * The followings are the available columns in table '{{admin_account}}':
 * @property integer $id
 * @property string  $username
 * @property string  $password
 * @property string  $token
 * @property integer $last_login
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 */

class AdminAccount extends UserBase
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{admin_account}}';
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
     * @return User the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 获取用户详细信息,用户的相关信息都会获取得到
     * @return mixed
     */
    public function getDetail(){

    }
}