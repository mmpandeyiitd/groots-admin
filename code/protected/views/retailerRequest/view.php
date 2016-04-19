<?php
/* @var $this RetailerRequestController */
/* @var $model RetailerRequest */

$this->breadcrumbs=array(
	'Retailer Requests'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RetailerRequest', 'url'=>array('index')),
	array('label'=>'Create RetailerRequest', 'url'=>array('create')),
	array('label'=>'Update RetailerRequest', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RetailerRequest', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RetailerRequest', 'url'=>array('admin')),
);
?>

<h1>View RetailerRequest #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'retailer_id',
		'store_id',
		'comment',
		'status',
		'created_date',
	),
)); ?>
