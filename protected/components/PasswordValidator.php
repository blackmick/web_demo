<?php

/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/28
 * Time: 下午2:06
 */
class PasswordValidator extends CValidator
{
    public $min;
    public $max;
    public $strongness;

    const DEFAULT_STRONGNESS = 4;
    const DEFAULT_MIN_LENGTH = 6;
    const DEFAULT_MAX_LENGTH = 32;

    private function strong($value){
        $score = 0;
        if (preg_match('[a-z]', $value))
            $score++;
        if (preg_match('[A-Z]', $value))
            $score++;
        if (preg_match('[0-9]', $value))
            $score++;
        if (preg_match('[~!@#$%^&*]', $value))
            $score++;

        return $score;
    }

    protected function validateAttribute($object, $attribute)
    {
        $value = $object->$attribute;
        $strongness = $this->strongness ? $this->strongness : self::DEFAULT_STRONGNESS;
        $min_length = $this->min ? $this->min : self::DEFAULT_MIN_LENGTH;
        $max_length = $this->max ? $this->max : self::DEFAULT_MAX_LENGTH;

        if (is_array($value) ||
            strlen($value) < $min_length ||
            strlen($value) > $max_length ||
            !preg_match('/^[0-9a-zA-Z~!@#$%^&*]+$/', $value) ||
            $this->strong($value) < $strongness
        ) {
            $message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} is invalid.');
            $this->addError($object, $attribute, $message);
        }

    }

    public function clientValidateAttribute($object, $attribute)
    {
//        return "
//if(" . ($this->allowEmpty ? "jQuery.trim(value)!='' && " : '') . ($this->not ? '' : '!') . "value.match($pattern)) {
//	messages.push(" . CJSON::encode($message) . ");
//}
//";
        $strongness = $this->strongness ? $this->strongness : self::DEFAULT_STRONGNESS;
        $min_length = $this->min ? $this->min : self::DEFAULT_MIN_LENGTH;
        $max_length = $this->max ? $this->max : self::DEFAULT_MAX_LENGTH;
        $notPattern= "/^[0-9a-zA-Z~!@#$%^&*]+$/";
        $message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} is invalid.');
        return "
            var score=0;
            if (value.match(/[a-z]/))
                score++;
            if (value.match(/[A-Z]/))
                score++;
            if (value.match(/[0-9]/))
                score++;
            if (value.match(/[~!@#$%^&*]/))
                score++;

            if (value.length < ".$min_length."){
                messages.push('密码长度不够,最少".$min_length."位');
            }else if (value.length > ".$max_length."){
                messages.push('密码设置超长,最长".$max_length."位');
            }else if (!value.match(".$notPattern.")){
                messages.push('密码中包含非法字符,密码必须由大小写字母/数字/特殊符号(~!@#$%^&*)组成');
            }else if (score < ".$strongness."){
                messages.push('密码强度不够,当前强度'+score);
            }
        ";
        //            if((value.length < ".$min_length.") ||
//                (value.length > ".$max_length.") ||
//                (!value.match(".$notPattern.")) ||
//                (score < ".$strongness.")){
//                    messages.push('".$message."'+score);
//                }

    }
}

