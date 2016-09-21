<?php
/* @var $this TransferHeaderController */
/* @var $model TransferHeader */

$this->breadcrumbs=array(
	'Transfer Headers'=>array('admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Transfer Orders', 'url'=>array('admin&w_id='.$w_id)),
	/*array('label'=>'Create TransferHeader', 'url'=>array('create')),
	array('label'=>'View TransferHeader', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransferHeader', 'url'=>array('admin')),*/
);
?>

<h1>Update Transfer Order <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_transferForm', array(
	'model'=>$model,
	'purchaseLines'=> $transferLines,
	'dataProvider'=>$dataProvider,
	'otherItems'=> $otherItems,
	'w_id'=>$w_id,
	'update'=>$update,)); ?>