<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-1
 * Time: 11:15
 */

class JobDetailController extends Controller{
    public function actionIndex()
    {
        $jobID = Yii::app()->request->getParam('jid');
        $jobModel = new Job();
        $oData = $jobModel->find('id='.$jobID);
        $attrs = $oData->getAttributes();
        echo json_encode($attrs);
    }
}