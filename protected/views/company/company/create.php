<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/22
 * Time: 下午3:42
 */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/ajaxfileupload.js");
$this->pageTitle=Yii::app()->name . ' -注册';
$this->breadcrumbs=array(
    '注册',
);
?>
<h1 style="color: #0e509e">企业会员申请</h1>
<p>请填写以下信息,我们的客服人员会尽快与您联系</p>
<?php
$form = $this->beginWidget("CActiveForm",
    array(
        'id' => 'CompanyCreateForm',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
    )
);
?>
    <div class = "form">

        <div class = "row">
            <?php echo $form->labelEx($model, "公司名称");?>
            <?php echo $form->textField($model, "name",
                array(
                    'value' => CompanyCreateForm::$tipName,
                    'style' => "color:#999;",
                    'onclick' => "if(value==defaultValue){value='';this.style.color='#000';}",
                )
            );?>
            <?php echo $form->error($model, "name", array(), true, false);?>
        </div>

        <div class = "row">
            <?php echo $form->labelEx($model, "公司所属城市");?>
            <?php echo $form->dropDownList($model, "province", Location::getProvice(),
                array(
                    'id' => 'province',
                    'empty' => '--选择省份--',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => Yii::app()->createUrl('location/citylist'),
                        'update' => '#city',
                        'data' => array('id' => 'js:this.value'),
                    )
                ));?>
            <?php echo $form->dropDownList($model, "city", array(),
                array(
                    'id' => 'city',
                    'empty' => '--选择城市--',
                ));?>
            <?php echo $form->error($model, 'city', array(), false, true);?>
        </div>

        <div class = "row">
            <?php echo $form->labelEx($model, "详细地址");?>
            <?php echo $form->textField($model, "address",
                array(
                    'value' => CompanyCreateForm::$tipAddress,
                    'style' => "color:#999;",
                    'onclick' => "if(value==defaultValue){value='';this.style.color='#000';}",
                ));
            ?>
            <?php echo $form->error($model, "address", array(), false, true);?>
        </div>
        <div class = 'row'>
            <?php echo $form->labelEx($model, "联系人");?>
            <?php echo $form->textField($model, "contact",
                array(
                    'value' => CompanyCreateForm::$tipContact,
                    'style' => "color:#999;",
                    'onclick' => "if(value==defaultValue){value='';this.style.color='#000';}",
                ));
            ?>
            <?php echo $form->error($model, "contact");?>
        </div>
        <div class = 'row'>
            <?php echo $form->labelEx($model, "联系电话");?>
            <?php echo $form->textField($model, "phone",
                array(
                    'value' => CompanyCreateForm::$tipPhone,
                    'style' => "color:#999;",
                    'onclick' => "if(value==defaultValue){value='';this.style.color='#000';}",
                ));
            ?>
            <?php echo $form->error($model, "phone", array(), false, true);?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, "手机号码");?>
            <?php echo $form->textField($model, "mobile",
                array(
                    'value' => CompanyCreateForm::$tipMobile,
                    'style' => "color:#999;",
                    'onclick' => "if(value==defaultValue){value='';this.style.color='#000';}",
                ));
            ?>
            <?php echo $form->error($model, "mobile", array(), false, true);?>
        </div>
<!--        <div class = "row">-->
<!--            --><?php //echo $form->labelEx($model, "公司性质");?>
<!--            --><?php //echo $form->dropDownList($model, "type",Company::getTypeList());?>
<!--        </div>-->
<!--        <div class = "row">-->
<!--            --><?php //echo $form->labelEx($model, "所属行业");?>
<!--            --><?php //echo $form->dropDownList($model, "industry", Industry::getList(), array('id'=>'industry', 'empty'=>'--请选择--'));?>
<!--        </div>-->
<!--        <div class = "row">-->
<!--            --><?php //echo $form->labelEx($model, "描述");?>
<!--            --><?php //echo $form->textArea($model, "description", array('class'=>'text-area')); ?>
<!--        </div>-->
<!--        <div class = "row">-->
<!--            --><?php //echo $form->labelEx($model, "接受简历的电子邮件");?>
<!--            --><?php //echo $form->listBox($model, "emailList",array(),array('class'=>'list-box', 'id'=>'email-list'));?>
<!--            --><?php //echo CHtml::button("删除选定的",array());?>
<!--        </div>-->
<!--        <div class = "row">-->
<!--            --><?php //echo CHtml::textField("email");?>
<!--            --><?php //echo CHtml::button("添加",array());?>
<!--        </div>-->
<!--        <div class = "row">-->
<!--            --><?php //echo $form->checkBox($model, "flag");?>
<!--            是否向普通用户公开扩展信息-->
<!--        </div>-->
<!--        <div class = "row">-->
<!---->
<!--            --><?php //echo $form->hiddenField($model, "certification", array('id'=>'cert_sign','value'=>''));?>
<!--        </div>-->
        <div class = 'row'>
            <?php echo $form->checkBox($model, "agreement");?>
            <?php echo CHtml::encode('我已阅读并同意');?>
            <?php echo CHtml::link("服务声明",Yii::app()->createUrl('site/declaration'));?>
        </div>



        <div class = "row">
            <?php echo CHtml::submitButton("确定");?>
            <!--        --><?php //echo CHtml::button("取消");?>
        </div>
    </div>

<?php
$this->endWidget();
?>



