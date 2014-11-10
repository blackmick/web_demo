<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/29
 * Time: 下午4:27
 */

class AccountController extends Controller{
//    public function filters(){
//        return array(
//            array(
//                'PersonalFilter - register, login, resetpassword, captcha'
//            ),
//        );
//    }

    public function actions(){
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    /**
     * 账号管理首页
     */
    public function actionIndex(){
        $this->render('index');
    }

    /**
     * 注册页面
     */
    public function actionRegister(){
        $regForm = new UserCreateForm();
        $this->performAjaxValidation($regForm);
        if (isset($_POST['UserCreateForm'])){
            $regForm->attributes = $_POST['UserCreateForm'];
            if($regForm->validate() && $regForm->register()){
                $this->redirect(Yii::app()->user->returnUrl);
            }else{
                throw new CHttpException(500);
            }
        }
        $this->render('register', array('model'=>$regForm));
    }

    /**
     * 登录页面
     */
    public function actionLogin(){
        $model=new LoginForm();

        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['UserLoginForm']))
        {
            $model->attributes=$_POST['UserLoginForm'];

            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()){
                $this->redirect(Yii::app()->user->returnUrl);
            }

        }

        $this->render('login',array('model'=>$model));
    }

    /**
     * 登出页面
     */
    public function actionLogout(){
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * 重置密码
     */
    public function actionResetPassword(){
        $form = new ResetPasswordForm();
        if (isset($_POST['ResetPasswordForm'])){
            $form->attributes = $_POST['ResetPasswordForm'];
            if($form->reset()){
                $this->redirect(Yii::app()->createUrl('account/logout'));
            }
        }
        $this->render('reset_password', array('model'=>$form));
    }

    /**
     * 修改密码
     */
    public function actionChangePassword(){

    }

    /**
     * 编辑账号页面
     */
    public function actionUpdate(){

    }

    /**
     * 账号详情页
     */
    public function actionView(){

    }


    private function performAjaxValidation($model){
        if (isset($_POST['ajax']) && $_POST['ajax'] == "UserCreateForm"){
            if (isset($_POST['UserCreateForm']['username'])){
                $username = $_POST['UserCreateForm']['username'];
                if (empty($username)){
                    $result[CHtml::activeId($model,'username')]=array('用户名不能为空');
                    echo json_encode($result);
                    Yii::app()->end();
                }else{
                    $user = User::model()->findByAttributes(array('username'=>$username));
                    if ($user){
                        $result[CHtml::activeId($model,'username')]=array('您要注册的会员已存在');
                        echo json_encode($result);
                        Yii::app()->end();
                    }
                }
            }
            Yii::app()->end();
        }
    }
}