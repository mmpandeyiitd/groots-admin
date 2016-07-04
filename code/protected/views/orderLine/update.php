<?php
/* @var $this OrderLineController */
/* @var $model OrderLine */

$this->breadcrumbs=array(
	'Order Lines'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrderLine', 'url'=>array('index')),
	array('label'=>'Create OrderLine', 'url'=>array('create')),
	array('label'=>'View OrderLine', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrderLine', 'url'=>array('admin')),
);
?>

<h1>Update OrderLine <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>