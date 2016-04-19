<?php
/* @var $this RetailerRequestController */
/* @var $model RetailerRequest */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'retailer-request-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-error" style="color: green;"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	 <?php echo $form->labelEx($model,'retailer_id'); ?>
	 <?php echo $form->textField($model,'retailer_id'); ?>
	 <?php echo $form->error($model,'retailer_id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'store_id'); ?>
		<?php //echo $form->textField($model,'store_id'); ?>
		<?php //echo $form->error($model,'store_id'); ?>
	</div>
        
        <?php if(Yii::app()->session['is_super_admin']==1){?>
    <div class="row">
        <?php echo $form->labelEx($model, 'store_id'); ?>
        <?php
         $opts = CHtml::listData(Store::model()->findAll(),'store_id','store_name');
          echo $form->dropDownList($model,'store_id',$opts,array('empty'=>'select brand'),array('options' => array($model->store_id=>array('selected'=>true))));     
         ?>  
        <?php echo $form->error($model, 'store_id'); ?>
    </div>
    <?php }?>
        

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

        <div class="row">
        <?php //echo $form->labelEx($model, 'status'); ?>
        <?php //echo $form->dropDownList($model, 'status', array('0' => 'Disable', '1' => 'Enable')); ?>
        <?php //echo $form->error($model, 'status'); ?>
        </div>
       
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->