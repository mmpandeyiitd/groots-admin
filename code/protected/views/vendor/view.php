<?php
/* @var $this VendorController */
/* @var $model Vendor */

$this->breadcrumbs=array(
	'Vendors'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List Vendor', 'url'=>array('index')),
	array('label'=>'Create Vendor', 'url'=>array('create')),
	array('label'=>'Update Vendor', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete Vendor', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Vendor', 'url'=>array('admin')),
);
?>

<h1>View Vendor #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'vendor_type',
		'vendor_code',
		'VAT_number',
		'email',
		'password',
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
	),
)); ?>
