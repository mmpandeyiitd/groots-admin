<?php
/* @var $this OrderHeaderController */
/* @var $data OrderHeader */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->order_id), array('view', 'id'=>$data->order_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_number')); ?>:</b>
	<?php echo CHtml::encode($data->order_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_method')); ?>:</b>
	<?php echo CHtml::encode($data->payment_method); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_status')); ?>:</b>
	<?php echo CHtml::encode($data->payment_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('billing_name')); ?>:</b>
	<?php echo CHtml::encode($data->billing_name); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('billing_phone')); ?>:</b>
	<?php echo CHtml::encode($data->billing_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('billing_email')); ?>:</b>
	<?php echo CHtml::encode($data->billing_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('billing_address')); ?>:</b>
	<?php echo CHtml::encode($data->billing_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('billing_state')); ?>:</b>
	<?php echo CHtml::encode($data->billing_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('billing_city')); ?>:</b>
	<?php echo CHtml::encode($data->billing_city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('billing_pincode')); ?>:</b>
	<?php echo CHtml::encode($data->billing_pincode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_name')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_phone')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_email')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_address')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_state')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_city')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_pincode')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_pincode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_charges')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_charges); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total')); ?>:</b>
	<?php echo CHtml::encode($data->total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_payable_amount')); ?>:</b>
	<?php echo CHtml::encode($data->total_payable_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_paid_amount')); ?>:</b>
	<?php echo CHtml::encode($data->total_paid_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount_amt')); ?>:</b>
	<?php echo CHtml::encode($data->discount_amt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coupon_code')); ?>:</b>
	<?php echo CHtml::encode($data->coupon_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_ref_id')); ?>:</b>
	<?php echo CHtml::encode($data->payment_ref_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_gateway_name')); ?>:</b>
	<?php echo CHtml::encode($data->payment_gateway_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_source')); ?>:</b>
	<?php echo CHtml::encode($data->payment_source); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_source')); ?>:</b>
	<?php echo CHtml::encode($data->order_source); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->timestamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_id')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bank_transaction_id')); ?>:</b>
	<?php echo CHtml::encode($data->bank_transaction_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_time')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_mod')); ?>:</b>
	<?php echo CHtml::encode($data->payment_mod); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bankname')); ?>:</b>
	<?php echo CHtml::encode($data->bankname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cron_processed_flag')); ?>:</b>
	<?php echo CHtml::encode($data->cron_processed_flag); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source_url')); ?>:</b>
	<?php echo CHtml::encode($data->source_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source_type')); ?>:</b>
	<?php echo CHtml::encode($data->source_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source_id')); ?>:</b>
	<?php echo CHtml::encode($data->source_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source_name')); ?>:</b>
	<?php echo CHtml::encode($data->source_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campaign_id')); ?>:</b>
	<?php echo CHtml::encode($data->campaign_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('buyer_shipping_cost')); ?>:</b>
	<?php echo CHtml::encode($data->buyer_shipping_cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_type')); ?>:</b>
	<?php echo CHtml::encode($data->order_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('utm_source')); ?>:</b>
	<?php echo CHtml::encode($data->utm_source); ?>
	<br />

	*/ ?>

</div>