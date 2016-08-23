<?php
/* @var $this OrderHeaderController */
/* @var $model OrderHeader */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-header-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


 <div <?php if(isset($update)) echo "style='display:none;'" ?> >
	<?php echo $form->labelEx($model, '<b>Select a retailer</b>'); ?>
	<?php
	$disabled = "";
	if(isset($update)) {
		$disabled = "disabled";
	}
	    echo $form->dropDownList($model,
	      'user_id',
	      CHtml::listData(Retailer::model()->findAll(array('select'=>'id,name','order' => 'name')),'id','name'),
	      array('empty' => 'Select a retailer', 'name' => 'retailer-dd', 'disabled'=>$disabled, 'options'=>array($retailerId=>array('selected'=>'selected')))
	    );
	?>

    <?php
	if(!isset($update)) {
		echo CHtml::submitButton('Get retailer products', array('name' => 'select-retailer'));
	}?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->