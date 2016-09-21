<?php
/* @var $this InventoryHeaderController */
/* @var $model InventoryHeader */

$this->breadcrumbs=array(
	'Inventory Headers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List InventoryHeader', 'url'=>array('index')),
	array('label'=>'Manage InventoryHeader', 'url'=>array('admin')),
);
?>

<h1>Create InventoryHeader</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>