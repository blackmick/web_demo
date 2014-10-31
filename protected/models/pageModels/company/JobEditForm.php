<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-17
 * Time: 下午2:59
 */

class JobEditForm extends CFormModel{
    public $title;
    public $filter;
    public $functype;
    public $profession;
    public $department;
    public $m_ratio;
    public $province;
    public $city;
    public $degree;
    public $hc;
    public $age_min;
    public $age_max;
    public $salary;
    public $responsibility;
    public $requirement;
    public $other;
    public $tags;

    public function rules(){
        return array(
            array('title', 'required'),
            array('title, filter, profession, department, m_ratio, province, city,degree, hc, age_min, age_max, salary, responsibility, requirement, other,tags', 'safe'),
        );
    }
    public function create(){
        $ca = CompanyAccount::model()->findByPk(Yii::app()->user->getId());
        if (!$ca){
            Yii::log("not logged in", CLogger::LEVEL_WARNING);
            return false;
        }
        $company = Company::model()->findByPk($ca->cid);
        if (!$company){
            Yii::log("company not found, account[{$ca->id}], cid[{$ca->cid}]", CLogger::LEVEL_WARNING);
            return false;
        }

        $job = new Job();

        //assign all properties of job model
        $job->title  = $this->title;
        $job->industry = $company->industry;
        $job->cid = $company->id;

        $job->profession = $this->profession;
        $job->department = $this->department;
        $job->m_ratio = $this->m_ratio;
        $job->location = $this->city;
        $job->degree = $this->degree;
        $job->hc = $this->hc;

        $job->age_min = $this->age_min;
        $job->age_max = $this->age_max;
        $job->requirement = $this->requirement;
        $job->responsibility = $this->responsibility;
        $job->other = $this->other;
        $job->tags = implode(',',$this->tags);
        $job->filter = implode(',',$this->filter);

//        return $this->attributes;
        return $job->save() ? $job : false;
    }

    public function loadModel($id){
        $job = Job::model()->findByPk($id);
        if (!$job){
            return false;
        }

        $this->attributes = $job->attributes;
        $this->province = Location::getProviceCode($job->location);

        return $this;
    }
}