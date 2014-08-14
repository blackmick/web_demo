<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-8-5
 * Time: 10:54
 */

//$this->breadcrumbs=array(
//    'Enterprises'=>array('update'),
//    $model->name=>array('view','id'=>$model->id),
//    'Update',
//);

//$this->menu=array(
//    array('label'=>'List Enterprise', 'url'=>array('index')),
//    array('label'=>'Create Enterprise', 'url'=>array('create')),
//    array('label'=>'View Enterprise', 'url'=>array('view', 'id'=>$model->id)),
//    array('label'=>'Manage Enterprise', 'url'=>array('admin')),
//);
?>

    <h1>用户信息</h1>
<?php $this->renderPartial('_form', array('model'=>$userModel)); ?>
<?php $this->renderPartial('_baseInfoForm', array('model'=>$baseInfoModel)); ?>
