<?php
/* @var $this PurchaseHeaderController */
/* @var $model PurchaseHeader */

$this->breadcrumbs=array(
	'Purchase Headers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Purchases', 'url'=>array('admin')),
	//array('label'=>'Manage PurchaseHeader', 'url'=>array('admin')),
);
?>

<h1>Create Purchases</h1>

<?php //$this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->renderPartial('_purchaseForm', array('model'=>$model, 'items'=>$items, 'otherItems'=>$otherItems)); ?>


