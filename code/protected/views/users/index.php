<?php
/* @var $this YmpdmUserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ympdm Users',
);

$this->menu=array(
	array('label'=>'Create YmpdmUser', 'url'=>array('create')),
	array('label'=>'Manage YmpdmUser', 'url'=>array('admin')),
);
?>

<h1>Ympdm Users</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
