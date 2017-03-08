<?php
/* @var $this StoreController */
/* @var $model Store */

$this->breadcrumbs=array(
	'Brand'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Brand', 'url'=>array('index')),
	//array('label'=>'Manage Brand', 'url'=>array('admin')),
);
?>

<div class="" id="yw0">
<!-- <div class="portlet-decoration">
<div class="portlet-title"><i class="icon-user"></i> Create Brand </div>
</div> -->

<div class="portlet-content">
  <?php $this->renderPartial('_forms', array('model'=>$model,'password'=>$password)); ?>
	</div>
</div>