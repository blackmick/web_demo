<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-17
 * Time: 下午4:02
 */

/**
 * This is the model class for table "{{job}}".
 *
 * The followings are the available columns in table '{{job}}':
 * @property integer $id
 * @property string  $title
 * @property integer $cid
 * @property integer $industry
 * @property integer $functype
 * @property integer $profession
 * @property string  $department
 * @property integer $m_ratio
 * @property integer $location
 * @property integer $degree
 * @property integer $hc
 * @property integer $age_min
 * @property integer $age_max
 * @property string  $requirement
 * @property string  $responsibility
 * @property string  $other
 * @property string  $tags
 * @property string  $filter
 * @property integer $publish_time
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 */

class Job extends CActiveRecord{
    /**
     * @return string the associated database table name
     */
    private static $_mRatioMap= array(
        '0' => '15%以下',
        '1' => '30%左右',
        '2' => '50%以上'
    );
    public function tableName()
    {
        return '{{job}}';
    }

    public function rules(){
        return array(
            array('title', 'required'),
            array('cid', 'numerical', 'integerOnly'=>true),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Job the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function search(){
        if (empty($this->cid))
        {
            $condition = null;
        }else{
            $condition = "cid = {$this->cid}";
        }

        $dataProvider = new CActiveDataProvider(
            'Job',
            array(
                'criteria' => array(
                    'condition' => $condition,
                    'order' => 'id DESC',
                ),
                'pagination' => array(
                    'pageSize' => 10,
                )
            )
        );
        return $dataProvider;
    }

    public function beforeSave(){
        if (parent::beforeSave()){
            if ($this->isNewRecord){
                $this->create_time = $this->update_time = time();
            }else{
                $this->update_time = time();
            }
            return true;
        }

        return false;
    }

    public function getData($id = null){
        if ($id){
            $this->findByPk($id);
        }

        $oData['id'] = $this->id;
        $oData['title'] = $this->title;
        $oData['company'] = Company::model()->findByPk($this->cid)->name;
        $oData['industry'] = Industry::getName($this->industry);
        $oData['functype'] = $this->functype;
        $oData['ocid'] = $this->ocid;
        $oData['department'] = $this->department;
        $oData['m_ratio'] = $this->m_ratio;
        $oData['location'] = Location::getName($this->location);
        $oData['degree'] = $this->degree;
        $oData['hc'] = $this->hc;
        $oData['age_min'] = $this->age_min;
        $oData['age_max'] = $this->age_max;
        $oData['requirement'] = $this->requirement;
        $oData['responsibility'] = $this->responsibility;
        $oData['other'] = $this->other;
        $oData['tags'] = $this->tags;
        $oData['filter'] = $this->filter;
        $oData['publish_time'] = $this->publish_time;
        $oData['expire_time'] = $this->expire_time;

        return $oData;
    }

    public function getMangementRatio($ratio = null){
        if ($ratio){
            return self::$_mRatioMap[$ratio];
        }else {
            return self::$_mRatioMap[$this->m_ratio];
        }
    }

    public static function getMRatioList(){
        return self::$_mRatioMap;
    }
}