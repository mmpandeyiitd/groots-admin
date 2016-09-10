<?php
/* @var $this GrootsLedgerController */
/* @var $model GrootsLedger */

$this->breadcrumbs=array(
	'Groots Ledgers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GrootsLedger', 'url'=>array('index')),
	array('label'=>'Create GrootsLedger', 'url'=>array('create')),
	array('label'=>'Update GrootsLedger', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GrootsLedger', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GrootsLedger', 'url'=>array('admin')),
);
?>

<h1>View GrootsLedger #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'order_id',
		'order_number',
		'user_id',
		'agent_name',
		'total_amount',
		'due_amount',
		'paid_amount',
		'paid_value',
		'delivery_date',
		'created_at',
		'inv_created_at',
	),
)); ?>
