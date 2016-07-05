<?php
/* @var $this GrootsledgerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Grootsledgers',
);

$this->menu=array(
	array('label'=>'Create Grootsledger', 'url'=>array('create')),
	array('label'=>'Manage Grootsledger', 'url'=>array('admin')),
);
?>

<h1>Grootsledgers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
