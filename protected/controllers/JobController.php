<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-1
 * Time: 11:26
 */

class JobController extends SafeController
{
//    private  static $LIST_TYPE_SET = array(
//        'recommend' => 'listRecommend',
//        'search_by_e_name',
//        'search'
//    );

    /**
     * 创建职位,只能企业用户或管理员创建
     */
    public function actionCreate()
    {
        $user = $this->validatePrivilege();
        $cid = DataHelper::getIntReq('cid');
        if (!($user->type == User::UT_ENTERPRISE && $user->profile == $cid)
            || $user->type != User::UT_ADMIN){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE);
        }

        $job = new Job();
        $model = $this->setJob($job);
        $data['id'] = $model->id;
        ErrorHelper::Success($data);
    }

    /**
     * 更新职位信息,只能企业用户或管理员修改
     */
    public function actionUpdate(){
        $user = $this->validatePrivilege();
        $job = $this->loadModel(DataHelper::getIntReq('id'));

        if (!($user->type == User::UT_ENTERPRISE && $user->profile == $job->company_id)
            || $user->type != User::UT_ADMIN){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE);
        }

        $this->setJob($job);
        ErrorHelper::Success();
    }

    /**
     * 获取某职位详细信息,无特殊权限限制
     */
    public function actionDetail(){
        $this->validatePrivilege();
        $job = $this->loadModel(DataHelper::getIntReq('id'));
        $data[] = $job->getData();
        $this->render(null, $data, false, 'data');
    }

    /**
     * 职位列表,无特殊权限限制,列出最新职位
     */
    public function actionList(){
        $this->validatePrivilege();
        $jobs = Job::model()->findAllBySql('SELECT * FROM `tbl_job` ORDER BY `publish_time` DESC');
        $this->render(null, $jobs, false, 'data');
    }

    /**
     * 搜索职位,无特殊权限限制,返回符合条件的职位列表
     */
    public function actionSearch(){

    }

    /**
     * 删除职位信息,只有管理员和该职位发布者有权限
     */
    public function actionDelete(){
        $user = $this->validatePrivilege();
        $job = $this->loadModel(DataHelper::getIntReq('id'));

        if (!($user->type == User::UT_ENTERPRISE && $user->profile == $job->company_id)
            || $user->type != User::UT_ADMIN){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PRIVILEGE);
        }
        $job->delete();
        ErrorHelper::Success();
    }

    public function loadModel($id)
    {
        $model=Job::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    private function setJob($model){
        if (!$model){
            return false;
        }

        $title = DataHelper::getStrReq('title');
        $industry = DataHelper::getIntReq('indtype');
        $functype = DataHelper::getIntReq('functype');
        $department = DataHelper::getStrReq('department');
        $m_ratio = DataHelper::getIntReq('m_ratio');
        $location = DataHelper::getIntReq('location');
        $degree = DataHelper::getIntReq('degree');
        $hire_count = DataHelper::getIntReq('hc');
        $age = DataHelper::getStrReq('age');
        $desc = DataHelper::getStrReq('desc');
        $resp = DataHelper::getStrReq('resp');
        $other = DataHelper::getStrReq('other');
        $keyword = DataHelper::getStrReq('keyword');
        $filter = DataHelper::getStrReq('filter');
        $publish_time = DataHelper::getIntReq('publish');

        $model->title = $title;
        $model->industry = $industry;
        $model->functype = $functype;
        $model->department = $department;
        $model->m_ratio = $m_ratio;
        $model->location = $location;
        $model->degree = $degree;
        $model->hc = $hire_count;
        $model->age= $age;
        $model->description = $desc;
        $model->responsibility = $resp;
        $model->other = $other;
        $model->keyword = $keyword;
        $model->filter = $filter;
        $model->publish_time = $publish_time;

        $isOk = $model->save();
        if (!$isOk){
            ErrorHelper::Fatal(ErrorHelper::ERR_SAVE_FAIL, 'save fail.'.json_encode($model->getErrors()));
        }

        return $model;
    }
}