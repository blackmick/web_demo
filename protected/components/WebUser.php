<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/27
 * Time: 上午10:54
 */

class WebUser extends CWebUser{
    public $loginUrl=array('account/login');

    public function getType(){
        $type = $this->getState("type");
        return $type;
    }
    public function setType($type){
        $this->setState("type", $type);
    }

    protected function changeIdentity($id, $name, $states){
        Yii::app()->getSession()->regenerateID(true);
        $this->setId($id);
        $this->setName($name);
        $this->setType(isset($states['type'])?$states['type']:null);
    }

    public function login($identity, $duration = 0){
        $id = $identity->getId();
        $state = $identity->getPersistentStates();
        if($this->beforeLogin($id, $state, false)){
            $this->changeIdentity($id, $identity->getName(), $state, $identity);
            if ($duration > 0){
                if ($this->allowAutoLogin){
                    $this->saveToCookie($duration);
                }else{
                    throw new CException(Yii::t('yii', '{class}.allowAutoLogin must be set true in order to use cookie-based authentication.', array('{class}'=> get_class($this))));
                }
            }
            $this->afterLogin(false);
        }

        return !$this->getIsGuest();
    }

    public function getIsGuestWithType($type){
        return ($this->getIsGuest() || ($this->getType() != $type));
    }
}