<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/22
 * Time: 下午4:37
 */

$this->pageTitle = Yii::app()->name."-职位详情";$cName;
$this->breadcrumbs = array(
    '职位管理' => Yii::app()->createUrl('job/list'),
    '职位详情');
?>

<h>职位详情</h>
<div>
    <?php
        $cName = Company::model()->findByPk($model->cid)->name;
        $this->widget('zii.widgets.CDetailView',
            array(
                'data'=>$model,
                'attributes' => array(
                    array(
                        'label' => '职位名称',
                        'name' => 'title',
                    ),
                    array(
                        'label' => '公司名',
                        'value' => $cName,
                    ),
                    array(
                        'label' => '职业类别',
                        'value' => 'N/A',
                    ),
                    array(
                        'label' => '部门',
                        'name' => 'department',
                    ),
                    array(
                        'label' => '管理比重',
                        'value' => $model->getMangementRatio(),
                    ),
                    array(
                        'label' => '岗位职责',
                        'name' => 'description',
                    ),
                    array(
                        'label' => '职位要求',
                        'name' => 'requirement',
                    )
                )
            )
        );
    ?>
</div>