<?php
/* @var $this OrderLineController */
/* @var $model OrderLine */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-line-form',
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
		<?php echo $form->labelEx($model,'subscribed_product_id'); ?>
		<?php echo $form->textField($model,'subscribed_product_id'); ?>
		<?php echo $form->error($model,'subscribed_product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'base_product_id'); ?>
		<?php echo $form->textField($model,'base_product_id'); ?>
		<?php echo $form->error($model,'base_product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_id'); ?>
		<?php echo $form->textField($model,'store_id'); ?>
		<?php echo $form->error($model,'store_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_name'); ?>
		<?php echo $form->textField($model,'store_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'store_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_email'); ?>
		<?php echo $form->textField($model,'store_email',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'store_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_front_id'); ?>
		<?php echo $form->textField($model,'store_front_id'); ?>
		<?php echo $form->error($model,'store_front_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_front_name'); ?>
		<?php echo $form->textField($model,'store_front_name',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'store_front_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'seller_name'); ?>
		<?php echo $form->textField($model,'seller_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'seller_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'seller_phone'); ?>
		<?php echo $form->textField($model,'seller_phone',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'seller_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'seller_address'); ?>
		<?php echo $form->textArea($model,'seller_address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'seller_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'seller_state'); ?>
		<?php echo $form->textField($model,'seller_state',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'seller_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'seller_city'); ?>
		<?php echo $form->textField($model,'seller_city',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'seller_city'); ?>
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
		<?php echo $form->labelEx($model,'product_name'); ?>
		<?php echo $form->textField($model,'product_name',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'product_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_qty'); ?>
		<?php echo $form->textField($model,'product_qty'); ?>
		<?php echo $form->error($model,'product_qty'); ?>
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
        <?php echo $form->textField($model,'status',array('size'=>10,'maxlength'=>10)); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->