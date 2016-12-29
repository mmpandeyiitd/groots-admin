<?php
/* @var $this VendorPaymentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vendor Payments',
);

$this->menu=array(
	//array('label'=>'Create VendorPayment', 'url'=>array('create')),
	array('label'=>'Manage VendorPayment', 'url'=>array('admin')),
);
?>

<h1>Vendor Payments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
