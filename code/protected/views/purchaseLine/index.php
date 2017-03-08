<?php
/* @var $this PurchaseLineController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Purchase Lines',
);

$this->menu=array(
	array('label'=>'Create PurchaseLine', 'url'=>array('create')),
	array('label'=>'Manage PurchaseLine', 'url'=>array('admin')),
);
?>

<h1>Purchase Lines</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
