<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-9-23
 * Time: 上午11:19
 */

class UploadService{
    static private $_instance;
    public static function getInstance(){
        if (!self::$_instance){
            self::$_instance = new UploadService();
        }

        return self::$_instance;
    }

    /**
     * @param $obj
     * @return contsign
     */
    public function uploadContent($obj){
        $contSign = md5($obj);

        $basePath = Yii::app()->params['ImagePath'];
        $sum = 0;
        for($i = 0; $i< strlen($contSign); $i++){
            $sum += intval($contSign[$i]);
        }

        $bucket = $sum % 64;
//        $filePath = $basePath.DIRECTORY_SEPARATOR.$bucket.DIRECTORY_SEPARATOR.$contSign.".jpg";
        $filePath = $basePath.DIRECTORY_SEPARATOR.$contSign.".jpg";


        file_put_contents($filePath, $obj);

        return $contSign;
    }
}