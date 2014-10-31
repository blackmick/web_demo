<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-15
 * Time: 上午11:08
 */

class Profession extends CActiveRecord{
    public function tableName(){
        return '{{profession}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Profession the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function getList(){
        $list = self::model()->findAll();
        $data = array();
        foreach($list as $p){
            $data[$p->id] = $p->name;
        }
        return $data;
    }
}