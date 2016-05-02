<?php
/* @var $this RetailerController */
/* @var $model Retailer */
$this->breadcrumbs=array(
	'Buyers'=>array('admin'),
	 $model->name=>array('update','id'=>$model->id),
	'Update',
);

?>
<div class="" id="yw0">
<div class="portlet-content">
  <?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>



