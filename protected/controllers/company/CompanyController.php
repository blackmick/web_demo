<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-17
 * Time: 下午1:27
 */

class CompanyController extends ComController{

    public function filters(){
        return array(
            array(
                'CompanyFilter - create, review',
            )
        );
    }
    public function actionUpdate(){
        $form = new CompanyEditForm();
//        var_dump($_POST);
        if (isset($_POST["CompanyEditForm"])){
            Yii::log('here before save', CLogger::LEVEL_TRACE);
            $form->attributes = $_POST["CompanyEditForm"];
            if ($form->save()){
//                var_dump('here');
                $this->redirect(Yii::app()->createUrl('company/view', array('id'=>$form->id)));
            }else{
//                throw new CHttpException(500);
            }
        }else{
            $form = $form->loadModel(Yii::app()->request->getParam('id'));
            $this->render("edit", array("model"=>$form));
        }
    }

    public function actionAttach(){
        $id = Yii::app()->request->getParam('id');
        if (!empty($id) && is_numeric($id)){
            //do attach
            $ca = CompanyAccount::model()->findByPk(Yii::app()->user->getId());
            $company = Company::model()->findByPk($id);
            if ($ca && $company && $company->attachAccount($ca)){
                $this->redirect(Yii::app()->homeUrl);
            }
            Yii::app()->end();
        }


        $form = new AttachForm();
        if (isset($_POST['AttachForm'])){
            $form->attach();
            $this->redirect(Yii::app()->createUrl('site/index'));
        }

        $this->render('attach', array("model" => $form));
    }

    /**
     * 搜索结果
     */

    public function actionSearch(){
    }

    public function actionCreate(){
        if (!Yii::app()->user->getIsGuestWithType('company')){
            $this->redirect(Yii::app()->createUrl('site/logout'));
        }
        $form = new CompanyCreateForm();
        $this->performAjaxValidation($form);
        if (isset($_POST["CompanyCreateForm"])){
            $form->attributes = $_POST['CompanyCreateForm'];
            if ($company = $form->create()){
                $this->redirect(Yii::app()->createUrl('company/review', array('id'=>$company->id)));
            }else{
                throw new CHttpException(500);
            }
        }

        $this->render("create", array("model"=>$form));
    }

    public function actionView(){
        $company = Company::model()->findByPk(Yii::app()->request->getParam('id'));
        if (!$company){
            throw new CHttpException(404);
        }

        $this->render('view', array('company'=>$company));
    }


    public function performAjaxValidation($model){
        if (isset($_POST['ajax']) && $_POST['ajax'] == "CompanyCreateForm"){
            if (isset($_POST['CompanyCreateForm']['name'])){
                $companyName = $_POST['CompanyCreateForm']['name'];
                if (empty($companyName)){
                    $result[CHtml::activeId($model,'name')]=array(CompanyCreateForm::$errorName);
                    echo json_encode($result);
                    Yii::app()->end();
                }else{
                    $company = Company::model()->find("name = '$companyName'");
                    if ($company){
                        $result[CHtml::activeId($model,'name')]=array('您要注册的会员已存在');
                        echo json_encode($result);
                        Yii::app()->end();
                    }
                }
            }
            Yii::app()->end();
        }
    }

    public function actionUploadLicense(){
        $cid = Yii::app()->request->getParam('id');
        $company = Company::model()->findByPk($cid);
        $form = new UploadLicenseForm();

        if (isset($_POST['UploadLicenseForm'])){
            $form->attributes = $_POST['UploadLicenseForm'];
            if ($form->upload($company)){
                $this->redirect(Yii::app()->createUrl('company/review'));
            }else{
                throw new CHttpException(500);
            }
        }

        $this->render('uploadLicense', array('model'=>$form));
    }

    public function actionReview(){
        $this->render('review', null);
    }
}