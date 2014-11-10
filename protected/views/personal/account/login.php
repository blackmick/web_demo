<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' -  登录';
$this->breadcrumbs=array(
	'登录',
);
?>
<div id="login sheet" style="float: right;margin-right:50px;margin-top:100px;margin-bottom:100px;background-color: white;width: 380px;height:400px;overflow: hidden;">
    <div id="login-box" style="padding: 10px;">
        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'login-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
            )); ?>
            <div class="row">
<!--                --><?php //echo $form->labelEx($model,'账号名'); ?>
                <?php echo $form->textField($model,'username',array(
                    'value'=>'邮箱',
                    'style'=>'color:#999',
                    'onclick'=>"if(value==defaultValue){value='';this.style.color='#000';}",
                    'onkeyup'=>"if(value==''){this.type='text';value=defaultValue;this.style.color='#999';}",
                    'onkeydown'=>"if(value==defaultValue){value='';this.style.color='#000';}"
                )); ?>
                <?php echo $form->error($model,'username'); ?>
            </div>

            <div class="row">
<!--                --><?php //echo $form->labelEx($model,'密码'); ?>
                <?php echo $form->textField($model,'password',array(
                    'value'=>'password',
                    'style'=>'color:#999',
                    'onclick'=>"if(value==defaultValue){value='';this.style.color='#000';};this.type='password';",
                    'onkeyup'=>"if(value==''){this.type='text';value=defaultValue;this.style.color='#999';}",
                    'onkeydown'=>"if(value==defaultValue){value='';this.style.color='#000';}"
                )); ?>
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

            <div class="row">
                <?php echo CHtml::link("注册新用户", array('account/register'));?>
            </div>

            <div class="row">
<!--                --><?php //echo CHtml::link("忘记密码?重置密码", array('account/resetpassword'));?>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
    <div id="register-box" style="padding: 5px">

    </div>
</div>

