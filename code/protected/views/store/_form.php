<?php
/* @var $this StoreController */
/* @var $model Store */

$this->breadcrumbs = array(
    'Store' => array('admin'),
    $model->store_name => array('update', 'id' => $model->store_id),
    'Update',
);


$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 1) {

    $store_id = $model->store_id;
    if (Yii::app()->session['brand_admin_id'] != $store_id) {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
} else {
    $store_id = Yii::app()->session['brand_id'];
    if ($model->store_id!= $store_id) {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
}
?>        


<?php //echo Yii::app()->user->setFlash('error', 'Updated Successfully');   ?>
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

    <!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->
    <?php echo CHtml::errorSummary($model); ?>
    <?php if (Yii::app()->user->hasFlash('success')): ?><div class="label label-success"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>
    <?php if (Yii::app()->user->hasFlash('error')): ?><div class="errorSummary " style=""><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>


    <fieldset>Store Person Information</fieldset>
    <!--    <div class="row">
    <?php echo $form->labelEx($model, 'store_id'); ?>
    <?php echo $form->textField($model, 'store_id', array('size' => 40, 'maxlength' => 255, 'readonly' => true)); ?>
    <?php echo $form->error($model, 'store_id'); ?>
        </div>-->

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


    <fieldset>Business Address Information</fieldset>
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
        <?php //echo $form->labelEx($model, 'telephone_numbers'); ?>
        <?php //echo $form->textField($model, 'telephone_numbers', array('size' => 40, 'maxlength' => 15));  ?>
        <?php //echo $form->error($model, 'telephone_numbers');   ?>
    </div>

    <fieldset>Store Information</fieldset>


    <div class="row">
        <?php echo $form->labelEx($model, 'Store'); ?>
        <?php echo $form->textField($model, 'store_name', array('size' => 40, 'maxlength' => 200)); ?>
        <?php echo $form->error($model, 'store_name'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'Store details'); ?>
        <?php echo $form->textarea($model, 'store_details', array('rows' => 3, 'cols' => 80)); ?>
        <?php echo $form->error($model, 'store_details'); ?>
    </div>
    <div class="row">
                <?php echo $form->labelEx($model, 'tags'); ?>
                <?php echo $form->textField($model, 'tags', array('data-role'=>"tagsinput")); ?>
                <?php echo $form->error($model, 'tags'); ?>
            </div>
    <?php //$logoPath = CHtml::resolveValue($model, 'store_logo');   ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'store logo'); ?>

        <?php echo $form->fileField($model, 'store_logo'); ?>
        <?php echo $form->error($model, 'store_logo'); ?>
        <?php echo CHtml::image("$model->store_logo_url", "$model->store_logo", array('width' => 80, 'height' => 100)); ?>
    </div>
    <br/>
   
    <div class="row">
        <!--        <label for="Store[auto_generate_store_logo]">Auto generate Brand Logo</label>
                <input id="auto_generate_store_logo" type="checkbox" name="Store[auto_generate_store_logo]">-->
    </div>


    <!--    <div class="row">
    <?php echo $form->labelEx($model, 'visible'); ?>
    <?php echo $form->dropdownlist($model, 'visible', array('1' => 'Enable', '0' => 'Disable')); ?>
    <?php echo $form->error($model, 'visible'); ?>
        </div>-->

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <div class="check-awesome" style="float: left;">  

            <input  name="status" type="checkbox" id="check-one" value="1" <?php
            if ($model->status == 1) {
                echo 'checked';
            }
            ?>>;

            <label for="check-one">
                <span class="check"></span>
                <span class="box"></span>
                Publish
            </label>
        </div>
        <?php echo $form->error($model, 'status'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>
    <div style="clear:both;"></div>


    <?php $this->endWidget(); ?>

</div><!-- form -->
<script src="themes/abound/js/bootstrap-tagsinput.js" type="text/javascript" charset="utf-8"></script>
<link href="themes/abound/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/resources/demos/style.css">