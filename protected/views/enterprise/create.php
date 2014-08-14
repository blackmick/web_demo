<?php
/* @var $this EnterpriseController */
/* @var $model Enterprise */

$this->breadcrumbs=array(
	'Enterprises'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Enterprise', 'url'=>array('index')),
	array('label'=>'Manage Enterprise', 'url'=>array('admin')),
);
?>

<h1>Create Enterprise</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>