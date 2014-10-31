<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-17
 * Time: 下午1:27
 */

class CompanyController extends Controller{

    public function actionUpdate(){
        $form = new CompanyEditForm();
        if (isset($_POST["CompanyEditForm"])){
            Yii::log('here before save', CLogger::LEVEL_TRACE);
            $form->attributes = $_POST["CompanyEditForm"];
            if ($form->save()){
                $this->redirect(Yii::app()->createUrl('company/view', array('id'=>$form->id)));
            }else{
                throw new CHttpException(500);
            }
        }else{
            $form = $form->loadModel(Yii::app()->request->getParam('id'));
            $this->render("edit", array("model"=>$form));
        }
    }

    /**
     * 搜索结果
     */
    public function actionSearch(){
    }

    public function actionApprove(){
        $form = new CompanyCreateForm();
        $this->performAjaxValidation($form);
        if (isset($_POST["CompanyCreateForm"])){
            $form->attributes = $_POST['CompanyCreateForm'];
            if ($company = $form->create()){
                $this->redirect(Yii::app()->createUrl('company/uploadlicense', array('id'=>$company->id)));
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

    public function actionList(){
        $type = Yii::app()->request->getParam('type');

        switch(strtolower($type)){
            case 'new':
                $condition = "status = '".Company::COMPANY_STATUS_NEW."'";
                break;
            case 'approved':
                $condition = "status = '".Company::COMPANY_STATUS_APPROVED."'";
                break;
            case 'denied':
                $condition = "status = '".Company::COMPANY_STATUS_DENIED."'";
                break;
            default:
                throw new CHttpException(500);
                break;
        }

        $dataProvider = new CActiveDataProvider('Company',
            array(
                'criteria' => array(
                    'condition' => $condition,
                    'order' => 'id desc',
                ),
                'pagination' => array(
                    'pageSize' => 10,
                ),
            )
        );

        $this->render('list', array('dataProvider'=>$dataProvider));
    }

    public function actionReview(){
        $action = Yii::app()->request->getParam('action');
        $id = Yii::app()->request->getParam('id');
        $company = Company::model()->findByPk($id);
        if (!$company){
            throw new CHttpException(404);
        }

        switch($action){
            case 'approve':
                if($company->approve()){
                    $newAccount = new CompanyAccount();
                    $newAccount->cid = $company->id;
                    $newAccount->password = '000000';
                    $newAccount->username = 'admin';
                    $result = $newAccount->save();
                }else{
                    $result = false;
                }

                break;
            case 'deny':
                $result = $company->deny();
                break;
            default:
                throw new CHttpException(500);
                break;
        }

        if ($result){
            $this->redirect(Yii::app()->createUrl('company/list', array('type'=>'approved')));
        }else{
            throw new CHttpException(500);
        }
    }
}