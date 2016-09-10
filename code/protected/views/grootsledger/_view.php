<?php
/* @var $this GrootsledgerController */
/* @var $data Grootsledger */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Max_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Max_id), array('view', 'id'=>$data->Max_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_id')); ?>:</b>
	<?php echo CHtml::encode($data->order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_number')); ?>:</b>
	<?php echo CHtml::encode($data->order_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agent_name')); ?>:</b>
	<?php echo CHtml::encode($data->agent_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_payable_amount')); ?>:</b>
	<?php echo CHtml::encode($data->total_payable_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MIN_DUE_AMOUNT')); ?>:</b>
	<?php echo CHtml::encode($data->MIN_DUE_AMOUNT); ?>
	<br />


</div>