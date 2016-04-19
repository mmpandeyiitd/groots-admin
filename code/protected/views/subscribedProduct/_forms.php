<?php
/* @var $this SubscribedProductController */
/* @var $model SubscribedProduct */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subscribed-product-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
       
        <?php echo $form->errorSummary($model); 
		
		
		
		
		 if(isset($record[0]['thumb_url']))
		 $imginfo=$record[0]['thumb_url'];
		 else
		 $imginfo='';
		 
		 if(isset($record[0]['base_product_id']))
		 $baseid=$record[0]['base_product_id'];
		 else
		 $baseid='';
		 
		 if(isset($record[0]['title']))
		 $titleinfo=$record[0]['title'];
		 else
		 $titleinfo='';
		 
		 if(isset($record[0]['description']))
		 $descriptioninfo=$record[0]['description'];
		 else
		 $descriptioninfo='';
		?>
	<div class="row">
		<img alt="<?php echo $titleinfo; ?>" src="<?php echo $imginfo; ?>">
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model,'base_product_id'); ?>
		<?php echo $form->textField($model,'base_product_id',array('size'=>10,'maxlength'=>10 ,'readonly'=>true)); ?>
		<?php echo $form->error($model,'base_product_id'); ?>
	</div>
       
     <div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo CHtml::textArea('title',$titleinfo,array('rows' => 6, 'cols' => 50,'readonly'=>true)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

        <div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo CHtml::textArea('description',$descriptioninfo,array('rows' => 6, 'cols' => 50,'readonly'=>true)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
	             
	<div class="row">
		<?php echo $form->labelEx($model,'store_price'); ?>
		<?php echo $form->textField($model,'store_price',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'store_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_offer_price'); ?>
		<?php echo $form->textField($model,'store_offer_price',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'store_offer_price'); ?>
	</div>

	
	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'checkout_url'); ?>
		<?php echo $form->textField($model,'checkout_url',array('size'=>60,'maxlength'=>2083)); ?>
		<?php echo $form->error($model,'checkout_url'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'is_deleted'); ?>
		<?php echo $form->textField($model,'is_deleted'); ?>
		<?php echo $form->error($model,'is_deleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sku'); ?>
		<?php echo $form->textField($model,'sku',array('size'=>60,'maxlength'=>128)); ?>
		
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity'); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_cod'); ?>
		<?php echo $form->textField($model,'is_cod'); ?>
		<?php echo $form->error($model,'is_cod'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subscribe_shipping_charge'); ?>
		<?php echo $form->textField($model,'subscribe_shipping_charge'); ?>
		<?php echo $form->error($model,'subscribe_shipping_charge'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
       
<?php $this->endWidget(); ?>

</div><!-- form -->