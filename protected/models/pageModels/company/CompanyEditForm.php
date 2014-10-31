<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-17
 * Time: 下午1:28
 */

class CompanyEditForm extends CFormModel{
    public $id;
    public $formType = 'edit';
    public $name;
    public $type;
    public $industry;
    public $scale;
    public $homepage;
    public $description;
    public $province;
    public $city;
    public $address;
    public $contact;
    public $phone;
    public $mobile;
    public $emailList;
    public $tags;
    public $flag;
//    public $email;
    public $certification;
    public $agreement;


    public function rules(){
        return array(
            array('id, name, type, industry', 'safe'),
        );
    }

    public function save(){
//        Yii::log('here', CLogger::LEVEL_TRACE);
        $company = Company::model()->findByPk(Yii::app()->request->getParam('id'));
        if (!$company){
            Yii::log("company not found", CLogger::LEVEL_WARNING);
            return false;
        }

        $company->name = $this->name;
//        var_dump($this->attributes);
        $company->industry = $this->industry;

        if (!$company->save()){
            echo json_encode($company->getErrors());
            return false;
        }

//        return $company->save() ? $company: false;
        return $company;
    }

    public function validate($attributes = NULL, $clearErrors = true){
        return true;
    }

    public function create(){
        $company = Company::model()->find();
        if ($company){
            return false;
        }

        $company = new Company();
        $company->name = $this->name;
        $company->type = $this->type;
        $company->industry = $this->industry;
        $company->scale = $this->scale;
        $company->homepage = $this->homepage;
        $company->description = $this->description;
        $company->location = $this->location;

        return $company->save() ? $company : false;
    }

    public function loadModel($id){
        if (empty($id)){
            return false;
        }

        if (!$company = Company::model()->findByPk($id)){
            return false;
        }

        $this->id = $company->id;
        $this->name = $company->name;
        $this->type = $company->type;
        $this->province = Location::getProviceCode($company->location);
        $this->city = Location::getCityCode($company->location);
        $this->industry = $company->industry;
        $this->description = $company->description;
        $this->emailList = empty($company->email) ? array() : explode(',', $company->email);
        $this->flag = $company->flag;
        $this->address = $company->address;

        return $this;
    }
}