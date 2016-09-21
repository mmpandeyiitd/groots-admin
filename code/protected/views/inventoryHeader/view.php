<?php
/* @var $this InventoryHeaderController */
/* @var $model InventoryHeader */

$this->breadcrumbs=array(
	'Inventory Headers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List InventoryHeader', 'url'=>array('index')),
	array('label'=>'Create InventoryHeader', 'url'=>array('create')),
	array('label'=>'Update InventoryHeader', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete InventoryHeader', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage InventoryHeader', 'url'=>array('admin')),
);
?>

<h1>View InventoryHeader #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'warehouse_id',
		'base_product_id',
		'schedule_inv',
		'schedule_inv_type',
		'extra_inv',
		'extra_inv_type',
		'created_at',
		'updated_at',
	),
)); ?>
