<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/11/7
 * Time: 上午9:27
 */


/**
 * Class ProjectExperience
 *
 * @property integer id
 * @property integer pid
 * @property string  description
 * @property integer start_time
 * @property integer end_time
 * @property integer create_time
 * @property integer update_time
 */
class ProjectExperience extends CActiveRecord
{
    public function rules()
    {
        return array(
            array('description', 'required'),
            array('description', 'length', 'max'=>1024),
        );
    }

    public function beforeSave()
    {
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
}