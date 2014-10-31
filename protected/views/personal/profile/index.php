<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/29
 * Time: 下午4:12
 */

?>

<?php
$this->widget(
    'zii.widgets.grid.CGridView',
    array(
        'dataProvider' => $user->getProfileList(),
        'columns' => array(
            array(
                'header' => '简历名',
                'value' => '$data->name',
            ),
            array(
                'header' => '操作',
                'class' => 'CButtonColumn',
                'template' => '{view}{update}{delete}',
            )
        )
    )
);

echo CHtml::button(
    '添加',
    array(
        'onclick' => "location.href='".Yii::app()->createUrl('profile/create')."'",
    )
)
?>