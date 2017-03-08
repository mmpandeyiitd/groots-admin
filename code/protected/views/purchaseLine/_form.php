<?php
/* @var $this PurchaseLineController */
/* @var $model PurchaseLine */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'purchase-line-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'purchase_id'); ?>
		<?php echo $form->textField($model,'purchase_id'); ?>
		<?php echo $form->error($model,'purchase_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'base_product_id'); ?>
		<?php echo $form->textField($model,'base_product_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'base_product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'colour'); ?>
		<?php echo $form->textField($model,'colour',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'colour'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'size'); ?>
		<?php echo $form->textField($model,'size',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'size'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'grade'); ?>
		<?php echo $form->textField($model,'grade',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'grade'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'diameter'); ?>
		<?php echo $form->textField($model,'diameter',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'diameter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pack_size'); ?>
		<?php echo $form->textField($model,'pack_size'); ?>
		<?php echo $form->error($model,'pack_size'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pack_unit'); ?>
		<?php echo $form->textField($model,'pack_unit',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'pack_unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weight'); ?>
		<?php echo $form->textField($model,'weight',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'weight'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weight_unit'); ?>
		<?php echo $form->textField($model,'weight_unit',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'weight_unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'length'); ?>
		<?php echo $form->textField($model,'length',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'length'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'length_unit'); ?>
		<?php echo $form->textField($model,'length_unit',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'length_unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_qty'); ?>
		<?php echo $form->textField($model,'order_qty',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'order_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'received_qty'); ?>
		<?php echo $form->textField($model,'received_qty',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'received_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unit_price'); ?>
		<?php echo $form->textField($model,'unit_price',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'unit_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>17,'maxlength'=>17)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
		<?php echo $form->error($model,'updated_at'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->