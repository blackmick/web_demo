<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 8/21/14
 * Time: 6:59 AM
 */

class HashActiveRecord extends CActiveRecord
{
    private $_hashSeed = 16;

    private $_hashKey;

    public function setHashKey($key){
        $this->_hashKey = $key;
    }

    public function tableName(){
        //return parent::tableName().$this->$this->_hashKey % $this->_hashSeed;
    }
}