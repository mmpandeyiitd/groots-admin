<?php
/* @var $this TransferLineController */
/* @var $model TransferLine */

$this->breadcrumbs=array(
	'Transfer Lines'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransferLine', 'url'=>array('index')),
	array('label'=>'Manage TransferLine', 'url'=>array('admin')),
);
?>

<h1>Create TransferLine</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>