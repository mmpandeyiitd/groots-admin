<?php
/* @var $this VendorPaymentController */
/* @var $model VendorPayment */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vendor-payment-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($vendor,'name'); ?>
		<?php echo $form->textField($vendor,'name',array('size'=>60,'maxlength'=>255, 'readOnly' => 'readOnly')); ?>
		<?php echo $form->error($vendor,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vendor_id'); ?>
		<?php echo $form->textField($vendor,'id', array('readOnly' => 'readOnly')); ?>
		<?php echo $form->error($model,'vendor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'paid_amount'); ?>
		<?php echo $form->textField($model,'paid_amount',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'paid_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'attribute'=>'date',

            'id'=>'date',
            //'value'=> date('Y-m-d'),
            'options'=>array(
                'dateFormat' => 'yy-mm-dd',
                'showAnim'=>'fold',
            ),
            'htmlOptions'=>array(
                'style'=>'height:20px;'
            ),
        )); ?>
        <?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_type'); ?>
		<?php echo $form->dropDownList($model,'payment_type',
            CHtml::listData(VendorPayment::vendorPaymentTypes(),'value', 'value'),
            array('options' => array($model->payment_type=>array('selected'=>true)),'style' => 'width:220.5px;'));
        ?>
		<?php echo $form->error($model,'payment_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cheque_no'); ?>
		<?php echo $form->textField($model,'cheque_no',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'cheque_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'debit_no'); ?>
		<?php echo $form->textField($model,'debit_no',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'debit_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cheque_status'); ?>
		<?php echo $form->dropDownList($model,'cheque_status',
            CHtml::listData(VendorPayment::getChequeStatus(),'value', 'value'),
            array('empty' => 'Select a Status', 'style' => 'width:220.5px;'));
        ?>
		<?php echo $form->error($model,'cheque_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model, 'status' , array('1' => 'Active' , '0' => 'Inactive'), 
			 array('options' => array($model->status=>array('selected'=>true)), 'style' => 'width:220.5px;')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<?php if($update){ ?>
	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>
	<?php } ?>

	<!-- <div class="row">
		<?php echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
		<?php echo $form->error($model,'updated_at'); ?>
	</div> -->


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->