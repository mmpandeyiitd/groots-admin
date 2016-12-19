<?php
/* @var $this VendorPaymentController */
/* @var $model VendorPayment */

$this->breadcrumbs=array(
	'Vendor Payments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List VendorPayment', 'url'=>array('index')),
	array('label'=>'Manage VendorPayment', 'url'=>array('admin')),
);
?>

<h1>Create VendorPayment</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'vendor'=> $vendor)); ?>