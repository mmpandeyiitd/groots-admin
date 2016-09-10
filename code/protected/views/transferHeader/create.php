<?php
/* @var $this TransferHeaderController */
/* @var $model TransferHeader */

$this->breadcrumbs=array(
	'Transfer Headers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransferHeader', 'url'=>array('index')),
	array('label'=>'Manage TransferHeader', 'url'=>array('admin')),
);
?>

<h1>Create TransferHeader</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>