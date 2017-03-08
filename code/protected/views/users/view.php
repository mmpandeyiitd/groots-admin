<?php
/* @var $this YmpdmUserController */
/* @var $model YmpdmUser */

$this->breadcrumbs=array(
	'Ympdm Users'=>array('index'),
	$model->name,
);

$this->menu=array(
	
	array('label'=>'Create YmpdmUser', 'url'=>array('create')),
	array('label'=>'Update YmpdmUser', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage YmpdmUser', 'url'=>array('admin')),
);
?>

<h1>View YmpdmUser #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'email',
		'password',
		'permission_info',
		'created_at',
	),
)); ?>
