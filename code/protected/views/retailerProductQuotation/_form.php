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


	<?php echo $form->errorSummary($model); ?>

	 <div class="row">
                <label for="retailer_id"><?php echo 'Buyers Id *' ?></label>
                <input type="text" name="retailer_id" value="<?php echo  $retailer_id; ?>" readonly/>
            </div>
    

	<div class="row">
                <label for="subscribed_product_id"><?php echo 'Subscribed Product Id*' ?></label>
                <input type="text" name="subscribed_product_id" value="<?php echo  $subscribed_product_id; ?>"readonly/>
            </div>

	<div class="row">
                <label for="store_price"><?php echo 'Store Price*' ?></label>
                <input type="text" name="store_price" value="<?php echo  $store_price; ?>"readonly/>
            </div>
        <div class="row">
                <label for="store_offer_price"><?php echo 'Store Offer Price*' ?></label>
                <input type="text" name="store_offer_price" value="<?php echo  $store_offer_price; ?>"readonly/>
            </div>
     <div class="row">
                <label for="effective_price"><?php echo 'Effective Price*' ?></label>
                <input type="text" name="effective_price" value="<?php echo  $effective_price; ?>"/>
            </div>
    <div class="row">
                <label for="discout_per"><?php echo 'Discount *' ?></label>
                <input type="text" name="discout_per" value="<?php echo  $discout_per; ?>"/>
            </div>
	
	<div class="row buttons">
		
            <button  name="data" type="submit" value="SAVE">Save</button>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->