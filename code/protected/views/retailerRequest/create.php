<?php
/* @var $this RetailerRequestController */
/* @var $model RetailerRequest */
$retailer_id='';
if (isset($_GET['retailer_id'])) {
    $retailer_id = $_GET['retailer_id'];
}
$this->breadcrumbs=array(
	'Retailer Requests'=>array('admin', "retailer_id" => $retailer_id),
	'Create',
);

$this->menu=array(
	//array('label'=>'List RetailerRequest', 'url'=>array('index')),
	array('label'=>'Manage RetailerRequest', 'url'=>array('admin', "retailer_id" => $retailer_id)),
);
?>

<h1>Create RetailerRequest</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>