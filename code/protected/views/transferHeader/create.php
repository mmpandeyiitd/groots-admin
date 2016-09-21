<?php
/* @var $this TransferHeaderController */
/* @var $model TransferHeader */

$this->breadcrumbs=array(
	'Transfer Orders'=>array('admin&w_id='.$w_id),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransferHeader', 'url'=>array('admin&w_id='.$w_id)),
	//array('label'=>'Manage TransferHeader', 'url'=>array('admin')),
);
?>

<h1>Create Transfer Orders</h1>

<?php $this->renderPartial('_transferForm', array('model'=>$model, 'dataProvider'=>$dataProvider, 'otherItems'=>$otherItems, 'w_id'=>$w_id)); ?>