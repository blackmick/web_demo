<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/27
 * Time: 下午1:04
 */
$this->pageTitle=Yii::app()->name . ' -  登录';
$this->breadcrumbs=array(
    '登录',
);
?>

<h1>管理员登录</h1>

<p>请填写以下登录信息:</p>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'AdminLogin',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <p class="note">标记<span class="required">*</span>的是必填项</p>
    <div class="row">
        <?php echo $form->labelEx($model,'用户名'); ?>
        <?php echo $form->textField($model,'username'); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'密码'); ?>
        <?php echo $form->passwordField($model,'password'); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="row rememberMe">
        <?php echo $form->checkBox($model,'rememberMe'); ?>
        <?php echo $form->label($model,'rememberMe'); ?>
        <?php echo $form->error($model,'rememberMe'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('登录'); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->