<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/27
 * Time: 下午3:44
 */

class AdminFilter extends CFilter{
    public function preFilter($filterChain){
        if ($filterChain->controller->getAction()->getId()!='login'){
            if (Yii::app()->user->getType() !== 'admin'){
                $filterChain->controller->redirect(Yii::app()->user->loginUrl);
                return false;
            }
        }

        return true;
    }
}