<?php
/* @var $this PurchaseLineController */
/* @var $model PurchaseLine */

$this->breadcrumbs=array(
	'Purchase Lines'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PurchaseLine', 'url'=>array('index')),
	array('label'=>'Create PurchaseLine', 'url'=>array('create')),
	array('label'=>'Update PurchaseLine', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PurchaseLine', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PurchaseLine', 'url'=>array('admin')),
);
?>

<h1>View PurchaseLine #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'purchase_id',
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
		'received_qty',
		'unit_price',
		'price',
		'status',
		'created_at',
		'updated_at',
	),
)); ?>
