<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/25
 * Time: 上午10:44
 */

class UploadLicenseForm extends CFormModel{
    public static $errorMsg = array(
        'certification' => '请上传营业执照',
    );
    public $certification;

    public function rules(){
        return array(
            array('certification', 'required', 'message'=>self::$errorMsg['certification']),
            array('certification', 'length', 'min'=>40, 'max'=>80),
            array('certification', 'safe'),
        );
    }

    /**
     * @param Company $company
     * @return mixed
     */
    public function upload($company){
        if (!$company)
            return false;
        $company->certification = $this->certification;

        return $company->save() ? $company : false;
    }
}