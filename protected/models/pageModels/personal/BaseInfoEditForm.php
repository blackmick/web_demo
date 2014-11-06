<?php
/**
 * Created by PhpStorm.
 * User: 韩啸
 * Date: 2014/11/6
 * Time: 13:37
 */

class BaseInfoEditForm extends CFormModel{
    public $birth;
    public $marriage;
    public $mobile;
    public $email;
    public $nationality;
    public $state;

    public function validate($attributes=null, $clearErrors=true){

    }
}