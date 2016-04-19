<?php
/* @var $this StorelocatinController */
/* @var $model Storelocatin */

$this->breadcrumbs=array(
	'Storelocatins'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Storelocatin', 'url'=>array('index')),
	array('label'=>'Create Storelocatin', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#storelocatin-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Storelocatins</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'storelocatin-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'store_id',
		'getit_store_id',
		'store_code',
		'store_name',
		'store_details',
		'store_logo',
        'location',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
