<?php
/* @var $this RetailerProductQuotationController */
/* @var $model RetailerProductQuotation */



?>
<?php if (Yii::app()->user->hasFlash('error')): ?><div class="flash-error" style="color: red;"><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>

<h2>Create Retailer Product Quotation</h2>

<?php $this->renderPartial('form_re', array('model_subscribe'=>$model_subscribe,'store_price'=> $store_price,'store_offer_price'=> $store_offer_price,)); ?>