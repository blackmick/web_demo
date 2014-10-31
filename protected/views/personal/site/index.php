<?php
/* @var $this SiteController */
/* @var $model Company */

$this->pageTitle=Yii::app()->name;
$user = User::model()->findByPk(Yii::app()->user->getId());
?>

<div class="row">
    <?php
    echo CHtml::link(
        //"<img src='images/Users.png' alt='企业信息' height='100' width='100'></br>企业信息",
        "简历管理",
        Yii::app()->createUrl('profile/index', array('id' => $user->id))
    );
    ?>
</div>
<div class="row">
    <?php
    echo CHtml::link(
        //"<img src='images/Users.png' alt='企业信息' height='100' width='100'></br>企业信息",
        "订阅管理",
        Yii::app()->createUrl('sub/index', array('id' => $user->id))
    );
    ?>
</div>
<div class="row">
    <?php
    echo CHtml::link(
    //"<img src='images/Users.png' alt='企业信息' height='100' width='100'></br>企业信息",
        "消息管理",
        Yii::app()->createUrl('msg/index', array('id' => $user->id))
    );
    ?>
</div>
<div class="row">
    <?php
    echo CHtml::link(
    //"<img src='images/Users.png' alt='企业信息' height='100' width='100'></br>企业信息",
        "资讯信息",
        Yii::app()->createUrl('news/index', array('id' => $user->id))
    );
    ?>
</div>
<div class="row">
    <?php
    echo CHtml::link(
    //"<img src='images/Users.png' alt='企业信息' height='100' width='100'></br>企业信息",
        "职位搜索",
        Yii::app()->createUrl('search/job', array('id' => $user->id))
    );
    ?>
</div>


