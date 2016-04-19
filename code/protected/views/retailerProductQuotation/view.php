<?php
/* @var $this RetailerProductQuotationController */
/* @var $model RetailerProductQuotation */

$this->breadcrumbs=array(
	'Retailer Product Quotations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RetailerProductQuotation', 'url'=>array('index')),
	array('label'=>'Create RetailerProductQuotation', 'url'=>array('create')),
	array('label'=>'Update RetailerProductQuotation', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RetailerProductQuotation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RetailerProductQuotation', 'url'=>array('admin')),
);
?>

<h1>View RetailerProductQuotation #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'retailer_id',
		'subscribed_product_id',
		'effective_price',
		'discout_per',
		'status',
	),
)); ?>
