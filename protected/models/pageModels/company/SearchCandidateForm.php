<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/22
 * Time: 下午4:32
 */

class SearchCandidateForm extends CFormModel{
    public $province;
    public $city;
    public $age_min;
    public $age_max;
    public $degree;
    public $keyword;
    public $onlyFollowed;
    public $searcherName;

    public function rules(){
        return array(
            array('province, city, age_min, age_max, degree, keyword, onliFollowed, searcherName','safe'),
        );
    }

    public function search(){

    }
}