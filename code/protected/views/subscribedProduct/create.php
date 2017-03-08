<?php
/* @var $this SubscribedProductController */
/* @var $model SubscribedProduct */

$this->breadcrumbs=array(
	'Subscribed Products'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage SubscribedProduct', 'url'=>array('admin','store_id'=>$store_id)),
);
?>
<?php //echo'<pre>'; print_r($model);die;?>
<h1>Create SubscribedProduct</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'record'=>$record ,'store_id' => $store_id)); ?>
