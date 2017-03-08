<?php
/* @var $this BaseProductController */
/* @var $data BaseProduct */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('base_product_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->base_product_id), array('view', 'id'=>$data->base_product_id)); ?>
	<br />

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('small_description')); ?>:</b>
	<?php //echo CHtml::encode($data->small_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('color')); ?>:</b>
	<?php echo CHtml::encode($data->color); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('size')); ?>:</b>
	<?php echo CHtml::encode($data->size); ?>
	<br />
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('image')); ?>:</b>
	<?php echo CHtml::encode($data->image); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('product_weight')); ?>:</b>
	<?php echo CHtml::encode($data->product_weight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('brand')); ?>:</b>
	<?php echo CHtml::encode($data->brand); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('model_name')); ?>:</b>
	<?php echo CHtml::encode($data->model_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('model_number')); ?>:</b>
	<?php echo CHtml::encode($data->model_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacture')); ?>:</b>
	<?php echo CHtml::encode($data->manufacture); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacture_country')); ?>:</b>
	<?php echo CHtml::encode($data->manufacture_country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacture_year')); ?>:</b>
	<?php echo CHtml::encode($data->manufacture_year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('specifications')); ?>:</b>
	<?php echo CHtml::encode($data->specifications); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('key_features')); ?>:</b>
	<?php echo CHtml::encode($data->key_features); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meta_title')); ?>:</b>
	<?php echo CHtml::encode($data->meta_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meta_keyword')); ?>:</b>
	<?php echo CHtml::encode($data->meta_keyword); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meta_description')); ?>:</b>
	<?php echo CHtml::encode($data->meta_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('average_rating')); ?>:</b>
	<?php echo CHtml::encode($data->average_rating); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('other_website_rating')); ?>:</b>
	<?php echo CHtml::encode($data->other_website_rating); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_configurable')); ?>:</b>
	<?php echo CHtml::encode($data->is_configurable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('configurable_with')); ?>:</b>
	<?php echo CHtml::encode($data->configurable_with); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_date')); ?>:</b>
	<?php echo CHtml::encode($data->modified_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campaign_id')); ?>:</b>
	<?php echo CHtml::encode($data->campaign_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_deleted')); ?>:</b>
	<?php echo CHtml::encode($data->is_deleted); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_serial_required')); ?>:</b>
	<?php echo CHtml::encode($data->is_serial_required); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_content_type')); ?>:</b>
	<?php echo CHtml::encode($data->product_content_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ISBN')); ?>:</b>
	<?php echo CHtml::encode($data->ISBN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_shipping_charge')); ?>:</b>
	<?php echo CHtml::encode($data->product_shipping_charge); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('video_url')); ?>:</b>
	<?php echo CHtml::encode($data->video_url); ?>
	<br />

	*/ ?>
        <?php echo'<br />';?>

</div>