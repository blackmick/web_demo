<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-17
 * Time: 下午3:15
 */

/* @var $this SiteController */
/* @var $model RegisterForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 注册';
$this->breadcrumbs=array(
    '注册',
);
?>

<h1>用户注册</h1>

<p>请填写以下注册信息:</p>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'UserCreateForm',
        'enableClientValidation'=>true,
        'enableAjaxValidation'=>true,
//        'clientOptions'=>array(
//            'validateOnSubmit'=>true,
//        ),
    )); ?>

    <p class="note">标记<span class="required">*</span> 的部分是必填项</p>

    <div class="row">
        <?php echo $form->labelEx($model,'用户名'); ?>
        <?php echo $form->textField($model,'username'); ?>
        <?php echo $form->error($model,'username',array(), true, true); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'密码'); ?>
        <?php echo $form->passwordField($model,'password',array('onpaste'=>'return false')); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'确认密码'); ?>
        <?php echo $form->passwordField($model,'password_repeat',array('onpaste'=>'return false')); ?>
        <?php echo $form->error($model,'password_repeat'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('注册'); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->