<?php
/* @var $this InventoryController */
/* @var $model Inventory */

$this->breadcrumbs=array(
	//'Inventories'=>array('index'),
	//$model->id=>array('view','id'=>$model->id),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Inventory', 'url'=>array('index')),
	array('label'=>'Create Inventory', 'url'=>array('create&w_id='.$w_id)),
	//array('label'=>'View Inventory', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage Inventory', 'url'=>array('admin')),
);
?>

<h1>Manage Inventory <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_updateForm', array('model'=>$model, 'dataProvider'=>$dataProvider, 'otherItems'=>$otherItems, 'w_id'=>$w_id, 'quantitiesMap'=>$quantitiesMap)); ?>