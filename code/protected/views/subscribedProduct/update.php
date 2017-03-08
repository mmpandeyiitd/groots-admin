<?php
/* @var $this SubscribedProductController */
/* @var $model SubscribedProduct */

$this->breadcrumbs=array(
	'Subscribed Products'=>array('index'),
	$model->subscribed_product_id=>array('view','id'=>$model->subscribed_product_id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List SubscribedProduct', 'url'=>array('index')),
	array('label'=>'Create SubscribedProduct', 'url'=>array('baseProduct/subscribegrid')),
	//array('label'=>'View SubscribedProduct', 'url'=>array('view', 'id'=>$model->subscribed_product_id)),
	array('label'=>'Manage SubscribedProduct', 'url'=>array('admin')),
);
?>

<h1>Update SubscribedProduct <?php echo $model->subscribed_product_id; ?></h1>
<?php //echo'<pre>'; print_r($record);die;?>
<?php $this->renderPartial('_forms', array('model'=>$model,'record' => $record)); ?>