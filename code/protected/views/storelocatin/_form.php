<?php
/* @var $this StorelocatinController */
/* @var $model Storelocatin */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'storelocatin-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'store_id'); ?>
		<?php echo $form->textField($model,'store_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'store_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'getit_store_id'); ?>
		<?php echo $form->textField($model,'getit_store_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'getit_store_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_code'); ?>
		<?php echo $form->textField($model,'store_code',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'store_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_name'); ?>
		<?php echo $form->textField($model,'store_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'store_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_details'); ?>
		<?php echo $form->textArea($model,'store_details',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'store_details'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_logo'); ?>
		<?php echo $form->textField($model,'store_logo',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'store_logo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'seller_name'); ?>
		<?php echo $form->textField($model,'seller_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'seller_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'business_address'); ?>
		<?php echo $form->textField($model,'business_address',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'business_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'business_address_country'); ?>
		<?php echo $form->textField($model,'business_address_country',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'business_address_country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'business_address_state'); ?>
		<?php echo $form->textField($model,'business_address_state',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'business_address_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'business_address_city'); ?>
		<?php echo $form->textField($model,'business_address_city',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'business_address_city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'business_address_pincode'); ?>
		<?php echo $form->textField($model,'business_address_pincode',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'business_address_pincode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lat'); ?>
		<?php echo $form->textField($model,'lat'); ?>
		<?php echo $form->error($model,'lat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'long'); ?>
		<?php echo $form->textField($model,'long'); ?>
		<?php echo $form->error($model,'long'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mobile_numbers'); ?>
		<?php echo $form->textField($model,'mobile_numbers',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'mobile_numbers'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telephone_numbers'); ?>
		<?php echo $form->textField($model,'telephone_numbers',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'telephone_numbers'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visible'); ?>
		<?php echo $form->textField($model,'visible'); ?>
		<?php echo $form->error($model,'visible'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'meta_title'); ?>
		<?php echo $form->textField($model,'meta_title',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'meta_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'meta_keywords'); ?>
		<?php echo $form->textField($model,'meta_keywords',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'meta_keywords'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'meta_description'); ?>
		<?php echo $form->textField($model,'meta_description',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'meta_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_value'); ?>
		<?php echo $form->textField($model,'customer_value',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'customer_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'chat_id'); ?>
		<?php echo $form->textField($model,'chat_id',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'chat_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vtiger_status'); ?>
		<?php echo $form->textField($model,'vtiger_status'); ?>
		<?php echo $form->error($model,'vtiger_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vtiger_accountid'); ?>
		<?php echo $form->textField($model,'vtiger_accountid'); ?>
		<?php echo $form->error($model,'vtiger_accountid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified_date'); ?>
		<?php echo $form->textField($model,'modified_date'); ?>
		<?php echo $form->error($model,'modified_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_deleted'); ?>
		<?php echo $form->textField($model,'is_deleted'); ?>
		<?php echo $form->error($model,'is_deleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tagline'); ?>
		<?php echo $form->textField($model,'tagline',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'tagline'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_tagline'); ?>
		<?php echo $form->textField($model,'is_tagline'); ?>
		<?php echo $form->error($model,'is_tagline'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_api_key'); ?>
		<?php echo $form->textField($model,'store_api_key',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'store_api_key'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_api_password'); ?>
		<?php echo $form->textField($model,'store_api_password',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'store_api_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'redirect_url'); ?>
		<?php echo $form->textArea($model,'redirect_url',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'redirect_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'seller_mailer_flag'); ?>
		<?php echo $form->textField($model,'seller_mailer_flag'); ?>
		<?php echo $form->error($model,'seller_mailer_flag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'buyer_mailer_flag'); ?>
		<?php echo $form->textField($model,'buyer_mailer_flag'); ?>
		<?php echo $form->error($model,'buyer_mailer_flag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'channel_name'); ?>
		<?php echo $form->textField($model,'channel_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'channel_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'channel_id'); ?>
		<?php echo $form->textField($model,'channel_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'channel_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_prefix'); ?>
		<?php echo $form->textField($model,'order_prefix',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'order_prefix'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_active_valid'); ?>
		<?php echo $form->textField($model,'is_active_valid'); ?>
		<?php echo $form->error($model,'is_active_valid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_shipping_charge'); ?>
		<?php echo $form->textField($model,'store_shipping_charge'); ?>
		<?php echo $form->error($model,'store_shipping_charge'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_tax_per'); ?>
		<?php echo $form->textField($model,'store_tax_per'); ?>
		<?php echo $form->error($model,'store_tax_per'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->textArea($model,'location',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'location'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->