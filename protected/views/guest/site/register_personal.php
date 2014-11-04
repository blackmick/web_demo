<?php
/**
 * Created by PhpStorm.
 * User: 韩啸
 * Date: 2014/11/4
 * Time: 15:31
 */
?>
<div class="form">
    <?php
        $form = $this->beginWidget('CActiveForm',
            array(
                'id' => 'PersonalLoginForm',
            )
        );
    ?>
<div class="row">
    <?php echo $form->labelEx($model,'账号名'); ?>
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

<div class="row">
    <?php echo CHtml::link("注册新用户", array('account/register'));?>
</div>

<div class="row">
    <?php echo CHtml::link("忘记密码?重置密码", array('account/resetpassword'));?>
</div>
<?php $this->endWidget();?>
</div>
