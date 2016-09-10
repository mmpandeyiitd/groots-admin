<?php
/* @var $this GrootsledgerController */
/* @var $model Grootsledger */

$this->breadcrumbs=array(
	'Grootsledgers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Grootsledger', 'url'=>array('index')),
	array('label'=>'Manage Grootsledger', 'url'=>array('admin')),
);
?>

<h1>Create Grootsledger</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>