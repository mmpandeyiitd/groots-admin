<?php
/* @var $this RetailerProductQuotationController */
/* @var $model RetailerProductQuotation */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model_grid,'retailer_id'); ?>
		<?php echo $form->textField($model_grid,'retailer_id'); ?>
	</div>
        <div class="row">
		<?php echo $form->label($model_grid,'title'); ?>
		<?php echo $form->textField($model_grid,'title'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model_grid,'subscribed_product_id'); ?>
		<?php echo $form->textField($model_grid,'subscribed_product_id'); ?>
	</div>
        <div class="row">
		<?php echo $form->label($model_grid,'effective_price'); ?>
		<?php echo $form->textField($model_grid,'effective_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model_grid,'discount_per'); ?>
		<?php echo $form->textField($model_grid,'discount_per'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model_grid,'status'); ?>
		<?php echo $form->textField($model_grid,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->