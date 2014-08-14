<?php
/* @var $this EnterpriseController */
/* @var $model Enterprise */

$this->breadcrumbs=array(
	'Enterprises'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Enterprise', 'url'=>array('index')),
	array('label'=>'Create Enterprise', 'url'=>array('create')),
	array('label'=>'View Enterprise', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Enterprise', 'url'=>array('admin')),
);
?>

<h1>Update Enterprise <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>