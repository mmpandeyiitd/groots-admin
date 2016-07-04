<?php
/* @var $this GrootsLedgerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Groots Ledgers',
);

$this->menu=array(
	array('label'=>'Create GrootsLedger', 'url'=>array('create')),
	array('label'=>'Manage GrootsLedger', 'url'=>array('admin')),
);
?>

<h1>Groots Ledgers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
