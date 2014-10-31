<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/27
 * Time: 下午4:36
 */

class ComController extends Controller{
    public function filters(){
        Yii::app()->user->loginUrl = Yii::app()->createUrl('site/login');
        return array(
            array('CompanyFilter')
        );
    }
}