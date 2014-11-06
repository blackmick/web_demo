<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div id="container">
    <div id="header">
        <!--		<div id="logo">--><?php //echo CHtml::encode(Yii::app()->name); ?><!--</div>-->
        <div id="logo" style="float: left">
            <?php
            echo CHtml::image('/web_demo/images/logo.png','',array('height'=>50));
            ?>
        </div>
        <div id="user-state">
            <?php
            echo Yii::app()->user->getName();
            ?>
        </div>
    </div><!-- header -->
    <div id="mainmenu-bar">
        <div id="mainmenu">
            		<?php $this->widget('zii.widgets.CMenu',array(
            			'items'=>array(
            				array('label'=>'个人首页', 'url'=>array('site/index')),
            				array('label'=>'我的简历', 'url'=>array('/profile/index')),
            				array(
                                'label'=>'搜索',
                                'url'=>array('/search/index')),
                            array(
                                'label' => '我应聘的职位',
                                'url'=>array('/job/applied'),
                            ),
                            array(
                                'label'=>'我收藏的职位',
                                'url' => array('/job/favorite'),
                            ),
                            array(
                                'label' => '我的职位订阅器',
                                'url' =>array('/subscriber/index'),
                            ),
            			),
            		)); ?>
        </div><!-- mainmenu -->
    </div>
<div class="container" id="page">
    <div class="breadcrumbs" style="height: 32px">
        	<?php if(isset($this->breadcrumbs)):?>
        		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
        			'links'=>$this->breadcrumbs,
        		)); ?><!-- breadcrumbs -->
        	<?php endif?>
    </div>
<!--    <div class="content-main">-->
        	<?php echo $content; ?>
<!--    </div>-->
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
        <?php echo Yii::getVersion(); ?>
	</div><!-- footer -->
<!---->
</div><!-- page -->
</div><!-- container -->

</body>
</html>
