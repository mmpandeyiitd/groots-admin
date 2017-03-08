<?php
/* @var $this StorelocatinController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Storelocatins',
);

$this->menu=array(
	array('label'=>'Create Storelocatin', 'url'=>array('create')),
	array('label'=>'Manage Storelocatin', 'url'=>array('admin')),
);
?>

<h1>Storelocatins</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
