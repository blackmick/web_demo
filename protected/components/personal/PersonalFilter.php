<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/28
 * Time: 上午11:22
 */
class PersonalFilter extends CFilter{
    public function preFilter($filterChain){
        Yii::log("action:".Yii::app()->controller->action->getId(), CLogger::LEVEL_TRACE);
        if (Yii::app()->controller->action->getId()=='captcha'){

            return true;
        }


        if (Yii::app()->user->getType() !== 'personal'){
//            $filterChain->controller->redirect(Yii::app()->baseUrl.'/index.php');
            $filterChain->controller->redirect(Yii::app()->createUrl('account/login'));
            return false;
        }
        return true;
    }
}