<?php
/* @var $this RetailerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Retailers',
);

$this->menu=array(
	array('label'=>'Create Retailer', 'url'=>array('create')),
	array('label'=>'Manage Retailer', 'url'=>array('admin')),
);
?>

<h1>Retailers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
