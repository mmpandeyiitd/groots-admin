<?php
/* @var $this StorelocatinController */
/* @var $model Storelocatin */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'store_id'); ?>
		<?php echo $form->textField($model,'store_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'getit_store_id'); ?>
		<?php echo $form->textField($model,'getit_store_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'store_code'); ?>
		<?php echo $form->textField($model,'store_code',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'store_name'); ?>
		<?php echo $form->textField($model,'store_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'store_details'); ?>
		<?php echo $form->textArea($model,'store_details',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'store_logo'); ?>
		<?php echo $form->textField($model,'store_logo',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'seller_name'); ?>
		<?php echo $form->textField($model,'seller_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'business_address'); ?>
		<?php echo $form->textField($model,'business_address',array('size'=>60,'maxlength'=>300)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'business_address_country'); ?>
		<?php echo $form->textField($model,'business_address_country',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'business_address_state'); ?>
		<?php echo $form->textField($model,'business_address_state',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'business_address_city'); ?>
		<?php echo $form->textField($model,'business_address_city',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'business_address_pincode'); ?>
		<?php echo $form->textField($model,'business_address_pincode',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lat'); ?>
		<?php echo $form->textField($model,'lat'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'long'); ?>
		<?php echo $form->textField($model,'long'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mobile_numbers'); ?>
		<?php echo $form->textField($model,'mobile_numbers',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'telephone_numbers'); ?>
		<?php echo $form->textField($model,'telephone_numbers',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visible'); ?>
		<?php echo $form->textField($model,'visible'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'meta_title'); ?>
		<?php echo $form->textField($model,'meta_title',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'meta_keywords'); ?>
		<?php echo $form->textField($model,'meta_keywords',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'meta_description'); ?>
		<?php echo $form->textField($model,'meta_description',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'customer_value'); ?>
		<?php echo $form->textField($model,'customer_value',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'chat_id'); ?>
		<?php echo $form->textField($model,'chat_id',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vtiger_status'); ?>
		<?php echo $form->textField($model,'vtiger_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vtiger_accountid'); ?>
		<?php echo $form->textField($model,'vtiger_accountid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modified_date'); ?>
		<?php echo $form->textField($model,'modified_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_deleted'); ?>
		<?php echo $form->textField($model,'is_deleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tagline'); ?>
		<?php echo $form->textField($model,'tagline',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_tagline'); ?>
		<?php echo $form->textField($model,'is_tagline'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'store_api_key'); ?>
		<?php echo $form->textField($model,'store_api_key',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'redirect_url'); ?>
		<?php echo $form->textArea($model,'redirect_url',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'seller_mailer_flag'); ?>
		<?php echo $form->textField($model,'seller_mailer_flag'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'buyer_mailer_flag'); ?>
		<?php echo $form->textField($model,'buyer_mailer_flag'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'channel_name'); ?>
		<?php echo $form->textField($model,'channel_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'channel_id'); ?>
		<?php echo $form->textField($model,'channel_id',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_prefix'); ?>
		<?php echo $form->textField($model,'order_prefix',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_active_valid'); ?>
		<?php echo $form->textField($model,'is_active_valid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'store_shipping_charge'); ?>
		<?php echo $form->textField($model,'store_shipping_charge'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'store_tax_per'); ?>
		<?php echo $form->textField($model,'store_tax_per'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'location'); ?>
		<?php echo $form->textArea($model,'location',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->