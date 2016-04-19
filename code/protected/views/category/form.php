<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>
<div style="width:300px; float:left;" >
   <?php //print_r($_REQUEST);die;?>
  <?php  $this->renderPartial('category_tree', array('category_id'=>$category_id)); ?>
</div>   
<div class="form" style="width:300px; float:left;" >

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'category_name'); ?>
		<?php echo $form->textField($model,'category_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'category_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_shipping_charge'); ?>
		<?php echo $form->textField($model,'category_shipping_charge'); ?>
		<?php echo $form->error($model,'category_shipping_charge'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::resetButton($model->isNewRecord ? 'Reset' : 'Reset'); ?>
	</div>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'base-product-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
            
		//'base_product_id',
		
                'created_date',
                'modified_date',
	),
)); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->