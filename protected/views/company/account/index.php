<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/27
 * Time: 下午1:58
 */
$this->pageTitle=Yii::app()->name;
?>
<div class="row">
    <?php
    echo CHtml::link('退出登录',Yii::app()->createUrl('site/logout'));
    ?>
</div>
<div class="row">
    <?php
        echo CHtml::encode("您的会员账号可开通{$company->max_account}个");
    ?>
</div>
<?php
$dataProvider = $model->getList();
$this->widget(
    'zii.widgets.grid.CGridView',
    array(
        'dataProvider' => $model->getList(),
        'columns' => array(
            array(
                'header' => '账号名',
                'value' => '$data->username',
            ),
            array(
                'header' => '操作',
                'class' => 'CButtonColumn',
                'template' => '{view}{update}{delete}',
            )
        )
    )
);
?>

<div class="row">
    <?php
    if ($dataProvider->getItemCount() < 3){
        echo CHtml::button('新增', array(
            'onclick' => 'location.href="'.Yii::app()->createUrl('account/create').'"',
        ));
    }else{
        echo CHtml::encode('您的账号数量已达上限,如有增加需求请联系客服xxxxxx');
    }
    ?>
</div>