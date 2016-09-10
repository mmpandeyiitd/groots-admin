<?php
/* @var $this PurchaseLineController */
/* @var $model PurchaseLine */

$this->breadcrumbs=array(
	'Purchase Lines'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PurchaseLine', 'url'=>array('index')),
	array('label'=>'Create PurchaseLine', 'url'=>array('create')),
	array('label'=>'View PurchaseLine', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PurchaseLine', 'url'=>array('admin')),
);
?>

<h1>Update PurchaseLine <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>