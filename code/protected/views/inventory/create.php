<?php
/* @var $this InventoryController */
/* @var $model Inventory */

$this->breadcrumbs=array(
	//'Inventories'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Inventory', 'url'=>array('admin&w_id='.$w_id)),
	//array('label'=>'Manage Inventory', 'url'=>array('admin')),
	array('label'=>'EDIT INVENTORY', 'url'=>array('inventoryHeader/editInventory&w_id='.$w_id)),
	array('label'=>'BULK UPLOAD', 'url'=>array('inventory/bulkUpload&w_id='.$w_id)),
);
?>

<h1>Create Inventory</h1>

<?php $this->renderPartial('_inventoryForm', array('model'=>$model, 'dataProvider'=>$dataProvider, 'totalInvData'=>$totalInvData, 'w_id'=>$w_id, 'quantitiesMap'=>$quantitiesMap, 'editOnly'=>$editOnly)); ?>