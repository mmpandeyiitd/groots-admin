<?php
/* @var $this TransferLineController */
/* @var $model TransferLine */

$this->breadcrumbs=array(
	'Transfer Lines'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransferLine', 'url'=>array('index')),
	array('label'=>'Create TransferLine', 'url'=>array('create')),
	array('label'=>'Update TransferLine', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransferLine', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransferLine', 'url'=>array('admin')),
);
?>

<h1>View TransferLine #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'transfer_id',
		'base_product_id',
		'colour',
		'size',
		'grade',
		'diameter',
		'pack_size',
		'pack_unit',
		'weight',
		'weight_unit',
		'length',
		'length_unit',
		'order_qty',
		'delivered_qty',
		'received_qty',
		'unit_price',
		'price',
		'status',
		'created_at',
		'updated_at',
	),
)); ?>
