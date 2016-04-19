<?php
/* @var $this LookbookController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lookbooks',
);

$this->menu=array(
	array('label'=>'Create Lookbook', 'url'=>array('create')),
	array('label'=>'Manage Lookbook', 'url'=>array('admin')),
);
?>
<div class="portlet" >
<div class="portlet-decoration">
	<div class="portlet-title">Lookbooks</div>
</div>
	
<div class="portlet-content">
	<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</div>
</div>


