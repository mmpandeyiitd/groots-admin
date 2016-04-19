<?php
/* @var $this StorelocatinController */
/* @var $model Storelocatin */

$this->breadcrumbs=array(
	'Storelocatins'=>array('index'),
	$model->store_id=>array('view','id'=>$model->store_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Storelocatin', 'url'=>array('index')),
	array('label'=>'Create Storelocatin', 'url'=>array('create')),
	array('label'=>'View Storelocatin', 'url'=>array('view', 'id'=>$model->store_id)),
	array('label'=>'Manage Storelocatin', 'url'=>array('admin')),
);
?>

<h1>Update Storelocatin <?php echo $model->store_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>