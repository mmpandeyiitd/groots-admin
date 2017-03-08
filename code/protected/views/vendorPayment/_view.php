<?php
/* @var $this VendorPaymentController */
/* @var $data VendorPayment */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vendor_id')); ?>:</b>
	<?php echo CHtml::encode($data->vendor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paid_amount')); ?>:</b>
	<?php echo CHtml::encode($data->paid_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_type')); ?>:</b>
	<?php echo CHtml::encode($data->payment_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cheque_no')); ?>:</b>
	<?php echo CHtml::encode($data->cheque_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('debit_no')); ?>:</b>
	<?php echo CHtml::encode($data->debit_no); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('cheque_status')); ?>:</b>
	<?php echo CHtml::encode($data->cheque_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cheque_issue_date')); ?>:</b>
	<?php echo CHtml::encode($data->cheque_issue_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cheque_name')); ?>:</b>
	<?php echo CHtml::encode($data->cheque_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_id')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receiving_acc_no')); ?>:</b>
	<?php echo CHtml::encode($data->receiving_acc_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bank_name')); ?>:</b>
	<?php echo CHtml::encode($data->bank_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isfc_code')); ?>:</b>
	<?php echo CHtml::encode($data->isfc_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acc_holder_name')); ?>:</b>
	<?php echo CHtml::encode($data->acc_holder_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>