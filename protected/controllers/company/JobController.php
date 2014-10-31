<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-17
 * Time: 下午2:58
 */

class JobController extends ComController{

    public function actionCreate(){
        $form = new JobEditForm();
        if (isset($_POST['JobEditForm'])){

            $form->attributes = $_POST['JobEditForm'];
            if ($job = $form->create()){
                $this->redirect(Yii::app()->createUrl('job/view',array('id'=> $job->id)));
            }
        }
        $this->render('create', array('model'=>$form));
    }

    public function actionList(){
        $ca = CompanyAccount::model()->findByPk(Yii::app()->user->getId());

        $job = Job::model();
        $job->cid = $ca->cid;
        //$list = $job->findAll("cid='{$cid}'");

        $dataProvider = new CActiveDataProvider('Job',
            array(
                'criteria' => array(
                    'condition' => "cid = '{$ca->cid}'",
                    'order' => 'id DESC',
//                    'with' => array('CompanyAccount'),
                ),
                'pagination'=> array(
                    'pageSize'=>2,
                )
            ));

//        var_dump($dataProvider->getData());
        $this->render('list', array('model' => $job));
    }

    public function actionView(){
        $id = Yii::app()->request->getParam('id');
        $job = Job::model()->findByPk($id);
        if ($job){
            $this->render('view',array('model'=>$job));
        }
    }

    public function actionUpdate(){
        $id = Yii::app()->request->getParam('id');
        $form = new JobEditForm();
        if (isset($_POST['JobEditForm'])){

            $form->attributes = $_POST['JobEditForm'];
            if ($job = $form->create()){
                $this->redirect(Yii::app()->createUrl('job/list',array('id'=> $job->id)));
            }
        }else{
            $form->loadModel($id);
        }
        $this->render('edit', array('model'=>$form));
    }

    public function actonDelete(){
        $job = Job::model()->findByPk(Yii::app()->request->getParam('id'));
        var_dump($job);
        $job->detete();
        //$this->redirect(Yii::app()->user->returnUrl);
    }
}