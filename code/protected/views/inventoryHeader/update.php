<?php
/* @var $this InventoryHeaderController */
/* @var $model InventoryHeader */

$this->breadcrumbs=array(
	'Inventory Headers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List InventoryHeader', 'url'=>array('index')),
	array('label'=>'Create InventoryHeader', 'url'=>array('create')),
	array('label'=>'View InventoryHeader', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage InventoryHeader', 'url'=>array('admin')),
);
?>

<h1>Update InventoryHeader <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>