<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-11
 * Time: 下午1:17
 */

class Utils{
    public static function getImgUrl($_sign){
        //TODO:

        if (!$_sign || $_sign == null || $_sign == '0' || $_sign == 0){
            return '';
        }

        $sum = 0;
        for($i=0;$i<strlen($_sign);$i++){
            $sum += intval($_sign[$i]);
        }
        $bucket = $sum % 64;
//        $url = "http://JackydeMacBook-Pro.local:8080/myjober/protected/runtime/images/".$bucket."/".$_sign.".jpg";
        $url = "http://127.0.0.1:8080/myjober/protected/runtime/images/".$_sign.".jpg";
        return $url;
    }

    public static function generateValidateImg($num, $width, $height){
        $code = "";
        for ($i = 0; $i < $num; $i++){
            $code .= rand(0,9);
        }

        Yii::app()->session->add("verify_code", $code);
        header("Content-type: image/PNG");
        $im = imagecreate($width, $height);
        $black = imagecolorallocate($im, 0, 0, 0);
        $gray = imagecolorallocate($im, 200, 200, 200);
//        $bgcolor = imagecolorallocate($im, 255, 255, 255);

        imagefill($im, 0, 0, $gray);

        imagerectangle($im, 0, 0, $width - 1, $height - 1, $black);

        $style = array($black,$black,$black,$black,$black,
            $gray,$gray,$gray,$gray,$gray);

        imagesetstyle($im, $style);
        $y1 = rand(0, $height);
        $y2 = rand(0, $height);
        $y3 = rand(0, $height);
        $y4 = rand(0, $height);

        imageline($im, 0, $y1, $width, $y2, IMG_COLOR_STYLED);
        imageline($im, 0, $y3, $width, $y4, IMG_COLOR_STYLED);

        for ($i=0;$i<80;$i++){
            imagesetpixel($im, rand(0, $width), rand(0,$height), $black);
        }

        $strx = rand(3,8);
        for($i = 0; $i < $num; $i++){
            $strpos = rand(1, 6);
            imagestring($im, 5, $strx, $strpos, substr($code, $i, 1), $black);
            $strx += rand(8,12);
        }

        imagepng($im);
        imagedestroy($im);
    }
}