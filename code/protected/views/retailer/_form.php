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
        <?php echo $form->labelEx($model, 'retailer_code'); ?>
        <?php echo $form->textField($model, 'retailer_code', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'retailer_code'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>
     <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->textField($model, 'password', array('size' => 6, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'mobile'); ?>
        <?php echo $form->textField($model, 'mobile', array('maxlength' => 10)); ?>
        <?php echo $form->error($model, 'mobile'); ?>
    </div>
     <div class="row">
        <?php echo $form->labelEx($model, 'telephone'); ?>
        <?php echo $form->textField($model, 'telephone', array('size' => 6, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'telephone'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'address'); ?>
        <?php echo $form->textField($model, 'address'); ?>
        <?php echo $form->error($model, 'address'); ?>
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
        <?php echo $form->labelEx($model, 'store_size'); ?>
        <?php echo $form->textField($model, 'store_size', array('size' => 6, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'store_size'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model, 'contact_person1'); ?>
        <?php echo $form->textField($model, 'contact_person1', array('size' => 6, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'contact_person1'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model, 'contact_person2'); ?>
        <?php echo $form->textField($model, 'contact_person2', array('size' => 6, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'contact_person2'); ?>
    </div>
    
     <div class="row">
        <?php echo $form->labelEx($model, 'product_categories'); ?>
        <?php echo $form->textField($model, 'product_categories', array('size' => 6, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'product_categories'); ?>
    </div>
    
    
    <div class="row">
        <?php echo $form->labelEx($model, 'categories_of_interest'); ?>
        <?php echo $form->textField($model, 'categories_of_interest', array('size' => 6, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'categories_of_interest'); ?>
    </div>
     <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', array('0' => 'Disable', '1' => 'Enable')); ?>    
        <?php echo $form->error($model, 'status'); ?>
    </div>
     <div class="row">
                <?php echo $form->labelEx($model, 'status'); ?>
                <div class="check-awesome" style="float: left;">  
                    <?php if (!$model->isNewRecord) { ?>
                    <input  name="status" type="checkbox" id="check-one" value="1" <?php
                        if ($model->status == 1) {
                            echo 'checked';
                        }
                        ?>>
                            <?php } else { ?>
                        <input name="status" type="checkbox" id="check-one" value="1" checked >
                    <?php } ?> 
                    <label for="check-one">
                        <span class="check"></span>
                        <span class="box"></span>
                        Publish
                    </label>
                </div>
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