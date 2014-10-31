<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/25
 * Time: 下午7:46
 */

$this->pageTitle=Yii::app()->name . ' - 公司列表';
$this->breadcrumbs = array('公司列表');
?>

<?php
$this->widget('zii.widgets.grid.CGridView',
    array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            'name',
            array(
                'header' => '操作',
                'class' => 'CButtonColumn',
                'template' => '{view}{delete}'
            )
        )
    )
);
?>