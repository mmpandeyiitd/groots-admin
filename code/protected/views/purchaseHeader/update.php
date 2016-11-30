<?php
/* @var $this PurchaseHeaderController */
/* @var $model PurchaseHeader */

$this->breadcrumbs=array(
	'Purchase Headers'=>array('admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PurchaseHeader', 'url'=>array('admin&w_id='.$w_id)),
	//array('label'=>'Create PurchaseHeader', 'url'=>array('create')),
	//array('label'=>'View PurchaseHeader', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage PurchaseHeader', 'url'=>array('admin')),
);
?>

<h1>Update Purchase Order <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_purchaseForm', array(
	'model'=>$model,
	'inv_header'=>$inv_header,
	'purchaseLineMap'=> $purchaseLineMap,
	'dataProvider'=>$dataProvider,
	'w_id'=>$w_id,
	'update'=>$update,)); ?>