<?php
/* @var $this GrootsLedgerController */
/* @var $model GrootsLedger */

$this->breadcrumbs=array(
	'Groots Ledgers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GrootsLedger', 'url'=>array('index')),
	array('label'=>'Manage GrootsLedger', 'url'=>array('admin')),
);
?>

<h1>Create GrootsLedger</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>