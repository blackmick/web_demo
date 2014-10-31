<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/21
 * Time: 下午3:05
 */
/* @var $this CompanyController */
/* @var $model AttachForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 关联';
$this->breadcrumbs=array(
    '关联',
);
?>

<h1>关联企业</h1>

<p>请选择需要关联的公司</p>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'attach-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <p class="note">标记<span class="required">*</span> 的部分是必填项</p>

    <div class="row">
        <?php echo $form->labelEx($model,'公司全称'); ?>
        <?php echo $form->textField($model,'name', array('id'=>'text_kw')); ?>
        <?php echo $form->error($model,'name'); ?>
        <?php echo CHtml::button("搜索", array(
            'id' => 'searchBtn',
            'onclick' => 'location.href="index.php?r=company/attach&kw="+ $("#text_kw").val()',
            )
        );
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->

<div class="search-form" id = "result-div">
    <?php
        $kw = Yii::app()->request->getParam('kw');
        if (empty($kw)){
            $condition = '';
        }else{
            $condition = "name like '%{$kw}%'";
        }
        $this->widget('zii.widgets.grid.CGridView',
            array(
                'dataProvider' => new CActiveDataProvider(
                        'Company',
                        array(
                            'criteria' => array(
                                'condition' => $condition,
                            ),
                            'pagination' => array(
                                'pageSize' => 10
                            )
                        )
                    ),
                'columns' => array(
                    array(
                        'header' => '名称',
                        'value' => '$data->name',
                    ),
                    array(
                        'header' => '操作',
                        'class' => 'CButtonColumn',
                        'template' => '{view}{attach}',
                        'buttons' => array(
                            'attach' => array(
                                'label' => '关联',
                                'url' => 'Yii::app()->createUrl("company/attach", array("id"=>$data->id))'
                            )
                        )
                    )
                )
            ));
    ?>
</div>
<div class = 'row'>
    <input type="button" onclick="location.href='index.php?r=company/create';" value="新建"/>
</div>