<?php
/* @var $this StoreController */
/* @var $model Store */

$this->breadcrumbs = array(
    'Store' => array('admin'),
    //$model->store_name=>array('update','id'=>$model->store_id),
    'Create',
);
?>        
<ul class="tab_list">
    <!--<li><a href="index.php?r=store/admin">Brand List</a></li>-->
</ul>
<div class="form" style="overflow:hidden;">

    <?php
    $form = $this->beginWidget(
            'CActiveForm', array(
        'id' => 'upload-form',
        'focus' => '.error:first',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
            )
    );
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo CHtml::errorSummary($model); ?>
    <?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-error" style="color: green;"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>
    <?php if (Yii::app()->user->hasFlash('password_error')): ?><div class="errorSummary" style="color:"><?php echo Yii::app()->user->getFlash('password_error'); ?></div><?php endif; ?>
    <?php if (Yii::app()->user->hasFlash('brand_adminuser')): ?><div class="errorSummary"><?php echo Yii::app()->user->getFlash('brand_adminuser'); ?></div><?php endif; ?>


    <h4 class="sub-title">Store Person Information</h4>
    <div class="row">
        <?php echo $form->labelEx($model, 'seller_name'); ?>
        <?php echo $form->textField($model, 'seller_name', array('size' => 40, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'seller_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'mobile_numbers'); ?>
        <?php echo $form->textField($model, 'mobile_numbers', array('size' => 40, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'mobile_numbers'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 40, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Password *'); ?>
        <input type="password" name="password" value="<?php echo $password; ?>"/>
        <?php //echo $form->error($model,'email');  ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'Confirm password'); ?>
        <input type="password" name="confirm_password" value=""/>
    </div>

    <h4 class="sub-title">Business Address Information</h4>
    <div class="row">
        <?php echo $form->labelEx($model, 'business_address_country'); ?>
        <?php echo $form->textField($model, 'business_address_country', array('size' => 40, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'business_address_country'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'business_address_state'); ?>
        <?php echo $form->textField($model, 'business_address_state', array('size' => 40, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'business_address_state'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'business_address'); ?>
        <?php echo $form->textField($model, 'business_address', array('size' => 80, 'maxlength' => 300)); ?>
        <?php echo $form->error($model, 'business_address'); ?>
    </div>




    <div class="row">
        <?php echo $form->labelEx($model, 'business_address_city'); ?>
        <?php echo $form->textField($model, 'business_address_city', array('size' => 40, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'business_address_city'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'business_address_pincode'); ?>
        <?php echo $form->textField($model, 'business_address_pincode', array('size' => 40, 'maxlength' => 6)); ?>
        <?php echo $form->error($model, 'business_address_pincode'); ?>
    </div>

    <div class="row">
        <?php //echo $form->labelEx($model,'telephone_numbers'); ?>
        <?php //echo $form->textField($model,'telephone_numbers',array('size'=>40,'maxlength'=>15)); ?>
        <?php //echo $form->error($model,'telephone_numbers');  ?>
    </div>

    <h4 class="sub-title">Store Information</h4>
    <div class="row">
        <?php echo $form->labelEx($model, 'store name'); ?>
        <?php echo $form->textField($model, 'store_name', array('size' => 40, 'maxlength' => 200)); ?>
        <?php echo $form->error($model, 'store_name'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'store_details'); ?>
        <?php echo $form->textarea($model, 'store_details', array('rows' => 3, 'cols' => 80)); ?>
        <?php echo $form->error($model, 'store_details'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'tags'); ?>
        <?php echo $form->textField($model, 'tags', array('data-role' => "tagsinput")); ?>
        <?php echo $form->error($model, 'tags'); ?>
    </div>

    <?php $logoPath = CHtml::resolveValue($model, 'store_logo'); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'store logo'); ?>
        <?php echo $form->fileField($model, 'store_logo'); ?>
        <?php echo $form->error($model, 'store_logo'); ?>
    </div>

  
    <div class="row">
        <!--        <label for="Store[auto_generate_store_logo]">Auto generate Store Logo</label>
                <input id="auto_generate_store_logo" type="checkbox" name="Store[auto_generate_store_logo]">-->






        <div class="row">
            <?php echo $form->labelEx($model, 'status'); ?>
            <div class="check-awesome" style="float: left;">  
                <input name="status" type="checkbox" id="check-one" value="1" checked >;
                <label for="check-one">
                    <span class="check"></span>
                    <span class="box"></span>
                    Publish
                </label>
            </div>
            <?php echo $form->error($model, 'status'); ?>
        </div>

        <div class="">
            <div class="row buttons">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
            </div>
        </div>

        <div style="clear:both;"></div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
<script src="themes/abound/js/bootstrap-tagsinput.js" type="text/javascript" charset="utf-8"></script>
<link href="themes/abound/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css">