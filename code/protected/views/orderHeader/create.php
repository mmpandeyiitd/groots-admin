<?php
/* @var $this OrderHeaderController */
/* @var $model OrderHeader */
/* @var $retailerProducts retailerProducts */

$w_id='';
if(isset($_GET['w_id'])){
	$w_id = $_GET['w_id'];
}
$this->breadcrumbs=array(
	'Orders'=>array('admin&w_id='.$w_id),
	'Create',
);
$this->menu=array(
	array('label'=>'Order List', 'url'=>array('admin&w_id='.$w_id)),
	//array('label'=>'Create Order', 'url'=>array('create&w_id='.$w_id)),
);
?>

<h1>Create An Order</h1>

<div class="" >
  
<div class="">
<?php
	$this->widget('RetailerDropdown', array(
	'model'=>$model,
		'retailerId'=>$retailerId,

	));
?>

<?php
if(isset($retailerProducts) && $retailerProducts != '' ) { $this->renderPartial('_createOrder', array('model'=>$model, 'retailerProducts'=> $retailerProducts, 'retailerId'=>$retailerId, 'retailer'=>$retailer, 'warehouses'=>$warehouses));
}
?>

</div>
</div>