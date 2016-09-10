<?php
/* @var $this GrootsledgerController */
/* @var $model Grootsledger */

$this->breadcrumbs=array(
	'Grootsledgers'=>array('index'),
	$model->Max_id,
);

$this->menu=array(
	array('label'=>'List Grootsledger', 'url'=>array('index')),
	array('label'=>'Create Grootsledger', 'url'=>array('create')),
	array('label'=>'Update Grootsledger', 'url'=>array('update', 'id'=>$model->Max_id)),
	array('label'=>'Delete Grootsledger', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Max_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Grootsledger', 'url'=>array('admin')),
);
?>

<h1>View Grootsledger #<?php echo $model->Max_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'order_id',
		'order_number',
		'user_id',
		'agent_name',
		'total_payable_amount',
		'MIN_DUE_AMOUNT',
		'Max_id',
	),
)); ?>
