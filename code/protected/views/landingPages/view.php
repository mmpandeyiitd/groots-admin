<?php
/* @var $this LandingPagesController */
/* @var $model LandingPages */

$this->breadcrumbs=array(
	'Landing Pages'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LandingPages', 'url'=>array('index')),
	array('label'=>'Create LandingPages', 'url'=>array('create')),
	array('label'=>'Update LandingPages', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LandingPages', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LandingPages', 'url'=>array('admin')),
);
?>

<h1>View LandingPages #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'page_name',
		'content',
		'status',
		'created_at',
		'modified_at',
	),
)); ?>
