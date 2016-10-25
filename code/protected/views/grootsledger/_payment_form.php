<?php
/* @var $this GrootsledgerController */
/* @var $model Grootsledger */
/* @var $form CActiveForm */


?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'payment-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model->errors); ?>

    <div class="">
        <?php echo $form->labelEx($model,'retailer_id'); ?>
        <?php echo $form->textField($model,'retailer_id', array('readonly'=>'readonly')); ?>
        <?php echo $form->error($model,'retailer_id'); ?>
    </div>

    <div class="">
        <?php echo $form->label($model,'retailerName'); ?>
        <label for="RetailerPayment_totalPayableAmount"><?php echo $model->retailerName?></label>
        <?php //echo $form->label($model, 'retailerName'); ?>
        <?php echo $form->error($model,'retailerName'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'totalPayableAmount'); ?>
        <label for="RetailerPayment_totalPayableAmount"><?php echo$model->totalPayableAmount?></label>
        <?php //echo $form->label($model,'totalPayableAmount'); ?>
        <?php echo $form->error($model,'totalPayableAmount'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'paid_amount'); ?>
        <?php echo $form->textField($model,'paid_amount',array('size'=>60,'maxlength'=>255)); ?>
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
            CHtml::listData(RetailerPayment::paymentTypes(),'value', 'value'),
            array('empty' => 'Select a Payment Type'));

        ?>
        <?php echo $form->error($model,'payment_type'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'cheque_no/Debit_note_no'); ?>
        <?php echo $form->textField($model,'cheque_no'); ?>
        <?php echo $form->error($model,'cheque_no'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status',
            CHtml::listData(RetailerPayment::status(),'value', 'value'));

        ?>
        <?php echo $form->error($model,'status'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'comment'); ?>
        <?php echo $form->textArea($model,'comment', array('cols'=>200, 'rows'=>4, 'style'=>'width:400px;')); ?>
        <?php echo $form->error($model,'comment'); ?>
    </div>

    <?php echo $form->hiddenField($model,'id'); ?>
    <?php echo $form->hiddenField($model,'created_at'); ?>


    <div class="row buttons">
        <?php
        if($update==true){
            echo CHtml::submitButton('Update', array('name'=>'update'));
        }
        else{
             echo CHtml::submitButton('Create', array('name'=>'create'));
        }
        ?>


        <a href="index.php?r=Grootsledger/admin&retailerId=<?php echo $model->retailer_id; ?>" class="button_new" style="width: auto;" target="_blank"  >Back</a>

    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->