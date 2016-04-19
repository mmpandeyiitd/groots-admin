<?php
/* @var $this OrderHeaderController */
/* @var $model OrderHeader */

$this->breadcrumbs=array(
	'Order Headers'=>array('index'),
	$model->order_id,
);

$this->menu=array(
	array('label'=>'List OrderHeader', 'url'=>array('index')),
	array('label'=>'Create OrderHeader', 'url'=>array('create')),
	array('label'=>'Update OrderHeader', 'url'=>array('update', 'id'=>$model->order_id)),
	array('label'=>'Delete OrderHeader', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->order_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrderHeader', 'url'=>array('admin')),
);
?>

<h1>View OrderHeader #<?php echo $model->order_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'order_id',
		'order_number',
		'user_id',
		'created_date',
		'payment_method',
		'payment_status',
		'billing_name',
		'billing_phone',
		'billing_email',
		'billing_address',
		'billing_state',
		'billing_city',
		'billing_pincode',
		'shipping_name',
		'shipping_phone',
		'shipping_email',
		'shipping_address',
		'shipping_state',
		'shipping_city',
		'shipping_pincode',
		'shipping_charges',
		'total',
		'total_payable_amount',
		'total_paid_amount',
		'discount_amt',
		'coupon_code',
		'payment_ref_id',
		'payment_gateway_name',
		'payment_source',
		'order_source',
		'timestamp',
		'transaction_id',
		'bank_transaction_id',
		'transaction_time',
		'payment_mod',
		'bankname',
		'status',
		'cron_processed_flag',
		'source_url',
		'source_type',
		'source_id',
		'source_name',
		'campaign_id',
		'buyer_shipping_cost',
		'order_type',
		'utm_source',
	),
)); ?>
