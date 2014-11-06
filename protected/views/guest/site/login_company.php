<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/11/3
 * Time: 下午6:52
 */
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#loginSwitch").click(function() {
//                $("#company_register_form").show("slow");
                $("#company_register_form").animate({
                    left:"+200px"},
                    "slow",
                    "swing"
                );
                $("#company_login_form").hide();

            }
        );
        $("#registerSwitch").click(function(){
            $("#company_login_form").show("slow");
            $("#company_register_form").hide();

        });
    });

</script>
<div class="form" id="company_login_form" style="float:left;left:0px;">
    <?php
        $form = $this->beginWidget('CActiveForm',
            array(
                'id' => 'CompanyLoginForm',
            )
        );
    ?>
    <div class="row">
        <?php echo $form->labelEx($model, '公司会员名');?>
        <?php echo $form->textField($model, 'companyName');?>
        <?php echo $form->error($model, 'companyName');?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'账号名'); ?>
        <?php echo $form->textField($model,'username',array('AUTOCOMPLETE'=>'off')); ?>
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

    <div>
        <?php echo CHtml::link("注册新用户", 'javascript:;', array('id'=>'loginSwitch'));?>
    </div>
<?php $this->endWidget();?>
</div>
