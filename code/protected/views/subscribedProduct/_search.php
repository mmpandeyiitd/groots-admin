<?php
/* @var $this SubscribedProductController */
/* @var $model SubscribedProduct */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model_grid,'title'); ?>
		<?php echo $form->textField($model_grid,'title'); ?>
	</div>
     <div class="row">
		<?php echo $form->label($model_grid,'store_price'); ?>
		<?php echo $form->textField($model_grid,'store_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model_grid,'store_offer_price'); ?>
		<?php echo $form->textField($model_grid,'store_offer_price'); ?>
	</div>

     <div class="row">
		<?php echo $form->label($model_grid,'effective_price'); ?>
		<?php echo $form->textField($model_grid,'effective_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model_grid,'discount_price'); ?>
		<?php echo $form->textField($model_grid,'discount_price'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->