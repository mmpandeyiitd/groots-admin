<?php
/* @var $this SubscribedProductController */
/* @var $data SubscribedProduct */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('subscribed_product_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->subscribed_product_id), array('view', 'id'=>$data->subscribed_product_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('base_product_id')); ?>:</b>
	<?php echo CHtml::encode($data->base_product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_id')); ?>:</b>
	<?php echo CHtml::encode($data->store_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_price')); ?>:</b>
	<?php echo CHtml::encode($data->store_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_offer_price')); ?>:</b>
	<?php echo CHtml::encode($data->store_offer_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('weight')); ?>:</b>
	<?php echo CHtml::encode($data->weight); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('length')); ?>:</b>
	<?php echo CHtml::encode($data->length); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('width')); ?>:</b>
	<?php echo CHtml::encode($data->width); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('height')); ?>:</b>
	<?php echo CHtml::encode($data->height); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('warranty')); ?>:</b>
	<?php echo CHtml::encode($data->warranty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prompt')); ?>:</b>
	<?php echo CHtml::encode($data->prompt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prompt_key')); ?>:</b>
	<?php echo CHtml::encode($data->prompt_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checkout_url')); ?>:</b>
	<?php echo CHtml::encode($data->checkout_url); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('sku')); ?>:</b>
	<?php echo CHtml::encode($data->sku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_cod')); ?>:</b>
	<?php echo CHtml::encode($data->is_cod); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subscribe_shipping_charge')); ?>:</b>
	<?php echo CHtml::encode($data->subscribe_shipping_charge); ?>
	<br />

	*/ ?>
        <?php echo '<br>'; ?>

</div>