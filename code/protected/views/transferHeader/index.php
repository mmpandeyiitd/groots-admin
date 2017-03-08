<?php
/* @var $this TransferHeaderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transfer Headers',
);

$this->menu=array(
	array('label'=>'Create TransferHeader', 'url'=>array('create')),
	array('label'=>'Manage TransferHeader', 'url'=>array('admin')),
);
?>

<h1>Transfer Headers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
