<?php
/* @var $this TransferLineController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transfer Lines',
);

$this->menu=array(
	array('label'=>'Create TransferLine', 'url'=>array('create')),
	array('label'=>'Manage TransferLine', 'url'=>array('admin')),
);
?>

<h1>Transfer Lines</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
