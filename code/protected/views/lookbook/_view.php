<?php
/* @var $this LookbookController */
/* @var $data Lookbook */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store_id')); ?>:</b>
	<?php echo CHtml::encode($data->store_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('headline')); ?>:</b>
	<?php echo CHtml::encode($data->headline); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('main_img_url')); ?>:</b>
	<?php echo CHtml::encode($data->main_img_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('thumb_url')); ?>:</b>
	<?php echo CHtml::encode($data->thumb_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('org_img_url')); ?>:</b>
	<?php echo CHtml::encode($data->org_img_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pdf_url')); ?>:</b>
	<?php echo CHtml::encode($data->pdf_url); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	*/ ?>

</div>