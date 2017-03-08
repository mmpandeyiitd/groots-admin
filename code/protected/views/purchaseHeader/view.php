<?php
/* @var $this PurchaseHeaderController */
/* @var $model PurchaseHeader */

$this->breadcrumbs=array(
	'Purchase Headers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PurchaseHeader', 'url'=>array('index')),
	array('label'=>'Create PurchaseHeader', 'url'=>array('create')),
	array('label'=>'Update PurchaseHeader', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PurchaseHeader', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PurchaseHeader', 'url'=>array('admin')),
);
?>

<h1>View PurchaseHeader #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'warehouse_id',
		'vendor_id',
		'payment_method',
		'payment_status',
		'status',
		'delivery_date',
		'total_payable_amount',
		'comment',
		'invoice_number',
		'created_at',
		'updated_at',
	),
)); ?>
