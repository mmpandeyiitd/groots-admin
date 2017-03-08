<?php
/* @var $this TransferLineController */
/* @var $model TransferLine */

$this->breadcrumbs=array(
	'Transfer Lines'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransferLine', 'url'=>array('index')),
	array('label'=>'Create TransferLine', 'url'=>array('create')),
	array('label'=>'View TransferLine', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransferLine', 'url'=>array('admin')),
);
?>

<h1>Update TransferLine <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>