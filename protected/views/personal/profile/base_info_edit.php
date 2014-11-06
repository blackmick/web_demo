<?php
/**
 * Created by PhpStorm.
 * User: 韩啸
 * Date: 2014/11/6
 * Time: 13:27
 */
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#base_info_cancel").click(function(){
            $("#base_info_show").slideDown();
            $("#base_info_edit").slideUp();
            $("#base_info_modify").show();
        })
    })
</script>
<div style="border: 5px solid #F2F2F2;padding: 20px">
    <?php
    $form = $this->beginWidget('CActiveForm', array('id'=>'BaseInfoEditForm'));
    ?>

    <div class="row">
        <?php echo $form->labelEx($model, '出生年月');?>
        <?php echo $form->textField($model, 'birth');?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, '婚姻状况');?>
        <?php echo $form->textField($model, 'marriage');?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, '手机');?>
        <?php echo $form->textField($model, 'mobile');?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, '邮箱');?>
        <?php echo $form->textField($model, 'email');?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, '国籍');?>
        <?php echo $form->textField($model, 'nationality');?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, '状态');?>
        <?php echo $form->textField($model, 'state');?>
    </div>

    <div class="row">
        <?php echo CHtml::ajaxSubmitButton("保存",array('profile/ajaxupdate'));?>
        <?php echo Chtml::button("取消",array('id'=>'base_info_cancel'));?>

    </div>
    <?php
    $this->endWidget();
    ?>
</div>