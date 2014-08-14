<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-1
 * Time: 11:26
 */

class JobListController extends Controller
{
    private  static $LIST_TYPE_SET = array(
        'recommend' => 'listRecommend',
        'search_by_e_name',
        'search'
    );

    public function actionIndex()
    {
        $listType = Yii::app()->request->getParam('ltype');
        if ($listType == null || !in_array($listType, array_keys(self::$LIST_TYPE_SET)))
        {
            ErrorHelper::Error(ErrorHelper::ERR_INVALID_PARAM, array('param'=>'ltype'));
        }

        $listFunc = self::$LIST_TYPE_SET[$listType];

        $response = $this->$listFunc();

        $oData = array(
            'status' => ErrorHelper::ERR_OK,
            'error message' => 'Success',
            'data' => $response
        );

        echo json_encode($oData);
    }

    private function listRecommend($param = null)
    {
//        $jobModel = Job::model();
//        $jobModel->findAllByAttributes()
        $dataProvider = new CActiveDataProvider('Job',
            array(
                'criteria' => array(
                    'order' => 'publish_time DESC',
                ),
                'countCriteria' => array(
                    'condition'=> 'status = 0',
                ),
                'pagination' => array(
                    'pageSize'=> 20,
                )
            ));
        $jobRecord = $dataProvider->getData();
        $jobData = DataHelper::convertModelToArray($jobRecord);
        //var_dump($jobData);
        return $jobData;
    }
}