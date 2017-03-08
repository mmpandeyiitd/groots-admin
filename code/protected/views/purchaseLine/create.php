<?php
/* @var $this PurchaseLineController */
/* @var $model PurchaseLine */

$this->breadcrumbs=array(
	'Purchase Lines'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PurchaseLine', 'url'=>array('index')),
	array('label'=>'Manage PurchaseLine', 'url'=>array('admin')),
);
?>

<h1>Create PurchaseLine</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>