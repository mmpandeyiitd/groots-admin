<?php
/* @var $this OrderLineController */
/* @var $model OrderLine */

$this->breadcrumbs=array(
	'Order Lines'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OrderLine', 'url'=>array('index')),
	array('label'=>'Create OrderLine', 'url'=>array('create')),
	array('label'=>'Update OrderLine', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrderLine', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrderLine', 'url'=>array('admin')),
);
?>

<h1>View OrderLine #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'order_id',
		'subscribed_product_id',
		'base_product_id',
		'store_id',
		'store_name',
		'store_email',
		'store_front_id',
		'store_front_name',
		'seller_name',
		'seller_phone',
		'seller_address',
		'seller_state',
		'seller_city',
		'colour',
		'size',
		'product_name',
		'product_qty',
		'unit_price',
		'price',
	),
)); ?>
