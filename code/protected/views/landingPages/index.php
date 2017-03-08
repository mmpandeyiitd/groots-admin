<?php
/* @var $this LandingPagesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Landing Pages',
);

$this->menu=array(
	array('label'=>'Create LandingPages', 'url'=>array('create')),
	array('label'=>'Manage LandingPages', 'url'=>array('admin')),
);
?>

<h1>Landing Pages</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
