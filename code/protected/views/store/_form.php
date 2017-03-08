<?php
/* @var $this StoreController */
/* @var $model Store */

//$this->breadcrumbs = array(
//    'Store' => array('admin'),
//    $model->store_name => array('update', 'id' => $model->store_id),
//    'Update',
//);


$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 1) {

    $store_id = $model->store_id;
    if (Yii::app()->session['brand_admin_id'] != $store_id) {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
} else {
    $store_id = Yii::app()->session['brand_id'];
    if ($model->store_id != $store_id) {
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





    <fieldset>Registered Office</fieldset>
    <div class="row">
        <?php echo $form->labelEx($model, 'business_address'); ?>
        <?php echo $form->textField($model, 'business_address', array('size' => 80, 'maxlength' => 300)); ?>
        <?php echo $form->error($model, 'business_address'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'business_address_pincode'); ?>
        <?php echo $form->textField($model, 'business_address_pincode', array('size' => 40, 'maxlength' => 6)); ?>
        <?php echo $form->error($model, 'business_address_pincode'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'business_address_city'); ?>
        <?php echo $form->textField($model, 'business_address_city', array('size' => 40, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'business_address_city'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'business_address_state'); ?>
        <?php echo $form->textField($model, 'business_address_state', array('size' => 40, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'business_address_state'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'business_address_country'); ?>
        <?php echo $form->textField($model, 'business_address_country', array('size' => 40, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'business_address_country'); ?>
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