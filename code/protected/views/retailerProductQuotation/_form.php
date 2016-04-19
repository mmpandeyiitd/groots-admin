<?php
/* @var $this RetailerProductQuotationController */
/* @var $model RetailerProductQuotation */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'retailer-product-quotation-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'retailer_id'); ?>
		<?php echo $form->textField($model,'retailer_id'); ?>
		<?php echo $form->error($model,'retailer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subscribed_product_id'); ?>
		<?php echo $form->textField($model,'subscribed_product_id'); ?>
		<?php echo $form->error($model,'subscribed_product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'effective_price'); ?>
		<?php echo $form->textField($model,'effective_price'); ?>
		<?php echo $form->error($model,'effective_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discout_per'); ?>
		<?php echo $form->textField($model,'discout_per'); ?>
		<?php echo $form->error($model,'discout_per'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		  <?php echo $form->dropdownlist($model, 'status', array('1' => 'Enable', '0' => 'Disable')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->