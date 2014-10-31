<?php

class SiteController extends PersonalController
{
	/**
	 * Declares class-based actions.
	 */
    public function filters(){
        return array(
            array(
                'PersonalFilter - login,error'
            )
        );
    }

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
//        if (Yii::app()->user->getIsGuest() || Yii::app()->user->getType() != 'personal')
//        {
//            $this->redirect($this->createUrl('login'));
//        }else{
//            $ca = CompanyAccount::model()->findByPk(Yii::app()->user->getId());
//            if ($ca){
//                $model = Company::model()->findByPk($ca->cid);
//                if ($model){
//                    $this->render('index', array('model' => $model));
//                    Yii::app()->end();
//                }else{
//                    $this->redirect(Yii::app()->createUrl('company/attach'));
//                }
//            }else{
//                Yii::app()->user->logout();
//                $this->redirect($this->createUrl('login'));
//            }
//        }

        $this->render('index');
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