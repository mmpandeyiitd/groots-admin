<?php
/* @var $this InventoryHeaderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Inventory Headers',
);

$this->menu=array(
	array('label'=>'Create InventoryHeader', 'url'=>array('create')),
	array('label'=>'Manage InventoryHeader', 'url'=>array('admin')),
);
?>

<h1>Inventory Headers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
