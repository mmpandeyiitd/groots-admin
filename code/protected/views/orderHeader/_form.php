<?php
/* @var $this OrderHeaderController */
/* @var $model OrderHeader */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-header-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

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
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_method'); ?>
		<?php echo $form->textField($model,'payment_method',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'payment_method'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_status'); ?>
		<?php echo $form->textField($model,'payment_status',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'payment_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'billing_name'); ?>
		<?php echo $form->textField($model,'billing_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'billing_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'billing_phone'); ?>
		<?php echo $form->textField($model,'billing_phone',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'billing_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'billing_email'); ?>
		<?php echo $form->textField($model,'billing_email',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'billing_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'billing_address'); ?>
		<?php echo $form->textArea($model,'billing_address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'billing_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'billing_state'); ?>
		<?php echo $form->textField($model,'billing_state',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'billing_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'billing_city'); ?>
		<?php echo $form->textField($model,'billing_city',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'billing_city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'billing_pincode'); ?>
		<?php echo $form->textField($model,'billing_pincode',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'billing_pincode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_name'); ?>
		<?php echo $form->textField($model,'shipping_name',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'shipping_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_phone'); ?>
		<?php echo $form->textField($model,'shipping_phone',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'shipping_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_email'); ?>
		<?php echo $form->textField($model,'shipping_email',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'shipping_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_address'); ?>
		<?php echo $form->textArea($model,'shipping_address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'shipping_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_state'); ?>
		<?php echo $form->textField($model,'shipping_state',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'shipping_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_city'); ?>
		<?php echo $form->textField($model,'shipping_city',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'shipping_city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_pincode'); ?>
		<?php echo $form->textField($model,'shipping_pincode',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'shipping_pincode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_charges'); ?>
		<?php echo $form->textField($model,'shipping_charges',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'shipping_charges'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total'); ?>
		<?php echo $form->textField($model,'total',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_payable_amount'); ?>
		<?php echo $form->textField($model,'total_payable_amount',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'total_payable_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_paid_amount'); ?>
		<?php echo $form->textField($model,'total_paid_amount',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'total_paid_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount_amt'); ?>
		<?php echo $form->textField($model,'discount_amt',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'discount_amt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'coupon_code'); ?>
		<?php echo $form->textField($model,'coupon_code',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'coupon_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_ref_id'); ?>
		<?php echo $form->textField($model,'payment_ref_id',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'payment_ref_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_gateway_name'); ?>
		<?php echo $form->textField($model,'payment_gateway_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'payment_gateway_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_source'); ?>
		<?php echo $form->textField($model,'payment_source',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'payment_source'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_source'); ?>
		<?php echo $form->textField($model,'order_source',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'order_source'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timestamp'); ?>
		<?php echo $form->textField($model,'timestamp'); ?>
		<?php echo $form->error($model,'timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transaction_id'); ?>
		<?php echo $form->textField($model,'transaction_id',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'transaction_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bank_transaction_id'); ?>
		<?php echo $form->textField($model,'bank_transaction_id',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'bank_transaction_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transaction_time'); ?>
		<?php echo $form->textField($model,'transaction_time'); ?>
		<?php echo $form->error($model,'transaction_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_mod'); ?>
		<?php echo $form->textField($model,'payment_mod',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'payment_mod'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bankname'); ?>
		<?php echo $form->textField($model,'bankname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'bankname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cron_processed_flag'); ?>
		<?php echo $form->textField($model,'cron_processed_flag',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'cron_processed_flag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source_url'); ?>
		<?php echo $form->textArea($model,'source_url',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'source_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source_type'); ?>
		<?php echo $form->textField($model,'source_type',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'source_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source_id'); ?>
		<?php echo $form->textField($model,'source_id'); ?>
		<?php echo $form->error($model,'source_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source_name'); ?>
		<?php echo $form->textField($model,'source_name',array('size'=>60,'maxlength'=>254)); ?>
		<?php echo $form->error($model,'source_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'campaign_id'); ?>
		<?php echo $form->textField($model,'campaign_id'); ?>
		<?php echo $form->error($model,'campaign_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'buyer_shipping_cost'); ?>
		<?php echo $form->textField($model,'buyer_shipping_cost'); ?>
		<?php echo $form->error($model,'buyer_shipping_cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_type'); ?>
		<?php echo $form->textField($model,'order_type',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'order_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'utm_source'); ?>
		<?php echo $form->textField($model,'utm_source',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'utm_source'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->