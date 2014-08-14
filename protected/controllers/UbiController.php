<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-11
 * Time: 上午11:18
 */

class UbiController extends SafeController{
    public function actionUpdate(){
        $opModel = $this->validatePrivilege();

        $ubi_id = DataHelper::getIntReq('id');
        $firstName = DataHelper::getStrReq('first_name');
        $midName = DataHelper::getStrReq('mid_name');
        $lastName = DataHelper::getStrReq('last_name');
        $location = DataHelper::getIntReq('location');
        $industry = DataHelper::getIntReq('industry');
        $title = DataHelper::getStrReq('title');
        $phone = DataHelper::getStrReq('phone');
        $address = DataHelper::getStrReq('address');
        $email = DataHelper::getStrReq('email');

        var_dump($firstName);

        if ($opModel->base_info != $ubi_id){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PARAM);
        }

        $ubiModel = UserBaseinfo::model()->findByPk($ubi_id);
        if (!$ubiModel){
            ErrorHelper::Fatal(ErrorHelper::ERR_UBI_NOT_FOUND);
        }

        $ubiModel->first_name = $firstName;
        $ubiModel->mid_name = $midName;
        $ubiModel->last_name = $lastName;
        $ubiModel->location = $location;
        $ubiModel->industry = $industry;
        $ubiModel->title = $title;
        $ubiModel->phone = $phone;
        $ubiModel->address = $address;
        $ubiModel->email = $email;

//        var_dump($ubiModel);

        $isOk = $ubiModel->save();
        if(!$isOk){
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, 'update user base info fail:'.json_encode($ubiModel->getErrors()));
        }

        ErrorHelper::Success();
    }

    public function actionView(){

    }
}