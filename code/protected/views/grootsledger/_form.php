<?php
/* @var $this GrootsledgerController */
/* @var $model Grootsledger */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'grootsledger-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'order_id'); ?>
		<?php echo $form->textField($model,'order_id'); ?>
		<?php echo $form->error($model,'order_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_number'); ?>
		<?php echo $form->textField($model,'order_number',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'order_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'agent_name'); ?>
		<?php echo $form->textField($model,'agent_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'agent_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_payable_amount'); ?>
		<?php echo $form->textField($model,'total_payable_amount',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'total_payable_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'MIN_DUE_AMOUNT'); ?>
		<?php echo $form->textField($model,'MIN_DUE_AMOUNT'); ?>
		<?php echo $form->error($model,'MIN_DUE_AMOUNT'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Max_id'); ?>
		<?php echo $form->textField($model,'Max_id'); ?>
		<?php echo $form->error($model,'Max_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->