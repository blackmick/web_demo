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
        if (!$user){
            $this->redirect(Yii::app()->user->loginUrl);
        }

        $objectiveForm = new ObjectiveForm();
        $baseInfoEditForm = new BaseInfoEditForm();

        $profileList = Profile::model()->findByAttributes(array('uid'=>$user->id));
        if (is_array($profileList) && count($profileList)){
            foreach($profileList as $profile){
                $eduList = Education::model()->findByAttributes(array('pid'=>$profile->id));
                $wordExpList = WorkExperience::model()->findByAttributes(array('pid'=>$profile->id));
                $projectExpList = ProjectExperience::model()->findByAttributes(array('pid'=>$profile->id));
                $profile->edu = $eduList;
                $profile->work_exp = $wordExpList;
                $profile->proj_exp = $projectExpList;
                $user->profile[$profile->language] = $profile;
            }
        }

        $this->render('index',
            array(
                'user'=>$user,
                'objective'=>$objectiveForm,
                'baseInfoEdit' => $baseInfoEditForm,
            ));
    }

    public function actionAjaxUpdate(){

    }

    public function actionUploadHead(){
        if (Yii::app()->request->isAjaxRequest){
            $uploadfile = CUploadedFile::getInstanceByName('image_file');
            if ($uploadfile){

                $filecont = file_get_contents($uploadfile->tempName);
                $contSign = UploadService::getInstance()->uploadContent($filecont);

                echo json_encode(array('status'=>0, 'url'=>Utils::getImgUrl($contSign)));
            }else{
                echo json_encode(array('status'=>1));
            }

        }else{
            echo json_encode(array('status'=>1));
        }
    }
} 