<?php
/* @var $this OrderLineController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Order Lines',
);

$this->menu=array(
	array('label'=>'Create OrderLine', 'url'=>array('create')),
	array('label'=>'Manage OrderLine', 'url'=>array('admin')),
);
?>

<h1>Order Lines</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
