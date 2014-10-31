<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/21
 * Time: 上午11:51
 */

class FuncController extends ComController{
    public function actionCategory(){
        return Functype::getCategory();
    }

    public function actionType(){
        if (!Yii::app()->request->isAjaxRequest){
            throw new CHttpException(404, 'not ajax request');
        }

        $id = Yii::app()->request->getParam('id');
        $list =  Functype::getType($id);
        foreach($list as $value=>$name){
            echo CHtml::tag('option', array('value'=>$value), CHtml::encode($name));
        }
    }
}