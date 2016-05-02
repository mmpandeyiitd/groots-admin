<?php
/* @var $this RetailerProductQuotationController */
/* @var $data RetailerProductQuotation */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('retailer_id')); ?>:</b>
	<?php echo CHtml::encode($data->retailer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subscribed_product_id')); ?>:</b>
	<?php echo CHtml::encode($data->subscribed_product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('effective_price')); ?>:</b>
	<?php echo CHtml::encode($data->effective_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discout_per')); ?>:</b>
	<?php echo CHtml::encode($data->discout_per); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />


</div>