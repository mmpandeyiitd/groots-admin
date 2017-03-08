<?php
/* @var $this InventoryController */
/* @var $model Inventory */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inventory-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'warehouse_id'); ?>
		<?php echo $form->textField($model,'warehouse_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'warehouse_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'base_product_id'); ?>
		<?php echo $form->textField($model,'base_product_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'base_product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'schedule_inv'); ?>
		<?php echo $form->textField($model,'schedule_inv',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'schedule_inv'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'present_inv'); ?>
		<?php echo $form->textField($model,'present_inv',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'present_inv'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wastage'); ?>
		<?php echo $form->textField($model,'wastage',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'wastage'); ?>
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