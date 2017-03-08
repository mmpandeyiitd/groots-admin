<?php
/* @var $this TransferLineController */
/* @var $data TransferLine */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transfer_id')); ?>:</b>
	<?php echo CHtml::encode($data->transfer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('base_product_id')); ?>:</b>
	<?php echo CHtml::encode($data->base_product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('colour')); ?>:</b>
	<?php echo CHtml::encode($data->colour); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('size')); ?>:</b>
	<?php echo CHtml::encode($data->size); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grade')); ?>:</b>
	<?php echo CHtml::encode($data->grade); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('diameter')); ?>:</b>
	<?php echo CHtml::encode($data->diameter); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('pack_size')); ?>:</b>
	<?php echo CHtml::encode($data->pack_size); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pack_unit')); ?>:</b>
	<?php echo CHtml::encode($data->pack_unit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('weight')); ?>:</b>
	<?php echo CHtml::encode($data->weight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('weight_unit')); ?>:</b>
	<?php echo CHtml::encode($data->weight_unit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('length')); ?>:</b>
	<?php echo CHtml::encode($data->length); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('length_unit')); ?>:</b>
	<?php echo CHtml::encode($data->length_unit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_qty')); ?>:</b>
	<?php echo CHtml::encode($data->order_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivered_qty')); ?>:</b>
	<?php echo CHtml::encode($data->delivered_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('received_qty')); ?>:</b>
	<?php echo CHtml::encode($data->received_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_price')); ?>:</b>
	<?php echo CHtml::encode($data->unit_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>