<?php
/* @var $this InventoryController */
/* @var $data Inventory */
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('present_inv')); ?>:</b>
	<?php echo CHtml::encode($data->present_inv); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wastage')); ?>:</b>
	<?php echo CHtml::encode($data->wastage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>