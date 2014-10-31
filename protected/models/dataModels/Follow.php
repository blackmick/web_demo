<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-15
 * Time: 上午10:30
 */

class Follow extends CActiveRecord{
    const MAX_VIEW_LIST_LENGTH = 100;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('create_time, update_time, status', 'numerical', 'integerOnly'=>true),
            array('viewed', 'length', 'max'=>2048),
            array('unviewed', 'length', 'max'=>2048),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('uid, create_time, update_time, status', 'safe', 'on'=>'search'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FollowJob the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
};

//TODO:
/**
 * This is the model class for table "{{follow_oc}}".
 *
 * The followings are the available columns in table '{{follow_oc}}':
 * @property integer $uid
 * @property integer $ocid
 * @property integer $last_view_time
 * @property string  $viewed
 * @property string  $unviewed
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 */
class ProfessionFollow extends Follow{
    public function tableName()
    {
        return '{{follow_profession}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FollowCompany the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getUnviewed($start=0, $page_count=0){
        return $this->getJobList($start, $page_count, $this->unviewed);
    }

    public function getViewed($start=0, $page_count=0){
        return $this->getJobList($start, $page_count, $this->viewed);

    }

    private function getJobList($start, $page_count, $list){
        $arrList = explode(',', $list);
        $total = count($arrList);
        if ($start + $page_count > $total)
            $end = $total;
        else
            $end = $start + $page_count;

        $arrJobs = array();
        for($i = $start; $i < $end; $i++){
            $arrJobs[] = $arrList[$i];
        }
        $jobs = Job::model()->findAllByPk($arrJobs);
        foreach($jobs as $job){
            $oData[]=$job->getData();
        }

        return $oData;
    }

    public function viewJob($jid){
        $arrViewed = explode(',', $this->viewed);
        $arrUnviewed = explode(',', $this->unviewed);

        if ($arrUnviewed && in_array($jid, $arrUnviewed)){
            $newUnviewed = array_diff($arrUnviewed, array($jid));
            $this->unviewed = implode(',', $newUnviewed);
        }

        if ($arrViewed){
            if (!in_array($jid, $arrViewed)){
                array_unshift($arrViewed, $jid);
                if (count($arrViewed) > self::MAX_VIEW_LIST_LENGTH){
                    array_pop($arrViewed);
                }
                $this->viewed = implode(',', $arrViewed);
            }
        }

        $this->last_view_time = time();
        $this->save();

        return true;
    }

    /**
     * 获得未读职位数量
     */
    public function getUnviewedCount(){
        $arrUnviewed = explode(',', $this->unviewed);
        return $arrUnviewed ? count($arrUnviewed) : 0;
    }
};

/**
 * Class CompanyFollow
 *
 * This is the model class for table "{{follow_company}}".
 *
 * The followings are the available columns in table '{{follow_company}}':
 * @property integer $uid
 * @property integer $cid
 * @property integer $last_view_time
 * @property integer $state
 * @property string  $viewed
 * @property string  $unviewed
 * @property integer $remain
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 *
 */
class CompanyFollow extends Follow{
    public function tableName()
    {
        return '{{follow_company}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FollowCompany the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getData(){
        $attr = $this->getAttributes();
        $arrCompanyId = explode(',',$attr->list);
        $arrCompany = Company::model()->findAllByPk($arrCompanyId);
        $models = Job::model()->getByCompany($arrCompany);
        if (!$models)
            return false;

        $oData = array();
        foreach($models as $job){
            $oData[] = $job->getData();
        }

        return $oData;
    }

    public function getSummary(){
        $oData['uid'] = $this->uid;
        $oData['cid'] = $this->cid;
        $oData['remain'] = $this->remain;

        return $oData;
    }

    public function viewJob($jid){
        if (!$this->unviewed || $this->unviewed == ""){
            return true;
        }

        $arrUnviewed = explode(',', $this->unviewed);
        $arrViewed = explode(',', $this->viewed);

        //处理未看过的职位信息
        if (in_array($jid, $arrUnviewed)){
            $newUnviewed = array_diff($arrUnviewed, array($jid));
            $this->unviewed = implode(',', $newUnviewed);
        }

        //处理已看过的职位信息
        if (!empty($arrViewed)){
            if (!in_array($jid, $arrViewed)){
                array_unshift($arrViewed, $jid);
                if (count($arrViewed) > self::MAX_VIEW_LIST_LENGTH){
                    array_pop($arrViewed);
                }
                $this->viewed = implode(',', $arrViewed);
            }
        }else{
            $this->viewed = $jid;
        }

        $this->last_view_time = time();
        $this->save();

        return true;
    }
};


//TODO:
/**
 * This is the model class for table "{{follow_industry}}".
 *
 * The followings are the available columns in table '{{follow_industry}}':
 * @property integer $uid
 * @property integer $iid
 * @property integer $last_view_time
 * @property string  $viewed
 * @property string  $unviewed
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 */
class IndustryFollow extends Follow{
    public function tableName()
    {
        return '{{follow_industry}}';
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FollowCompany the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function getData(){
        $attr = $this->getAttributes();
        $arrIndustryId = explode(',',$attr->list);
        $arrIndustry = Industry::model()->findAllByPk($arrIndustryId);
        $model = Job::model()->getByIndustry($arrIndustry);
        if (!$model)
            return false;

        $oData = array();
        foreach($model as $job){
            $oData[] = $job->getData();
        }

        return $oData;
    }

    public function viewJob($jid){
        $arrViewed = explode(',', $this->viewed);
        $arrUnviewed = explode(',', $this->unviewed);

        if ($arrUnviewed && !in_array($jid, $arrUnviewed)){
            $newUnviewed = array_diff($arrUnviewed, array($jid));
            $this->unviewed = implode(',', $newUnviewed);
        }

        if ($arrViewed){
            if (!in_array($jid, $arrViewed)){
                array_unshift($arrViewed, $jid);
                if (count($arrViewed) > self::MAX_VIEW_LIST_LENGTH){
                    array_pop($arrViewed);
                }
                $this->viewed = $jid.','. $this->viewed;
            }
        }else{
            $this->viewed = $jid;
        }

        $this->last_view_time = time();
        $this->save();

        return true;
    }
};