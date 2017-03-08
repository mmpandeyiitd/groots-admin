<?php
/* @var $this OrderLineController */
/* @var $model OrderLine */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_id'); ?>
		<?php echo $form->textField($model,'order_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subscribed_product_id'); ?>
		<?php echo $form->textField($model,'subscribed_product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'base_product_id'); ?>
		<?php echo $form->textField($model,'base_product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'store_id'); ?>
		<?php echo $form->textField($model,'store_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'store_name'); ?>
		<?php echo $form->textField($model,'store_name',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'store_email'); ?>
		<?php echo $form->textField($model,'store_email',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'store_front_id'); ?>
		<?php echo $form->textField($model,'store_front_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'store_front_name'); ?>
		<?php echo $form->textField($model,'store_front_name',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'seller_name'); ?>
		<?php echo $form->textField($model,'seller_name',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'seller_phone'); ?>
		<?php echo $form->textField($model,'seller_phone',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'seller_address'); ?>
		<?php echo $form->textArea($model,'seller_address',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'seller_state'); ?>
		<?php echo $form->textField($model,'seller_state',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'seller_city'); ?>
		<?php echo $form->textField($model,'seller_city',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'colour'); ?>
		<?php echo $form->textField($model,'colour',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'size'); ?>
		<?php echo $form->textField($model,'size',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_name'); ?>
		<?php echo $form->textField($model,'product_name',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_qty'); ?>
		<?php echo $form->textField($model,'product_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unit_price'); ?>
		<?php echo $form->textField($model,'unit_price',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->