<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/26
 * Time: 下午12:18
 */

?>

<?php $this->widget('zii.widgets.grid.CGridView',
    array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            'name',
            array(
                'header' => '操作',
                'class' => 'CButtonColumn',
                'template' => '{view}{update}{delete}'
            )
        )
    )
);
?>