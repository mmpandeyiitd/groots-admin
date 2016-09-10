<?php
/* @var $this OrderLineController */
/* @var $model OrderLine */

$this->breadcrumbs=array(
	'Order Lines'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OrderLine', 'url'=>array('index')),
	array('label'=>'Manage OrderLine', 'url'=>array('admin')),
);
?>

<h1>Create OrderLine</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>