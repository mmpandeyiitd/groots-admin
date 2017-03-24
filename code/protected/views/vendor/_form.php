<?php
/* @var $this VendorController */
/* @var $model Vendor */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vendor-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>
 	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model);?>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bussiness_name'); ?>
		<?php echo $form->textField($model,'bussiness_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'bussiness_name'); ?>
	</div>

	<!-- <div class="row">
		<?php //echo $form->labelEx($model,'vendor_code'); ?>
		<?php //echo $form->textField($model,'vendor_code',array('size'=>10,'maxlength'=>10)); ?>
		<?php //echo $form->error($model,'vendor_code'); ?>
	</div>
 -->
 	<div class="row">
		<?php echo $form->labelEx($model,'vendor_type'); ?>
		<?php echo CHtml::activeDropDownList($model	, 'vendor_type', VendorDao::getVendorTypeDropdownData(), array('options' => array($model->vendor_type=>array('selected'=>true)), 'style' => 'width:220.5px;')); ?>
		<?php echo $form->error($model,'vendor_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'supplier_type'); ?>
		<?php echo CHtml::activeDropDownList($model	, 'supplier_type', VendorDao::getVendorSupplyTypeDropdown(), array('options' => array($model->vendor_type=>array('selected'=>true)), 'style' => 'width:220.5px;')); ?>
		<?php echo $form->error($model,'supplier_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'VAT_number'); ?>
		<?php echo $form->textField($model,'VAT_number',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'VAT_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mobile'); ?>
		<?php echo $form->textField($model,'mobile',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'mobile'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telephone'); ?>
		<?php echo $form->textField($model,'telephone',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'telephone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pincode'); ?>
		<?php echo $form->textField($model,'pincode',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'pincode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'owner_phone'); ?>
		<?php echo $form->textField($model,'owner_phone',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'owner_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'owner_email'); ?>
		<?php echo $form->textField($model,'owner_email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'owner_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'settlement_days'); ?>
		<?php echo $form->textField($model,'settlement_days',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'settlement_days'); ?>
	</div>

	<!-- <div class="row">
		<?php //echo $form->labelEx($model,'time_of_delivery'); ?>
		<?php //echo $form->textField($model,'time_of_delivery',array('size'=>60,'maxlength'=>255)); ?>
		<?php //echo $form->error($model,'time_of_delivery'); ?>
	</div> -->

	<div class="row">
		<?php echo $form->labelEx($model,'date_of_onboarding'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'attribute'=>'date_of_onboarding',

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
        <?php echo $form->error($model,'date_of_onboarding'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state'); ?>
		<?php echo $form->textField($model,'state',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->textField($model,'image',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image_url'); ?>
		<?php echo $form->textArea($model,'image_url',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'image_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'website'); ?>
		<?php echo $form->textField($model,'website',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'website'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_person1'); ?>
		<?php echo $form->textField($model,'contact_person1',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'contact_person1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_person2'); ?>
		<?php echo $form->textField($model,'contact_person2',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'contact_person2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_start_date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'attribute'=>'payment_start_date',

            'id'=>'payment_start_date',
            //'value'=> date('Y-m-d'),
            'options'=>array(
                'dateFormat' => 'yy-mm-dd',
                'showAnim'=>'fold',
            ),
            'htmlOptions'=>array(
                'style'=>'height:20px;'
            ),
        )); ?>
        <?php echo $form->error($model,'payment_start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_days_range'); ?>
		<?php echo $form->textField($model,'payment_days_range'); ?>
		<?php echo 'DAYS';?>
		<?php echo $form->error($model,'payment_days_range'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'credit_days'); ?>
		<?php echo $form->textField($model,'credit_days'); ?>
		<?php echo 'DAYS';?>
		<?php echo $form->error($model,'credit_days'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'due_date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'attribute'=>'due_date',

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
        <?php echo $form->error($model,'due_date'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'minimum_credit_amount *'); ?>
		<?php echo $form->textField($model,'credit_limit'); ?>
		<?php echo $form->error($model,'credit_limit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'proc_exec_id'); ?>
		<?php echo CHtml::activeDropDownList($model	, 'proc_exec_id', VendorDao::getProcExecutiveDropdownData(), array('options' => array($model->proc_exec_id=>array('selected'=>true)), 'style' => 'width:220.5px;')); ?>
		<?php echo $form->error($model,'proc_exec_id'); ?>
	</div>

	<!-- <div class="row">
		<?php //echo $form->labelEx($model,'created_date'); ?>
		<?php //echo $form->textField($model,'created_date'); ?>
		<?php //echo $form->error($model,'created_date'); ?>
	</div> -->

	<!-- <div class="row">
		<?php //echo $form->labelEx($model,'updated_at'); ?>
		<?php //echo $form->textField($model,'updated_at'); ?>
		<?php //echo $form->error($model,'updated_at'); ?>
	</div> -->
<?php if($update){ ?>
	<div class="row">
		<?php echo $form->labelEx($model,'allocated_warehouse_id'); ?>
		<?php echo CHtml::activeDropDownList($model	, 'allocated_warehouse_id', WarehouseDao::getWarehouseDropdownData(), array('options' => array($model->allocated_warehouse_id=>array('selected'=>true)), 'style' => 'width:220.5px;')); ?>
		<?php echo $form->error($model,'allocated_warehouse_id'); ?>
	</div>
	<?php } ?>

<?php if(!$update){ ?>
	<div class="row">
		<?php echo $form->labelEx($model,'initial_pending_amount'); ?>
		<?php echo $form->textField($model,'initial_pending_amount',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'initial_pending_amount'); ?>
	</div>
<?php } ?>

	<div class="row">
		<?php echo $form->labelEx($model,'total_pending_amount'); ?>
		<?php echo $form->textField($model,'total_pending_amount',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'total_pending_amount'); ?>
	</div>

	

	
	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
