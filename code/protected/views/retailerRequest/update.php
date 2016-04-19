<?php
/* @var $this RetailerRequestController */
/* @var $model RetailerRequest */
$retailer_id='';
if (isset($_GET['retailer_id'])) {
    $retailer_id = $_GET['retailer_id'];
}
$this->breadcrumbs=array(
	'Retailer Requests'=>array('admin', "retailer_id" => $retailer_id),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List RetailerRequest', 'url'=>array('index')),
	array('label'=>'Create RetailerRequest', 'url'=>array('create', "retailer_id" => $retailer_id)),
	//array('label'=>'View RetailerRequest', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RetailerRequest', 'url'=>array('admin', "retailer_id" => $retailer_id)),
);
?>
 <?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-error" style="color: green;"><?php echo Yii::app()->user->getFlash('permissio_error'); ?></div><?php endif; ?>

<h1>Update RetailerRequest <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>