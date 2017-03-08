<?php
/* @var $this StorelocatinController */
/* @var $model Storelocatin */

$this->breadcrumbs=array(
	'Storelocatins'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Storelocatin', 'url'=>array('index')),
	array('label'=>'Manage Storelocatin', 'url'=>array('admin')),
);
?>

<h1>Create Storelocatin</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>