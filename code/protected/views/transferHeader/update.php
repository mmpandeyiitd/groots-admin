<?php
/* @var $this TransferHeaderController */
/* @var $model TransferHeader */

$this->breadcrumbs=array(
	'Transfer Headers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransferHeader', 'url'=>array('index')),
	array('label'=>'Create TransferHeader', 'url'=>array('create')),
	array('label'=>'View TransferHeader', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransferHeader', 'url'=>array('admin')),
);
?>

<h1>Update TransferHeader <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>