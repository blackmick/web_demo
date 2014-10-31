<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-17
 * Time: 下午2:56
 */

class SearchController extends ComController{
    public function actionCandidate(){
        $form = new SearchCandidateForm();

        $this->render('candidate', array('model'=>$form));
    }

}