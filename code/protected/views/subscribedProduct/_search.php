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
<?php $this->endWidget(); ?>

</div><!-- search-form -->