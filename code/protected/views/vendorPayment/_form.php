<?php
/* @var $this VendorPaymentController */
/* @var $model VendorPayment */
/* @var $form CActiveForm */
VendorPayment::vendorPaymentTypes();
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
		<?php echo $form->labelEx($model,'vendor_id'); ?>
		<?php echo $form->textField($model,'vendor_id', array('readOnly' => 'readOnly')); ?>
		<?php echo $form->error($model,'vendor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'paid_amount'); ?>
		<?php $array =  array('size'=>10,'maxlength'=>10);
			echo $form->textField($model,'paid_amount',$array); ?>
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
								VendorPayment::vendorPaymentTypes(),
								array('empty' => '--Payment Mode--', 'onchange' => 'checkPaymentMode()', 'style' => 'width:220.20px') 
								); ?>
		<?php echo $form->error($model,'payment_type'); ?>
	</div>

	<div class="row hide cheque">
		<?php echo $form->labelEx($model,'cheque_no'); ?>
		<?php echo $form->textField($model,'cheque_no',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'cheque_no'); ?>
	</div>

	<div class="row hide debit">
		<?php echo $form->labelEx($model,'debit_no'); ?>
		<?php echo $form->textField($model,'debit_no',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'debit_no'); ?>
	</div>

	<div class="row hide cheque">
		<?php echo $form->labelEx($model,'cheque_status'); ?>
		<?php echo $form->dropDownList($model,'cheque_status',
								VendorPayment::getChequeStatus(),
								array('empty' => '--Payment Mode--', 'style' => 'width:220.20px;') 
								); ?>
		<?php echo $form->error($model,'cheque_status'); ?>
	</div>

    <div class="row hide cheque">
        <?php echo $form->labelEx($model,'is_cheque_reissued'); ?>
        <?php echo $form->dropDownList($model,'is_cheque_reissued',
            array('Yes' => 'Yes'),
            array('empty' => '--is Reissued--', 'style' => 'width:220.20px;')
        ); ?>
        <?php echo $form->error($model,'is_cheque_reissued'); ?>
    </div>

    <div class="row hide cheque">
        <?php echo $form->labelEx($model,'reissue_ref_no'); ?>
        <?php echo $form->textField($model,'reissue_ref_no',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model,'reissue_ref_no'); ?>
    </div>

	<div class="row hide cheque">
		<?php echo $form->labelEx($model,'cheque_date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'attribute'=>'cheque_date',

            'id'=>'cheque_date',
            //'value'=> date('Y-m-d'),
            'options'=>array(
                'dateFormat' => 'yy-mm-dd',
                'showAnim'=>'fold',
            ),
            'htmlOptions'=>array(
                'style'=>'height:20px;'
            ),
        )); ?>
        <?php echo $form->error($model,'cheque_date'); ?>
	</div>

	<div class="row hide cheque">
		<?php echo $form->labelEx($model,'cheque_name'); ?>
		<?php echo $form->textField($model,'cheque_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'cheque_name'); ?>
	</div>

	<div class="row hide internet">
		<?php echo $form->labelEx($model,'transaction_id'); ?>
		<?php echo $form->textField($model,'transaction_id',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'transaction_id'); ?>
	</div>

	<div class="row hide others internet">
		<?php echo $form->labelEx($model,'receiving_acc_no'); ?>
		<?php echo $form->textField($model,'receiving_acc_no',array('value' => $vendor->bank_account_no ,'size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'receiving_acc_no'); ?>
	</div>

	<div class="row hide others internet">
		<?php echo $form->labelEx($model,'bank_name'); ?>
		<?php echo $form->textField($model,'bank_name',array('value' => $vendor->bank_name,'size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'bank_name'); ?>
	</div>

	<div class="row hide others internet">
		<?php echo $form->labelEx($model,'isfc_code'); ?>
		<?php echo $form->textField($model,'isfc_code',array('value' => $vendor->isfc_code,'size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'isfc_code'); ?>
	</div>

	<div class="row hide others internet ">
		<?php echo $form->labelEx($model,'acc_holder_name'); ?>
		<?php echo $form->textField($model,'acc_holder_name',array('value' => $vendor->account_holder_name,'size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'acc_holder_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'created_at'); ?>
<!--        --><?php //$this->widget('zii.widgets.jui.CJuiDatePicker',array(
//            'model'=>$model,
//            'attribute'=>'created_at',
//
//            'id'=>'created_at',
//            'value'=> date('Y-m-d'),
//            'options'=>array(
//                'dateFormat' => 'yy-mm-dd',
//                'showAnim'=>'fold',
//            ),
//            'htmlOptions'=>array(
//                'style'=>'height:20px;'
//            ),
//        )); ?>
<!--        --><?php //echo $form->error($model,'created_at'); ?>
<!--	</div>-->

<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'updated_at'); ?>
<!--		--><?php //echo $form->textField($model,'updated_at'); ?>
<!--		--><?php //echo $form->error($model,'updated_at'); ?>
<!--	</div>-->
	<div class="row status">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model, 'status', array(0=>'Inactive', 1=>'Active'), array('style' => 'width:220.20px;')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
	$(document).ready(function(){
		checkPaymentMode()
    });

    function onStartUp(){
    	$('.hide').each(function(){
    		$(this).hide();
    	})
    }

    function checkPaymentMode(){
    	console.log('here2');
    	var e = document.getElementById("VendorPayment_payment_type");
		var str = e.options[e.selectedIndex].text;
        onStartUp();
        if( str != 'Cash'){
            console.log('here');
            $('.others').each(function () {
                $(this).show();
            })
        }
		if(str == 'Cheque'){
			$('.cheque').each(function(){
				$(this).show();
			})
		}
		else if(str == 'NetBanking'){
			$('.internet').each(function(){
				$(this).show();
			})
		}

    }

</script>