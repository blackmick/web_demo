<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/29
 * Time: 下午4:10
 */

class ProfileController extends PersonalController {
    public function actionIndex(){
        $user = User::model()->findByPk(Yii::app()->user->getId());
//        $this->layout = 'profile';
        $objectiveForm = new ObjectiveForm();
        $this->render('index',
            array(
                'user'=>$user,
                'objective'=>$objectiveForm,
            ));
    }

    public function actionAjaxObjetive(){

    }
} 