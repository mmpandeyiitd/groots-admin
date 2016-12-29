<?php
/* @var $this VendorController */
/* @var $model Vendor */

$this->breadcrumbs=array(
	'Vendors'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Vendor', 'url'=>array('index')),
	array('label'=>'Create Vendor', 'url'=>array('create')),
	array('label' => 'Credit Management', 'url' => array('creditManagement')),
	array('label' => 'Vendor Payment' , 'url' => array('vendorPayment/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#vendor-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Vendors</h1>

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
	'id'=>'vendor-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'vendor_code',
		'VAT_number',
		'email',
		'password',
		array(
			'header' => 'Product Mapping',
			'type' => 'raw',
			'value' => function($data){
						echo CHtml::link('Product Map', array('vendor/productMap', 'vendor_id' => $data->id), array('target'=>'_blank'));
					}
			),
		array(
			'header' => 'Create Payemnt',
			'type' => 'raw',
			'value' => function($data){
				echo CHtml::link('Payment', array('vendorPayment/create', 'vendor_id' => $data->id), array('target' => '_blank'));
			}
			),
		// array(
		// 	'header' => 'Payment Ledger',
		// 	'type' => 'raw',
		// 	'value' => function($data){
		// 		echo CHtml::link('Payment Ledger', array('vendorPayment/payments', 'vendorId' => $data->id), array('target' => '_blank'));
		// 	}),
		/*
		'mobile',
		'telephone',
		'address',
		'pincode',
		'owner_phone',
		'owner_email',
		'settlement_days',
		'time_of_delivery',
		'date_of_onboarding',
		'city',
		'state',
		'image',
		'image_url',
		'website',
		'contact_person1',
		'contact_person2',
		'status',
		'credit_limit',
		'created_date',
		'updated_at',
		'allocated_warehouse_id',
		'initial_pending_amount',
		'total_pending_amount',
		'bussiness_name',
		'payment_terms',
		'proc_exec_id',
		*/
		array(
			'header' => 'Update',
			'class'=>'CButtonColumn',
			'template' => '{view}{update}'
		),
	),
)); ?>
