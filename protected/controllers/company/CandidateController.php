<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/26
 * Time: 下午12:23
 */

class CandidateController extends ComController{
    public function actionList(){
        $type = Yii::app()->request->getParam('type');

        switch($type){
            case '':
                break;
            case '':
                break;
        }
    }
}