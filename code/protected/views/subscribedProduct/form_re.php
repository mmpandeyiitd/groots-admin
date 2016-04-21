<?php
/* @var $this RetailerProductQuotationController */
/* @var $model RetailerProductQuotation */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'retailer-product-quotation-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model_subscribe); ?>

	
       <div class="row">
                <label for="grade"><?php echo 'Retailer Id *' ?></label>
                <input type="text" name="a" value="<?php echo  $_REQUEST['retailer_id']; ?>" readonly/>
            </div>
     <div class="row">
                <label for="grade"><?php echo 'Subscribed Product Id*' ?></label>
                <input type="text" name="a" value="<?php echo  $_REQUEST['id']; ?>"readonly/>
            </div>
    
     <div class="row">
                <label for="store_price"><?php echo 'Store Price*' ?></label>
                <input type="text" name="store_price" value="<?php echo  $store_price; ?>"readonly/>
            </div>
     <div class="row">
                <label for="grade"><?php echo 'Store Offer Price*' ?></label>
                <input type="text" name="store_offer_price" value="<?php echo  $store_offer_price; ?>"readonly/>
            </div>
    
        <div class="row">
		<?php echo $form->labelEx($model_subscribe,'effective_price'); ?>
		<?php echo $form->textField($model_subscribe,'effective_price'); ?>
		<?php echo $form->error($model_subscribe,'effective_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model_subscribe,'discount_per'); ?>
		<?php echo $form->textField($model_subscribe,'discount_per'); ?>
		<?php echo $form->error($model_subscribe,'discount_per'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model_subscribe,'status'); ?>
		  <?php echo $form->dropdownlist($model_subscribe, 'status', array('1' => 'Enable', '0' => 'Disable')); ?>
		<?php echo $form->error($model_subscribe,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model_subscribe->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->