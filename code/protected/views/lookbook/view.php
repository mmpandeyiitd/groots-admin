<?php
/* @var $this LookbookController */
/* @var $model Lookbook */

$this->breadcrumbs=array(
	'Lookbooks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Lookbook', 'url'=>array('index')),
	array('label'=>'Create Lookbook', 'url'=>array('create')),
	array('label'=>'Update Lookbook', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Lookbook', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Lookbook', 'url'=>array('admin')),
);
?>

<h1>View Lookbook #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'store_id',
		'headline',
		'main_img_url',
		'thumb_url',
		'org_img_url',
		'pdf_url',
		'status',
		'type',
		'created_at',
	),
)); ?>
