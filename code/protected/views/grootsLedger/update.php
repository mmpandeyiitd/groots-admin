<?php
/* @var $this GrootsLedgerController */
/* @var $model GrootsLedger */

$this->breadcrumbs=array(
	'Groots Ledgers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GrootsLedger', 'url'=>array('index')),
	array('label'=>'Create GrootsLedger', 'url'=>array('create')),
	array('label'=>'View GrootsLedger', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GrootsLedger', 'url'=>array('admin')),
);
?>

<h1>Update GrootsLedger <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>