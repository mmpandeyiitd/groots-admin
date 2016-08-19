<?php
/* @var $this OrderHeaderController */
/* @var $model OrderHeader */
/* @var $retailerProducts retailerProducts */


$this->breadcrumbs=array(
	'Order Headers'=>array('admin'),
	'Create',
);

?>

<h1>Create An Order</h1>

<div class="" >
  
<div class="portlet-content">
<?php $this->renderPartial('_retailerDropdown', array('model'=>$model, 'retailerId'=>$retailerId)); ?>


<?php
if(isset($retailerProducts) && $retailerProducts != '' ) { $this->renderPartial('_create', array('model'=>$model, 'retailerProducts'=> $retailerProducts, 'retailerId'=>$retailerId, 'retailer'=>$retailer, 'warehouses'=>$warehouses));
}
?>

</div>
</div>