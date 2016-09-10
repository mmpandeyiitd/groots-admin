<?php
/* @var $this TransferHeaderController */
/* @var $model TransferHeader */

$this->breadcrumbs=array(
	'Transfer Headers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransferHeader', 'url'=>array('index')),
	array('label'=>'Create TransferHeader', 'url'=>array('create')),
	array('label'=>'Update TransferHeader', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransferHeader', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransferHeader', 'url'=>array('admin')),
);
?>

<h1>View TransferHeader #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'source_warehouse_id',
		'dest_warehouse_id',
		'status',
		'delivery_date',
		'comment',
		'invoice_number',
		'created_at',
		'updated_at',
	),
)); ?>
