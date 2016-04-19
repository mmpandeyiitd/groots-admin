<?php
/* @var $this PressReleaseController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Press Releases',
);

$this->menu=array(
	array('label'=>'Create PressRelease', 'url'=>array('create')),
	array('label'=>'Manage PressRelease', 'url'=>array('admin')),
);
?>

<h1>Press Releases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
