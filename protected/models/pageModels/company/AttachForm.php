<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/21
 * Time: 下午3:03
 */

class AttachForm extends CFormModel{
    public $name;
    public $cid;

    public function attach(){
        $ca = CompanyAccount::model()->findByPk(Yii::app()->user->getId());
        $company = Company::model()->findByPk($this->cid);
        if (!$ca || !$company){
            throw new CHttpException(500, 'company not found');
        }

        return $company->attachAccount($ca);
    }
}