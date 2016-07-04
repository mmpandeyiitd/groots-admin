<?php
/* @var $this OrderLineController */
/* @var $data OrderLine */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_id')); ?>:</b>
	<?php echo CHtml::encode($data->order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subscribed_product_id')); ?>:</b>
	<?php echo CHtml::encode($data->subscribed_product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('base_product_id')); ?>:</b>
	<?php echo CHtml::encode($data->base_product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_id')); ?>:</b>
	<?php echo CHtml::encode($data->store_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_name')); ?>:</b>
	<?php echo CHtml::encode($data->store_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_email')); ?>:</b>
	<?php echo CHtml::encode($data->store_email); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('store_front_id')); ?>:</b>
	<?php echo CHtml::encode($data->store_front_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_front_name')); ?>:</b>
	<?php echo CHtml::encode($data->store_front_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('seller_name')); ?>:</b>
	<?php echo CHtml::encode($data->seller_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('seller_phone')); ?>:</b>
	<?php echo CHtml::encode($data->seller_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('seller_address')); ?>:</b>
	<?php echo CHtml::encode($data->seller_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('seller_state')); ?>:</b>
	<?php echo CHtml::encode($data->seller_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('seller_city')); ?>:</b>
	<?php echo CHtml::encode($data->seller_city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('colour')); ?>:</b>
	<?php echo CHtml::encode($data->colour); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('size')); ?>:</b>
	<?php echo CHtml::encode($data->size); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_name')); ?>:</b>
	<?php echo CHtml::encode($data->product_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_qty')); ?>:</b>
	<?php echo CHtml::encode($data->product_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_price')); ?>:</b>
	<?php echo CHtml::encode($data->unit_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	*/ ?>

</div>