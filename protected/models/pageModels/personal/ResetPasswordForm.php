<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/30
 * Time: 上午10:59
 */

class ResetPasswordForm extends CFormModel{
    public $email;
    public $verifyCode;

    public function rules(){
        return array(
            array('verifyCode', 'required'),
            array('verifyCode', 'safe'),
        );
    }

    public function reset(){

    }
}