<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/27
 * Time: 下午1:56
 */

class AccountController extends ComController{
    public function filters(){
        return array(
            array(
                'CompanyFilter + index'
            )
        );
    }

    public function actionCreate(){

    }

    public function actionIndex(){
        $account = CompanyAccount::model()->findByPk(Yii::app()->user->getId());
        $company = Company::model()->findByPk($account->cid);
        $this->render('index', array('model' => $account, 'company'=>$company));
    }

    public function actionView(){

    }

    public function actionLogin(){
        $model=new LoginForm();

        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];

            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()){
                $this->redirect(Yii::app()->user->returnUrl);
            }

        }

        $this->render('login',array('model'=>$model));
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * 注册页面
     */
    public function actionRegister(){
        $form = new RegisterForm();
        if (isset($_POST['RegisterForm'])){
            $form->attributes = $_POST['RegisterForm'];
            if ($form->validate() && $form->register())
                $this->redirect(Yii::app()->createUrl('company/attach'));
        }
        $this->render('register', array('model'=>$form));
    }
}