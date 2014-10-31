<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/23
 * Time: 下午3:43
 */
include('DataHelper.php');
$this->pageTitle=Yii::app()->name . ' - 发布职位';
$this->breadcrumbs = array('发布职位');

$form = $this->beginWidget("CActiveForm",
    array(
        'id' => 'JobCreateForm',
        //''
    )
);
?>

    <div class = "form">
        <div class = "row">
            <?php echo $form->labelEx($model, "职位名称");?>
            <?php echo $form->textField($model, "title");?>
        </div>
        <div class = "row">
            <?php echo $form->labelEx($model, "过滤器(候选人的优先筛选条件)");?>
            <?php
            echo $form->textField($model, "filter[]");
            echo CHtml::encode("\t");
            echo $form->textField($model, "filter[]");
            echo "</br>";
            echo $form->textField($model, "filter[]");
            echo CHtml::encode("\t");
            echo $form->textField($model, "filter[]");
            echo "</br>";
            echo $form->textField($model, "filter[]");
            echo CHtml::encode("\t");
            echo $form->textField($model, "filter[]");
            ?>
        </div>
        <div class = 'row'>
            <?php echo $form->labelEx($model, "标签(该职位被检索到的关键字)");?>
            <?php
            echo $form->textField($model, "tags[]");
            echo CHtml::encode("\t");
            echo $form->textField($model, "tags[]");
            echo "</br>";
            echo $form->textField($model, "tags[]");
            echo CHtml::encode("\t");
            echo $form->textField($model, "tags[]");
            echo "</br>";
            echo $form->textField($model, "tags[]");
            echo CHtml::encode("\t");
            echo $form->textField($model, "tags[]");
            ?>
        </div>

        <div class = "row">
            <?php echo $form->labelEx($model, "职能类别");?>
            大类
            <?php echo $form->dropDownList($model, "functype[]", Functype::getCategory(),
                array(
                    'empty' => '--请选择--',
                    'id' => 'func_category',
                    'ajax'=>array(
                        'type' => 'POST',
                        'url'=>'index.php?r=func/type',
                        'update' => '#functype',
                        'data' => array('id' => 'js:this.value'),
                    )
                )
            );?>
            细分
            <?php echo $form->dropDownList($model, "functype[]", array(),
                array(
                    'empty' => '--请选择--',
                    'id' => 'functype',
                )
            );?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, "职业类别");?>
            <!--        --><?php //echo $form->textField($model, "profession");?>
            <?php echo $form->dropDownList($model, "profession", Profession::getList(),
                array(
                    'empty' => '--请选择--',
                )
            );?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, "部门");?>
            <?php echo $form->textField($model, "department");?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, "管理比重");?>
            <?php echo $form->radioButtonList($model, "m_ratio", Job::getMRatioList(),
                array(
                    'class' => 'radio-list',
                    //'template'=>'<span style="display:inline-block;width:auto;">{input}--{label}</span>',
                    'template'=>'{input} {label}',
                    'separator'=>'&nbsp&nbsp&nbsp&nbsp',
                    'labelOptions'=>array(
//                    'class' => 'labelForRadio',
                        'style' => 'display:inline-block;',
                    ),
                ));
            ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, "工作地点");?>

            <?php echo $form->dropDownList($model, "province", Location::getProvice(),
                array(
                    'empty' => '--请选择--',
                    'id' => 'provnice',
                    'ajax' => array(
                        'type'=>'POST',
                        'url' => 'index.php?r=location/citylist',
                        'update' => '#city',
                        'data'=> array('id'=>'js:this.value'),
                    )
                )
            );?>省
            <?php echo $form->dropDownList($model, "city", array(),
                array(
                    'empty' => '--请选择--',
                    'id' => 'city',
                ));?>市
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, "学历");?>
            <?php echo $form->dropDownList($model, "degree", array('专科', '本科', '硕士', '博士'));?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, "招聘人数");?>
            <?php echo $form->textField($model, "hc");?>
        </div>
        <div class="row">
            <?php echo $form->LabelEx($model, "年龄");?>
            <?php echo $form->textField($model, "age_min");?>
            <?php echo "-";?>
            <?php echo $form->textField($model, "age_max");?>
        </div>
        <div class="row">
            <?php echo $form->LabelEx($model, "薪资范围");?>
            <?php echo $form->dropDownList($model, "salary", JobData::getSalaryCategory());?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, "工作职责");?>
            <?php echo $form->textArea($model, "responsibility", array('class'=>'text-area'));?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, "任职要求");?>
            <?php echo $form->textArea($model, "requirement", array('class'=>'text-area'));?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, "其他补充");?>
            <?php echo $form->textArea($model, "other", array('class'=>'text-area'));?>
        </div>
        <div class = "row">
            <?php echo CHtml::submitButton("发布");?>
        </div>
    </div>

<?php
$this->endWidget();
?>