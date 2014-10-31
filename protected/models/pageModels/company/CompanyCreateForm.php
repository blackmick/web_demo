<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/23
 * Time: 下午5:45
 */

class CompanyCreateForm extends CFormModel{
    public static $tipName = '请与贵公司营业执照注册名保持一致';
    public static $tipAddress = '请填写公司详细地址';
    public static $tipContact = '请填写联系人真实姓名';
    public static $tipPhone = '请填写联系人工作电话号码';
    public static $tipMobile = '请填写联系人手机号码';

    public static $errorName = '会员名不能为空';
    public $name;
    public $province;
    public $city;
    public $address;
    public $contact;
    public $phone;
    public $mobile;
    public $certification;
    public $agreement;

    public function rules(){
//        var_dump('here');
        return array(
            array('name',
                'required',
                'message'=> self::$errorName,
            ),
            array('name',
                'compare',
                'compareValue'=> self::$tipName,
                'operator' => '!=',
                'message' => '会员名不能为空',
            ),
            array(
                'province, city',
                'required',
                'message' => '请确定公司所在城市',
            ),
            array('address',
                'required',
                'message' => '地址不能为空',
            ),
            array('contact',
                'required',
                'message' => '联系人不能为空',
            ),
            array('phone',
                'required',
                'message' => '联系电话不能为空',
            ),
            array(
                'mobile',
                'required',
                'message' => '手机号码不能为空',
            ),

//            array('province, city, address, contact, phone, mobile, certification, agreement',
//                'required'
//            ),
            array('mobile', 'validateMobile'),
            array('name,province,city,address, contact, phone, mobile, certification, agreement', 'safe'),
            array('phone', 'validatePhone'),
//            array('province, city', 'validateLocation'),
            array('certification', 'required', 'message'=>'请上传'),
        );
    }

//    public function validate($attributes=null, $clearErrors=true){
//        if ($clearErrors){
//            $this->clearErrors();
//        }
//    }

    public function create(){
        $company = Company::model()->find("name = '{$this->name}'");
        if ($company){
            return false;
        }

        $company = new Company();
        $company->attributes = $this->attributes;
        $company->location = Location::getCode(array('province'=>$this->province, 'city'=>$this->city));

        if (!$company->save()){
            return false;
        }

        return $company;
    }

    public function validatePhone(){
        return true;
    }

    public function validateMobile(){
        return true;
    }
}