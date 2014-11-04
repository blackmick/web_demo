<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/11/2
 * Time: 上午11:38
 */

class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
//    public function filters(){
//        return array(
//            array(
//                'PersonalFilter - index, error'
//            )
//        );
//    }

    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $this->layout = 'login';
        $model = null;
        if (!Yii::app()->user->getIsGuest()){
            $type = Yii::app()->user->getType();
            $url="";
            switch($type){
                case "personal":
                    $url = "/myjober/personal";
                    break;
                case "company":
                    $url = "/myjober/company";
                    break;
                case "admin":
                    $url = "/myjober/admin";
                    break;
                default:
                    $personalModel = new PersonalLoginForm();
                    $companyModel = new CompanyLoginForm();
                    $this->render('index',
                        array(
                            'personalModel' => $personalModel,
                            'companyModel' => $companyModel
                        )
                        );
                    break;
            }
            $this->redirect($url);
        }

        $personalModel = new PersonalLoginForm();
        $companyModel = new CompanyLoginForm();
        $this->render('index',
            array(
                'personalModel' => $personalModel,
                'companyModel' => $companyModel
            )
        );
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model=new ContactForm;
        if(isset($_POST['ContactForm']))
        {
            $model->attributes=$_POST['ContactForm'];
            if($model->validate())
            {
                $name='=?UTF-8?B?'.base64_encode($model->name).'?=';
                $subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
                $headers="From: $name <{$model->email}>\r\n".
                    "Reply-To: {$model->email}\r\n".
                    "MIME-Version: 1.0\r\n".
                    "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
                Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact',array('model'=>$model));
    }

    /**
     * Displays the login page
     */
//	public function actionLogin()
//	{
//
//	}

    /**
     * Logs out the current user and redirect to homepage.
     */
//	public function actionLogout()
//	{
//
//	}
}