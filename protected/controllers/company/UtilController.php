<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/24
 * Time: 下午1:50
 */

class UtilController extends Controller{
    public function actionUpload(){
        $uploadfile = CUploadedFile::getInstanceByName('cert_file');
        if ($uploadfile){

            $filecont = file_get_contents($uploadfile->tempName);
            $contSign = UploadService::getInstance()->uploadContent($filecont);

            $url = Utils::getImgUrl($contSign);

            echo json_encode(array('file_infor'=>'上传成功', 'url'=>$url, 'contsign'=>$contSign));
        }else{
            echo json_encode(array('file_infor'=>'上传失败'));
        }
    }
}