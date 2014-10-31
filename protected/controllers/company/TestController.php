<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/20
 * Time: 上午11:32
 */

class TestController extends Controller{
    public function actionLocation(){
        Location::getProvice();
    }
}