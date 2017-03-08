<?php
/* @var $this PurchaseHeaderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Purchase Headers',
);

$this->menu=array(
	array('label'=>'Create PurchaseHeader', 'url'=>array('create')),
	array('label'=>'Manage PurchaseHeader', 'url'=>array('admin')),
);
?>

<h1>Purchase Headers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
