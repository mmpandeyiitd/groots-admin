<?php
/* @var $this VendorPaymentController */
/* @var $model VendorPayment */

$this->breadcrumbs=array(
	'Vendor Payments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List VendorPayment', 'url'=>array('index')),
	array('label'=>'Create VendorPayment', 'url'=>array('create')),
	array('label'=>'Update VendorPayment', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete VendorPayment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage VendorPayment', 'url'=>array('admin')),
);
?>

<h1>View VendorPayment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'vendor_id',
		'paid_amount',
		'date',
		'payment_type',
		'cheque_no',
		'debit_no',
		'cheque_cleared',
		'comment',
		'created_at',
		'updated_at',
		'status',
	),
)); ?>
