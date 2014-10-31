<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14-10-17
 * Time: 下午4:01
 */
$this->pageTitle=Yii::app()->name . ' - 职位管理';
$this->breadcrumbs = array('职位管理');
?>
<!--<div class = "list">-->
<!--    --><?php //foreach($model as $job){ ?>
<!--        <div class="row">-->
<!--            职位名称</br>-->
<!--            --><?php //echo $job->title;?>
<!--        </div>-->
<!--    --><?php //} ?>
<!--</div>-->

<?php
$this->widget('zii.widgets.grid.CGridView',
    array(
        'dataProvider' => $model->search(),
        'columns' => array(
            'title',
            'department',
            'age_min',
            'age_max',
            array(
                'header' => '操作',
                'class' => 'CButtonColumn',
                'template' => '{view}{update}{delete}'
            )
        )
    )

);
?>