<?php
/* @var $this VendorPaymentController */
/* @var $model VendorPayment */

$this->breadcrumbs=array(
	'Vendor Payments'=>array('index'),
	$model->id,
);

$this->menu=array(
	//array('label'=>'List VendorPayment', 'url'=>array('index')),
	array('label'=>'Create VendorPayment', 'url'=>array('create', 'vendor_id' => $model->vendor_id)),
	array('label'=>'Update VendorPayment', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete VendorPayment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
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
		'cheque_status',
		'cheque_issue_date',
		'cheque_name',
		'transaction_id',
		'receiving_acc_no',
		'bank_name',
		'isfc_code',
		'acc_holder_name',
		'comment',
		'created_at',
		'updated_at',
		'status',
	),
)); ?>
