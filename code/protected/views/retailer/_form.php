<?php
/* @var $this RetailerController */
/* @var $model Retailer */
/* @var $form CActiveForm */
?>

<div class="form"  style="overflow: hidden;">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'retailer-form',
        'focus' => '.error:first',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => false,
    ));
    ?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    <?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-error label label-success" ><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>
    <div class="">


        <div class="row">
            <?php echo $form->labelEx($model, 'Business Name *'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'Owner Name '); ?>
            <?php echo $form->textField($model, 'contact_person1', array('size' => 6, 'maxlength' => 150)); ?>
            <?php echo $form->error($model, 'contact_person1'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'Primary Email *'); ?>
            <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'Primary Mobile *'); ?>
            <?php echo $form->textField($model, 'mobile', array('maxlength' => 10)); ?>
            <?php echo $form->error($model, 'mobile'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'Password *'); ?>
            <?php echo $form->textField($model, 'password', array('size' => 6, 'maxlength' => 150)); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'Delivery address *'); ?>
            <?php echo $form->textField($model, 'address'); ?>
            <?php echo $form->error($model, 'address'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'GeoLocation'); ?>
            <?php echo $form->textField($model, 'geolocation'); ?>
            <?php echo $form->error($model, 'geolocation'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'Telephone'); ?>
            <?php echo $form->textField($model, 'telephone', array('size' => 6, 'maxlength' => 150)); ?>
            <?php echo $form->error($model, 'telephone'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'Owner Phone'); ?>
            <?php echo $form->textField($model, 'owner_phone'); ?>
            <?php echo $form->error($model, 'owner_phone'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'Owner Email'); ?>
            <?php echo $form->textField($model, 'owner_email'); ?>
            <?php echo $form->error($model, 'owner_email'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'Billing Email'); ?>
            <?php echo $form->textField($model, 'billing_email'); ?>
            <?php echo $form->error($model, 'billing_email'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'Settlement Days'); ?>
            <?php echo $form->textField($model, 'settlement_days'); ?>
            <?php echo $form->error($model, 'settlement_days'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'Time of Delivery'); ?>
            <?php echo $form->textField($model, 'time_of_delivery'); ?>
            <?php echo $form->error($model, 'time_of_delivery'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'Demand Centre'); ?>
            <?php echo $form->textField($model, 'demand_centre'); ?>
            <?php echo $form->error($model, 'demand_centre'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'Date of onboarding'); ?>
            <?php  /*$this->widget('ext.YiiDateTimePicker.jqueryDateTime', array( 
            'model' => $model, 
            'attribute' => 'date_of_onboarding', 
            'value'=>$model->date_of_onboarding,   
            'options' => array( 
                'dateFormat' => 'yy-mm-dd',
               'showAnim' => 'fold',
               'debug' => true,
               //'minDate' => 0,
 
            ), //DateTimePicker options 
            'htmlOptions' => array('readonly'=>'true'),
            ));  */
            
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
           'name' => 'date_of_onboarding',
           'attribute' => 'date_of_onboarding',
            'flat' => false, //remove to hide the datepicker
            'options' => array(
                'showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
               // 'minDate' => 0,
               'dateFormat' => 'dd-mm-yy',
               
           ),
            'value'=>$model->date_of_onboarding,
            'htmlOptions' => array(
             'style' => '','readonly'=>'true'
         ),
      ));
            ?>
            <?php echo $form->error($model, 'date_of_onboarding'); ?>
        </div>
    </div>
    <div class="">
        <div class="row">
            <?php echo $form->labelEx($model, 'city'); ?>
            <?php echo $form->textField($model, 'city'); ?>
            <?php echo $form->error($model, 'city'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'state'); ?>
            <?php echo $form->textField($model, 'state', array('size' => 60, 'maxlength' => 150)); ?>
            <?php echo $form->error($model, 'state'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'VAT_number'); ?>
            <?php echo $form->textField($model, 'VAT_number', array('size' => 60, 'maxlength' => 150)); ?>
            <?php echo $form->error($model, 'VAT_number'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'website'); ?>
            <?php echo $form->textField($model, 'website', array('size' => 60, 'maxlength' => 150)); ?>
            <?php echo $form->error($model, 'website'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'Status'); ?>
            <?php echo $form->dropDownList($model, 'status', array('1' => 'Active','0' => 'Deactive')); ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>
        <div class=" buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
            <?php //echo  CHtml::button("See Request", array("onclick" => "document.location.href='" . Yii::app()->controller->createUrl("retailerRequest/admin", array('retailer_id' => $retailer_id)) . "'")); ?>

        </div> 
    </div>
    <div style="clear:both;"></div>


    <?php $this->endWidget(); ?>

</div><!-- form -->
