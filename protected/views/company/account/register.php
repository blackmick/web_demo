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
        'id'=>'register-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <p class="note">标记<span class="required">*</span> 的部分是必填项</p>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username'); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password'); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('注册'); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->