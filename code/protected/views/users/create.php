<?php
/* @var $this YmpdmUserController */
/* @var $model YmpdmUser */

$this->breadcrumbs=array(
	'Admin Users'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List YmpdmUser', 'url'=>array('index')),
	//array('label'=>'Manage Admin', 'url'=>array('admin')),
);
?>

<div class="" id="yw0">

<!--<ul class="tab_list">
    <li><a href="index.php?r=users/admin">User List</a></li>
</ul>-->
<div class="portlet-content">
  <?php $this->renderPartial('_form', array('model'=>$model,'confirm_password'=>$confirm_password)); ?>
	</div>
</div>

