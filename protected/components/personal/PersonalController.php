<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/27
 * Time: 下午4:36
 */

class PersonalController extends Controller{
    public function filters(){
        Yii::app()->user->loginUrl = Yii::app()->createUrl('account/login');
        return array(
            array('PersonalFilter')
        );
    }
}
