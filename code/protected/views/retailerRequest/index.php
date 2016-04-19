<?php
/* @var $this RetailerRequestController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Retailer Requests',
);

$this->menu=array(
	array('label'=>'Create RetailerRequest', 'url'=>array('create')),
	array('label'=>'Manage RetailerRequest', 'url'=>array('admin')),
);
?>

<h1>Retailer Requests</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
