<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/30
 * Time: 上午11:02
 */

$this->pageTitle = Yii::app()->name;
?>

<div class="form">
    <?php
        $form = $this->beginWidget(
            'CActiveForm',
            array(
                'id' => 'ResetPasswordForm',
            )
        );
    ?>

    <div class="row">
        <?php
        echo $form->labelEx($model, "账号绑定的邮箱地址");
        echo $form->textField($model, "email");
        echo $form->error($model, "email", array(), true, false);
        ?>
    </div>
    <?php if (extension_loaded('gd')){ ?>
    <div class="row">
        <?php $this->widget('CCaptcha');?>
        <?php echo $form->textField($model, "verifyCode");?>
    </div>
    <?php }?>
    <?php
        $this->endWidget();
    ?>
</div>

