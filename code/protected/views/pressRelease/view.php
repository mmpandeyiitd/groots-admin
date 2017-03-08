<?php
/* @var $this PressReleaseController */
/* @var $model PressRelease */

$this->breadcrumbs=array(
	'Press Releases'=>array('admin'),
	$model->id,
);

$this->menu=array(
	//array('label'=>'List PressRelease', 'url'=>array('admin')),
	array('label'=>'Create PressRelease', 'url'=>array('create')),
	array('label'=>'Update PressRelease', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PressRelease', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PressRelease', 'url'=>array('admin')),
);
?>

<h1>View PressRelease #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'comment',
		'start_date',
		'end_date',
		'status',
		'brand_id',
		//'image',
	),
)); ?>
