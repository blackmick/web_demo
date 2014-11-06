<?php
/**
 * Created by PhpStorm.
 * User: 韩啸
 * Date: 2014/11/5
 * Time: 15:07
 */
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#job_objective_cancel").click(function(){
            $("#job_objective_form").slideUp();
            $("#job_objective_summary").slideDown();
            $("#job_objective_modify").show();
        });
    });
</script>
<div style="border: 5px solid #F2F2F2;padding: 20px">
    <?php
        $form = $this->beginWidget('CActiveForm',
            array(
                'id'=>'JobObjectiveForm'
            ));
    ?>

    <div class="row">
        <?php echo $form->labelEx($model, '期望行业');?>
        <?php echo $form->textField($model, 'industry');?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, '期望职能');?>
        <?php echo $form->textField($model, 'function');?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, '期望地点');?>
        <?php echo $form->textField($model, 'location');?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, '期望年薪');?>
        <?php echo $form->textField($model, 'salary');?>
    </div>

    <div class="row">
        <?php echo CHtml::ajaxSubmitButton("保存",array('profile/ajaxobjective'));?>
        <?php echo Chtml::button("取消",array('id'=>'job_objective_cancel'));?>

    </div>
    <?php
    $this->endWidget();
    ?>
</div>
