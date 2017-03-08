<?php
/* @var $this InventoryHeaderController */
/* @var $data InventoryHeader */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('warehouse_id')); ?>:</b>
	<?php echo CHtml::encode($data->warehouse_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('base_product_id')); ?>:</b>
	<?php echo CHtml::encode($data->base_product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('schedule_inv')); ?>:</b>
	<?php echo CHtml::encode($data->schedule_inv); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('schedule_inv_type')); ?>:</b>
	<?php echo CHtml::encode($data->schedule_inv_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('extra_inv')); ?>:</b>
	<?php echo CHtml::encode($data->extra_inv); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('extra_inv_type')); ?>:</b>
	<?php echo CHtml::encode($data->extra_inv_type); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>