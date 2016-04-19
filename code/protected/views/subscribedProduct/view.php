<?php
/* @var $this SubscribedProductController */
/* @var $model SubscribedProduct */

$this->breadcrumbs=array(
	'Subscribed Products'=>array('index'),
	$model->subscribed_product_id,
);

$this->menu=array(
	array('label'=>'List SubscribedProduct', 'url'=>array('index')),
	array('label'=>'Create SubscribedProduct', 'url'=>array('create')),
	array('label'=>'Update SubscribedProduct', 'url'=>array('update', 'id'=>$model->subscribed_product_id)),
	array('label'=>'Delete SubscribedProduct', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->subscribed_product_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SubscribedProduct', 'url'=>array('admin')),
);
?>

<h1>View SubscribedProduct #<?php echo $model->subscribed_product_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'subscribed_product_id',
		'base_product_id',
		'store_id',
		'store_price',
		'store_offer_price',
		'weight',
		'length',
		'width',
		'height',
		'warranty',
		'prompt',
		'prompt_key',
		'status',
		'checkout_url',
		'created_date',
		'modified_date',
		'is_deleted',
		'sku',
		'quantity',
		'is_cod',
		'subscribe_shipping_charge',
	),
)); ?>
