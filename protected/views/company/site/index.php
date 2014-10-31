<?php
/* @var $this SiteController */
/* @var $model Company */

$this->pageTitle=Yii::app()->name;
?>

<?php
$ca = CompanyAccount::model()->findByPk(Yii::app()->user->getId());
echo CHtml::link(
    //"<img src='images/Users.png' alt='企业信息' height='100' width='100'></br>企业信息",
    "企业信息",
    Yii::app()->createUrl('company/view', array('id' => $ca->cid))
);
echo "</br>";
echo CHtml::link(
    //"<img src='images/Users.png' alt='搜索人选' height='80', width= '80'></br>搜索人选",
    "搜索人选",
    array('search/candidate')
);
echo "</br>";
echo CHtml::link(
    //"<img src='images/Users.png' alt='发布职位' height='80', width= '80'></br>发布职位",
    "发布职位",
    array('job/create')
);
echo "</br>";
echo CHtml::link(
    //"<img src='images/Users.png' alt='职位管理' height='80', width= '80'></br>职位管理",
    "职位管理",
    array('job/list')
);
?>


