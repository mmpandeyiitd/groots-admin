<?php
/* @var $this RetailerProductQuotationController */
/* @var $model RetailerProductQuotation */

$this->breadcrumbs=array(
	//'Retailer Product Quotations'=>array('index'),
	//$model->id=>array('admin','id'=>$model->id),
	'Retailer Product Update',
);

?>
<?php if (Yii::app()->user->hasFlash('error')): ?><div class="flash-error" style="color: red;"><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>

<h1>Update Buyers Product <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'retailer_id' =>$retailer_id,'subscribed_product_id' =>$subscribed_product_id,'discout_per'=> $discout_per,'effective_price' =>$effective_price,'store_price' => $store_price,'store_offer_price' =>$store_offer_price,)); ?>