<?php
/* @var $this RetailerProductQuotationController */
/* @var $model RetailerProductQuotation */

$this->breadcrumbs=array(
	'Retailer Product Quotations'=>array('index'),
	'Create',
);


?>
<?php if (Yii::app()->user->hasFlash('error')): ?><div class="flash-error" style="color: red;"><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>

<h1>Create Retailer Product Quotation</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>