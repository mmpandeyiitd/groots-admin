<?php
/* @var $this StorelocatinController */
/* @var $data Storelocatin */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->store_id), array('view', 'id'=>$data->store_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('getit_store_id')); ?>:</b>
	<?php echo CHtml::encode($data->getit_store_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_code')); ?>:</b>
	<?php echo CHtml::encode($data->store_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_name')); ?>:</b>
	<?php echo CHtml::encode($data->store_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_details')); ?>:</b>
	<?php echo CHtml::encode($data->store_details); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_logo')); ?>:</b>
	<?php echo CHtml::encode($data->store_logo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('seller_name')); ?>:</b>
	<?php echo CHtml::encode($data->seller_name); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('business_address')); ?>:</b>
	<?php echo CHtml::encode($data->business_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('business_address_country')); ?>:</b>
	<?php echo CHtml::encode($data->business_address_country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('business_address_state')); ?>:</b>
	<?php echo CHtml::encode($data->business_address_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('business_address_city')); ?>:</b>
	<?php echo CHtml::encode($data->business_address_city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('business_address_pincode')); ?>:</b>
	<?php echo CHtml::encode($data->business_address_pincode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lat')); ?>:</b>
	<?php echo CHtml::encode($data->lat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('long')); ?>:</b>
	<?php echo CHtml::encode($data->long); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile_numbers')); ?>:</b>
	<?php echo CHtml::encode($data->mobile_numbers); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telephone_numbers')); ?>:</b>
	<?php echo CHtml::encode($data->telephone_numbers); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visible')); ?>:</b>
	<?php echo CHtml::encode($data->visible); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meta_title')); ?>:</b>
	<?php echo CHtml::encode($data->meta_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meta_keywords')); ?>:</b>
	<?php echo CHtml::encode($data->meta_keywords); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meta_description')); ?>:</b>
	<?php echo CHtml::encode($data->meta_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_value')); ?>:</b>
	<?php echo CHtml::encode($data->customer_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chat_id')); ?>:</b>
	<?php echo CHtml::encode($data->chat_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vtiger_status')); ?>:</b>
	<?php echo CHtml::encode($data->vtiger_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vtiger_accountid')); ?>:</b>
	<?php echo CHtml::encode($data->vtiger_accountid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_date')); ?>:</b>
	<?php echo CHtml::encode($data->modified_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_deleted')); ?>:</b>
	<?php echo CHtml::encode($data->is_deleted); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tagline')); ?>:</b>
	<?php echo CHtml::encode($data->tagline); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_tagline')); ?>:</b>
	<?php echo CHtml::encode($data->is_tagline); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_api_key')); ?>:</b>
	<?php echo CHtml::encode($data->store_api_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_api_password')); ?>:</b>
	<?php echo CHtml::encode($data->store_api_password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('redirect_url')); ?>:</b>
	<?php echo CHtml::encode($data->redirect_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('seller_mailer_flag')); ?>:</b>
	<?php echo CHtml::encode($data->seller_mailer_flag); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('buyer_mailer_flag')); ?>:</b>
	<?php echo CHtml::encode($data->buyer_mailer_flag); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('channel_name')); ?>:</b>
	<?php echo CHtml::encode($data->channel_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('channel_id')); ?>:</b>
	<?php echo CHtml::encode($data->channel_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_prefix')); ?>:</b>
	<?php echo CHtml::encode($data->order_prefix); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active_valid')); ?>:</b>
	<?php echo CHtml::encode($data->is_active_valid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_shipping_charge')); ?>:</b>
	<?php echo CHtml::encode($data->store_shipping_charge); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_tax_per')); ?>:</b>
	<?php echo CHtml::encode($data->store_tax_per); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($data->location); ?>
	<br />

	*/ ?>

</div>