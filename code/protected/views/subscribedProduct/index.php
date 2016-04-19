<?php
/* @var $this SubscribedProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Subscribed Products',
);

$this->menu=array(
	array('label'=>'Create SubscribedProduct', 'url'=>array('create')),
	array('label'=>'Manage SubscribedProduct', 'url'=>array('admin')),
);
?>

<h1>Subscribed Products</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
