<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/20
 * Time: 下午12:57
 */

class LocationController extends Controller{
    public function actionCitylist(){

//        Yii::app()->end();
//        if(!Yii::app()->request->isAjaxRequest)
//            throw new CHttpException(404);
        $pid = Yii::app()->request->getPost("id");
        $list = Location::getCityList($pid);
//        var_dump($list);
        //$data = CHtml::listData($list, 'id', 'name');
//        print_r($list);
        foreach ($list as $id=>$name){
            echo CHtml::tag('option', array('value'=>$id), CHtml::encode($name), true);
//            Yii::log("add option:".$name, CLogger::LEVEL_TRACE);
        }
        //echo json_encode($list);
    }
}