<?php
/* @var $this PurchaseHeaderController */
/* @var $model PurchaseHeader */

$this->breadcrumbs=array(
	'Purchase Headers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PurchaseHeader', 'url'=>array('index')),
	array('label'=>'Create PurchaseHeader', 'url'=>array('create')),
	array('label'=>'View PurchaseHeader', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PurchaseHeader', 'url'=>array('admin')),
);
?>

<h1>Update PurchaseHeader <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>