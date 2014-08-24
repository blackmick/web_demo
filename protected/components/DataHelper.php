<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-1
 * Time: 13:35
 */

class DataHelper
{
    public  static function convertModelToArray($models, array $filterAttributes = null) {
        if (is_array($models))
            $arrayMode = TRUE;
        else {
            $models = array($models);
            $arrayMode = FALSE;
        }
        $result = array();
        foreach ($models as $model) {
            $attributes = $model->getAttributes();
            if (isset($filterAttributes) && is_array($filterAttributes)) {
                foreach ($filterAttributes as $key => $value) {
                    if (strtolower($key) == strtolower($model->tableName()) && strpos($value, '*') === FALSE) {
                        $value = str_replace(' ', '', $value);
                        $arrColumn = explode(",", $value);
                        foreach ($attributes as $key => $value)
                            if (!in_array($key, $arrColumn))
                                unset($attributes[$key]);
                    }
                }
            }
            $relations = array();
            foreach ($model->relations() as $key => $related) {
                if ($model->hasRelated($key)) {
                    if(($model->$key instanceof CModel) || is_array($model->$key)){
                        $relations[$key] = self::convertModelToArray($model->$key, $filterAttributes);
                    } else {
                        $relations[$key] = $model->$key;
                    }
                }
            }
            $all = array_merge($attributes, $relations);
            if ($arrayMode)
                array_push($result, $all);
            else
                $result = $all;
        }
        return $result;
    }

    public static function passwordStrongness($password)
    {
        $score = 0;
        if (preg_match('/[0-9]+/', $password))
        {
            $score++;
        }

        if (preg_match('/[0-9]{3,}/', $password))
        {
            $score++;
        }

        if (preg_match('/[a-z]+/', $password))
        {
            $score++;
        }

        if (preg_match('/[a-z]{3,}/', $password))
        {
            $score++;
        }

        if (preg_match('/[A-Z]+/', $password))
        {
            $score++;
        }

        if (preg_match('/[A-Z]{3,}/', $password))
        {
            $score++;
        }

        return $score;
    }

    public static function getIntReq($key){
        $value = Yii::app()->request->getParam($key);
        if (!$value && !is_integer($value)){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PARAM);
        }
        return $value;
    }

    public static function getStrReq($key){
        $value = Yii::app()->request->getParam($key);
        if (!$value && !is_string($value)){
            ErrorHelper::Fatal(ErrorHelper::ERR_INVALID_PARAM);
        }
        $purifier = new CHtmlPurifier();
        $val = $purifier->purify($value);
        return $val;
    }

}