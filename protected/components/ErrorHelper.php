<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-1
 * Time: 11:30
 */

class ErrorHelper
{
    const ERR_OK = 0;
    const ERR_INVALID_PARAM         = 1000001;
    const ERR_SAVE_FAIL             = 1000002;
    const ERR_INTERNAL_ERROR        = 1000003;

    const ERR_INVALID_USER          = 2000001;
    const ERR_INVALID_PASSWORD      = 2000002;
    const ERR_INVALID_TOKEN         = 2000003;
    const ERR_INVALID_PRIVILEGE     = 2000004;
    const ERR_DUP_USER              = 2000005;
    const ERR_DUP_USER_BASE_INFO    = 2000006;
    const ERR_UBI_NOT_FOUND         = 2000007;
    const ERR_LOGIN_FAIL            = 2000008;

    const ERR_INVALID_PROFILE        = 3000001;



    private static  $ErrorCodeMap = array(
        self::ERR_OK => 'Success',
        self::ERR_INTERNAL_ERROR => 'Internal error',
        self::ERR_INVALID_PARAM => 'Invalid parameter',
        self::ERR_INVALID_USER => 'Invalid user',
        self::ERR_INVALID_PASSWORD => 'Invalid password',
        self::ERR_INVALID_PRIVILEGE => 'Invalid privilege',
        self::ERR_INVALID_TOKEN => 'Invalid token',
        self::ERR_SAVE_FAIL => 'Save fail',
        self::ERR_INVALID_PROFILE => 'Invalid profile',
        self::ERR_LOGIN_FAIL => 'login fail',

        self::ERR_DUP_USER => 'username is duplicated',
        self::ERR_DUP_USER_BASE_INFO => 'user base info is duplicated',
        self::ERR_UBI_NOT_FOUND => 'user base info not found',
    );

    public static function Error($errCode, $errParams = null)
    {
        $errMsgExtends = '';
        if ($errParams != null && is_array($errParams))
        {
            foreach($errParams as $key => $value)
            {
                $errMsgExtends = "${errMsgExtends} [${key}:${value}]";
            }
        }
        else if($errParams != null && is_string($errParams)){
            $errMsgExtends = $errParams;
        }

        if (strlen($errMsgExtends) > 0){
            $errMsg = self::$ErrorCodeMap[$errCode] . ':' .$errMsgExtends;
        }else{
            $errMsg = self::$ErrorCodeMap[$errCode];
        }
        echo json_encode(array(
            'status' => $errCode,
            'error message' => $errMsg
        ));
        Yii::log("ErrorCode:".$errCode."Error Message:".$errMsg, CLogger::LEVEL_WARNING);
//        exit();
    }

    public static function Fatal($errCode, $errParams = null){
        self::Error($errCode, $errParams);
        exit();
    }

    public static function Success(){
        self::Error(self::ERR_OK);
    }
}