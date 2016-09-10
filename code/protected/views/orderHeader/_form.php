<?php
/* @var $this OrderHeaderController */
/* @var $model OrderHeader */
/* @var $form CActiveForm */
/* @var $retailerProducts retailerProducts */
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

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php if(isset($retailerProducts) && $retailerProducts != '') { ?>

		<div class="row">
        <table id="media_gallery" class="table table-striped table-hover table-bordered">
            <thead >
                <tr>
                    <th style="font-weight:normal;">Image</th>
                    <th style="font-weight:normal;" >Product</th>
                    <th style="font-weight:normal;" >Price/Unit</th>
                    <th style="font-weight:normal;" >Quantity</th>
                </tr>
            </thead>

            <tbody id="media_gallery_body">
                <?php
               
                foreach ($retailerProducts as $_retailerProduct) {
                    ?>
                    <tr style=" margin-top:5px;">					
                        <td><img style="width: 100px;" src="<?php echo $_retailerProduct->thumb_url; ?>"></td>
                        <td> <?php echo $_retailerProduct->title; ?></td>
                        <td> <?php echo $_retailerProduct->store_offer_price.'/'.$_retailerProduct->pack_size.$_retailerProduct->pack_unit; ?></td>
                        <!--<td><input type='text' name='quantity_<?php //echo $_retailerProduct->subscribed_product_id ?>' value='<?php //echo $_retailerProduct->quantity; ?>'/></td>-->
                        <td><input type='text' name='quantity[] value='<?php echo $_retailerProduct->quantity; ?>'/></td>
                        <td><input type='hidden' name='subscribed_product_id[]' value='<?php echo $_retailerProduct->subscribed_product_id; ?>'/></td>
                        <td><input type='hidden' name='base_product_id[]' value='<?php echo $_retailerProduct->base_product_id; ?>'/></td>
                        <td><input type='hidden' name='store_offer_price[]' value='<?php echo $_retailerProduct->store_offer_price; ?>'/></td>
                    </tr>

                    <?php
                       
                    }
                
                ?>
            </tbody>
        </table>
            <input type='hidden' name='retailerId' value='<?php echo $retailerId; ?>'/>


        </div>


		<div class="row buttons">
			<?php echo CHtml::submitButton('Save', array('name'=>'create-order')); ?>
		</div>
	<?php } ?>	
<?php $this->endWidget(); ?>

</div><!-- form -->