<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/27
 * Time: 下午4:36
 */

class ComController extends Controller{
    public function filters(){
//        Yii::app()->user->loginUrl = Yii::app()->createUrl('site/login');
        Yii::app()->user->loginUrl - Yii::app()->baseUrl.'/index.php';
        return array(
            array('CompanyFilter')
        );
    }
}