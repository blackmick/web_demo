<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/26
 * Time: 下午12:26
 */
$this->pageTitle=Yii::app()->name . ' - 搜索人选';
$this->breadcrumbs=array(
    '搜索人选',
);
?>
<?php
$form = $this->beginWidget("CActiveForm",
    array(
        'id' => 'SearchCandidateForm',
    )
);
?>
<div class="search-form">
    <div class="row">
        <?php echo $form->labelEx($model, "城市");?>
        <?php echo $form->dropDownList($model, "province", Location::getProvice(),
            array(
                'id' => 'province',
                'empty' => '--选择省份--',
                'select' => $model->province,
                'ajax' => array(
                    'type' => 'POST',
                    'url' => Yii::app()->createUrl('location/citylist'),
                    'update' => '#city',
                    'data' => array('id' => 'js:this.value'),
                )
            ));?>
        <?php echo $form->dropDownList($model, "city", Location::getCityList($model->province),
            array(
                'id' => 'city',
                'empty' => '--选择城市--',
                'select' => $model->city,
            ));?>
    </div>
    <div class = "row">
        <?php echo $form->labelEx($model,"年龄范围");?>
        <?php echo $form->textField($model, 'age_min');?> - <?php echo $form->textField($model, 'age_max');?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, "学历");?>
        <?php echo $form->dropDownList($model, "degree",
            DataHelper::getDegreeList()
        );?>
    </div>

    <div class = "row">
        <?php echo $form->labelEx($model, "关键字");?>
        <?php echo $form->textField($model, "keyword");?>
        <?php echo CHtml::submitButton("搜索");?>
    </div>
</div>
<?php
$this->endWidget();
?>