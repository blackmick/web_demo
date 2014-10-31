<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/27
 * Time: 下午4:35
 */
class CompanyFilter extends CFilter{
    public function preFilter($filterChain)
    {
        if (Yii::app()->user->getType() !== 'company') {
            $filterChain->controller->redirect(Yii::app()->user->loginUrl);
            return false;
        }
        return true;
    }
}