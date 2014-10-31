<?php
/**
 * Created by PhpStorm.
 * User: jacky
 * Date: 14/10/29
 * Time: 下午4:33
 */
?>

<div class="row">
    <?php
    echo CHtml::link(
        '修改密码',
        Yii::app()->createUrl('account/changepassword', array('id'=> Yii::app()->user->getId()))
    );
    ?>
</div>
<div class="row">
    <?php
    echo CHtml::link(
        '重置密码',
        Yii::app()->createUrl('account/changepassword', array('id'=> Yii::app()->user->getId()))
    );
    ?>
</div>
<div class="row">
    <?php
    echo CHtml::link(
        '修改绑定邮箱',
        Yii::app()->createUrl('account/changepassword', array('id'=> Yii::app()->user->getId()))
    );
    ?>
</div>
<div class="row">
    <?php
    echo CHtml::link(
        '退出登录',
        Yii::app()->createUrl('account/logout', array('id'=> Yii::app()->user->getId()))
    );
    ?>
</div>