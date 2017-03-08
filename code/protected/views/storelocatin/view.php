<?php
/* @var $this StorelocatinController */
/* @var $model Storelocatin */

$this->breadcrumbs=array(
	'Storelocatins'=>array('index'),
	$model->store_id,
);

$this->menu=array(
	array('label'=>'List Storelocatin', 'url'=>array('index')),
	array('label'=>'Create Storelocatin', 'url'=>array('create')),
	array('label'=>'Update Storelocatin', 'url'=>array('update', 'id'=>$model->store_id)),
	array('label'=>'Delete Storelocatin', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->store_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Storelocatin', 'url'=>array('admin')),
);
?>

<h1>View Storelocatin #<?php echo $model->store_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'store_id',
		'getit_store_id',
		'store_code',
		'store_name',
		'store_details',
		'store_logo',
		'seller_name',
		'business_address',
		'business_address_country',
		'business_address_state',
		'business_address_city',
		'business_address_pincode',
		'lat',
		'long',
		'mobile_numbers',
		'telephone_numbers',
		'visible',
		'meta_title',
		'meta_keywords',
		'meta_description',
		'customer_value',
		'chat_id',
		'email',
		'status',
		'vtiger_status',
		'vtiger_accountid',
		'created_date',
		'modified_date',
		'is_deleted',
		'tagline',
		'is_tagline',
		'store_api_key',
		'store_api_password',
		'redirect_url',
		'seller_mailer_flag',
		'buyer_mailer_flag',
		'channel_name',
		'channel_id',
		'order_prefix',
		'is_active_valid',
		'store_shipping_charge',
		'store_tax_per',
		'location',
	),
)); ?>
