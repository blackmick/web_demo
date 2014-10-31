<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/28
 * Time: 下午1:19
 */

class UserController extends PersonalController{
    public function filters(){
        return array(
            array('PersonalFilter - create'),
        );
    }

    /**
     * 用户注册页面
     * @throws CHttpException
     */
    public function actionCreate(){

    }

    /**
     * 账号管理主页
     */
    public function actionIndex(){
        $this->render('index',null);
    }

    public function actionView(){

    }

    public function actionUpdate(){

    }

}