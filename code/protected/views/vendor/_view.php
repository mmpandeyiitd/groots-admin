<?php
/* @var $this VendorController */
/* @var $data Vendor */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>

	<?php echo CHtml::button('Update', array('submit'=>$this->createUrl('vendor/update&id='.$data->id), 'style' => 'align:right;', 'target' => '_blank'));?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vendor_code')); ?>:</b>
	<?php echo CHtml::encode($data->vendor_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('VAT_number')); ?>:</b>
	<?php echo CHtml::encode($data->VAT_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile')); ?>:</b>
	<?php echo CHtml::encode($data->mobile); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('telephone')); ?>:</b>
	<?php echo CHtml::encode($data->telephone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pincode')); ?>:</b>
	<?php echo CHtml::encode($data->pincode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('owner_phone')); ?>:</b>
	<?php echo CHtml::encode($data->owner_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('owner_email')); ?>:</b>
	<?php echo CHtml::encode($data->owner_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('settlement_days')); ?>:</b>
	<?php echo CHtml::encode($data->settlement_days); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_of_delivery')); ?>:</b>
	<?php echo CHtml::encode($data->time_of_delivery); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_of_onboarding')); ?>:</b>
	<?php echo CHtml::encode($data->date_of_onboarding); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
	<?php echo CHtml::encode($data->city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state')); ?>:</b>
	<?php echo CHtml::encode($data->state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image')); ?>:</b>
	<?php echo CHtml::encode($data->image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image_url')); ?>:</b>
	<?php echo CHtml::encode($data->image_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('website')); ?>:</b>
	<?php echo CHtml::encode($data->website); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_person1')); ?>:</b>
	<?php echo CHtml::encode($data->contact_person1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_person2')); ?>:</b>
	<?php echo CHtml::encode($data->contact_person2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('credit_limit')); ?>:</b>
	<?php echo CHtml::encode($data->credit_limit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allocated_warehouse_id')); ?>:</b>
	<?php echo CHtml::encode($data->allocated_warehouse_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('initial_pending_amount')); ?>:</b>
	<?php echo CHtml::encode($data->initial_pending_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_pending_amount')); ?>:</b>
	<?php echo CHtml::encode($data->total_pending_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bussiness_name')); ?>:</b>
	<?php echo CHtml::encode($data->bussiness_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_terms')); ?>:</b>
	<?php echo CHtml::encode($data->payment_terms); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('proc_exec_id')); ?>:</b>
	<?php echo CHtml::encode($data->proc_exec_id); ?>
	<br />

	*/ ?>

</div>