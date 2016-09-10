<?php
/* @var $this GrootsledgerController */
/* @var $model Grootsledger */

$this->breadcrumbs=array(
	'Grootsledgers'=>array('index'),
	$model->Max_id=>array('view','id'=>$model->Max_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Grootsledger', 'url'=>array('index')),
	array('label'=>'Create Grootsledger', 'url'=>array('create')),
	array('label'=>'View Grootsledger', 'url'=>array('view', 'id'=>$model->Max_id)),
	array('label'=>'Manage Grootsledger', 'url'=>array('admin')),
);
?>

<h1>Update Grootsledger <?php echo $model->Max_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>