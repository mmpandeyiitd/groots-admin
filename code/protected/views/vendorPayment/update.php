<?php
/* @var $this VendorPaymentController */
/* @var $model VendorPayment */
$vendor_id = $_GET['id'];
$this->breadcrumbs=array(
	'Vendor Payments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List VendorPayment', 'url'=>array('index')),
	array('label'=>'Create VendorPayment', 'url'=>array('create', 'vendor_id' => $model->vendor_id)),
	array('label'=>'View VendorPayment', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage VendorPayment', 'url'=>array('admin')),
);
?>

<h1>Update VendorPayment <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'update'=>true, 'vendor' => $vendor)); ?>