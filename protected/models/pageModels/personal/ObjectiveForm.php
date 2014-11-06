<?php
/**
 * Created by PhpStorm.
 * User: 韩啸
 * Date: 2014/11/5
 * Time: 15:04
 */

class ObjectiveForm extends CFormModel{
    public $industry;
    public $function;
    public $location;
    public $salary;

    public function validate($attributes=null, $clearErrors=true)
    {

    }
}