<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>

<div class="form" style="overflow:hidden;">
    <div class="span4" style="padding-left:20px;">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'category-form',
            'focus' => '.error:first',
            'enableAjaxValidation' => false,
        ));
        ?>
        <div >
            <?php $this->renderPartial('category_tree', array('category_id' => "")); ?>
        </div>
    </div>

    <div class="bulk_center">
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php echo $form->errorSummary($model); ?>
         <?php if (Yii::app()->user->hasFlash('errorSummary')): ?><div class="errorSummary" style="color: "><?php echo Yii::app()->user->getFlash('errorSummary'); ?></div><?php endif; ?>
        <div class="">
            <?php echo $form->labelEx($model, 'category_name'); ?>
            <?php echo $form->textField($model, 'category_name', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'category_name'); ?>
        </div>

        <div class="">
            <?php echo $form->labelEx($model, 'category_shipping_charge'); ?>
            <?php echo $form->textField($model, 'category_shipping_charge'); ?>
            <?php echo $form->error($model, 'category_shipping_charge'); ?>
        </div>
        <div class="span12 caregory_btn">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

