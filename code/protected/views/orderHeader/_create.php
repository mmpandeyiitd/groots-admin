<?php
$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 0) {

    if (empty(Yii::app()->session['brand_admin_id']) && empty(Yii::app()->session['brand_id'])) {

        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong.');
        $this->redirect(array('DashboardPage/index'));
    }
    $store_id = Yii::app()->session['brand_admin_id'];
    if (empty($store_id)) {
        $store_id = Yii::app()->session['brand_id'];
    }

//$store_id = $_GET['store_id'];
    $store_name = Store::model()->getstore_nameByid($store_id);

    if ((Yii::app()->session['brand_admin_id'] != $store_id) && (Yii::app()->session['brand_id'] != $store_id)) {
        echo Yii::app()->session['brand_admin_id'];
        die;
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong.');
        $this->redirect(array('DashboardPage/index'));
    }

    $this->breadcrumbs = array(
        'Brand' => array('store/admin'),
        $store_name => array('store/update', "id" => $store_id),
        'Orders' => array('orderHeader/admin',),
        'Update',
    );
} else {
    $store_id = Yii::app()->session['brand_id'];
    $this->breadcrumbs = array(
        'Orders' => array('admin',),
        'Create',
    );
}


//echo "<pre>";
//print_r($orderline_detail[0]['min_order_price']);die;
?>
<div class="form">
    <?php if (Yii::app()->user->hasFlash('premission_info')): ?><div class="errorSummary"><?php echo Yii::app()->user->getFlash('premission_info'); ?></div><?php endif; ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'order-header-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>
    <!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->

    <?php echo $form->errorSummary($model); ?>
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="label label-success" style="color:green">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>

    <?php endif; ?>


    <form name="create" method="post">
        <div class="orderDetail">

            <div class="prod_orderDetail_row">


                <div class="span4" style="width:70%;">
                    <h3 class="subTitle">Address:</h3>

                    <label>Name:</label> <span class="detail"><?php echo $retailer->attributes['name']; ?></span>
                    <div class="clearfix"></div>
                    <label>Address:</label> <span class="detail"><?php echo $retailer->attributes['address']; ?></span>
                    <div class="clearfix"></div>
                    <label>City:</label> <span class="detail"><?php echo $retailer->attributes['city']; ?></span>
                    <div class="clearfix"></div>
                    <label>State:</label> <span class="detail"><?php echo $retailer->attributes['state']; ?></span>
                    <div class="clearfix"></div>
                    <label>Pincode:</label> <span class="detail"><?php echo $retailer->attributes['pincode']; ?></span>
                    <div class="clearfix"></div>
                    <label>Country:</label> <span class="detail">India</span>
                    <div class="clearfix"></div>
                    <label>Mobile:</label> <span class="detail"><?php echo isset($retailer->attributes['telephone']) ? $retailer->attributes['telephone'] : "none"; ?></span>
                    <div class="clearfix"></div>

                    <label>Delivery Date:</label>
                    <span class="detail"><?php  ?>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'name'=>'deliveryDate',
                            'id'=>'deliveryDate',
                            'value'=> date("Y-m-d"),
                            'options'=>array(
                                'dateFormat' => 'dd-mm-yy',

                                'showAnim'=>'fold',
                            ),
                            'htmlOptions'=>array(
                                'style'=>'height:20px;'
                            ),
                        ));
                        ?>
                    </span>
                    <div class="clearfix"></div>
                    <label>Warehouse:</label> <span class="detail">
                        <select name="warehouse" class="selectNew">
                            <?php
                                foreach ($warehouses as $warehouse){
                            ?>
                            <option value= "<?php echo $warehouse->id ?>"  <?php if($model->warehouse_id==$warehouse->id) {echo "'selected'='selected' ";} ?> ><?php echo $warehouse->name ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </span>
                    <div class="clearfix"></div>
                    <label>Status:</label> <span class="detail">
                        <select name="status" class="selectNew">
                            <option value="Pending" <?php if($model->status=='Pending') {echo "'selected'='selected' ";} ?> >Pending </option>
                            <option value="Confirmed" <?php if($model->status=='Confirmed') {echo "'selected'='selected' ";} ?>> Confirmed </option>
                            <option value="Out for Delivery" <?php if($model->status=='Out for Delivery') {echo "'selected'='selected' ";} ?>>Out for Delivery</option>
                            <option value="Delivered" <?php if($model->status=='Delivered') {echo "'selected'='selected' ";} ?> >Delivered</option>
                            <option value="Cancelled" <?php if($model->status=='Cancelled') {echo "'selected'='selected' ";} ?> >Cancelled</option>
                            <option value="Paid" <?php if($model->status=='Paid') {echo "'selected'='selected' ";} ?> >Paid</option>
                        </select>
                    </span>
                    <div class="clearfix"></div>
                    <label>Comment:</label> <span class="detail"><textarea name='comment' rows="4" cols="150"><?php echo $model->user_comment ?></textarea></span>
                    <div class="clearfix"></div>
                </div>

            </div>

            <div class="clearfix"></div>

            <?php
            //  $updationclose = TRUE;
            foreach ($retailerProducts as $_retailerProduct) {

                ?>
            <div class="dynamic_content">
                <div class="clearfix"></div>
                <div class="row final-productList">

                    <div class="span2" style=" width:200px;">
                        <div class="row finalProd_img">
                            <a href="javascript:void(0)" class="thumbnail">
                                <?php

                                if (!empty($_retailerProduct->thumb_url)) {
                                    echo '<img src="' . $_retailerProduct->thumb_url . '">';
                                } else {
                                    echo '<img src="http://admin.groots.dev.canbrand.in/noimage.jpg">';
                                }
                                ?>
                            </a>
                        </div>
                    </div>

                    <div class="span9 finalDetail">

                        <h2>
                            <span >Unit Price <i class="fa fa-inr"></i> <?php echo $_retailerProduct->store_offer_price;?></span>
                        </h2>
                        <table class = "table" style="width: 100%" >
                            <tbody>
                            <tr>
                                <td style="width: 30%">Product Name:</td>
                                <td style="width: 77px;"> <?php echo $_retailerProduct->title;
                                    ; ?></td>
                            </tr>

                            <tr>
                                <td style="width: 30%">Pack Unit Size:</td>
                                <td style="width: 77px;"> <?php echo $_retailerProduct->pack_size.$_retailerProduct->pack_unit;
                                    ; ?></td>
                            </tr>

                            <tr>
                                <td style="width: 30%">Order Quantity:</td>
                                <td><input type="text" name="quantity[]" id="quantity_<?php echo $_retailerProduct->base_product_id;?>" value="<?php if(isset($orderLine[$_retailerProduct->base_product_id])){echo $orderLine[$_retailerProduct->base_product_id]['product_qty'];} ?> " onchange="populateAmountField(<?php echo $_retailerProduct->base_product_id.",".$_retailerProduct->store_offer_price;?>)"></td>
                            </tr>

                            <tr>
                                <td style="width: 30%">Total Amount: </td>
                                <td> <input type="text" id="amount_<?php echo $_retailerProduct->base_product_id; ?>" class="amount" name="amount[]" value="" readonly="readonly"/>
                                </td>
                            </tr>


                            </tbody>

                        </table>

                    </div>

                </div>
            </div>

                <input type='hidden' name='subscribed_product_id[]' value='<?php echo $_retailerProduct->subscribed_product_id; ?>'/>
                <input type='hidden' name='base_product_id[]' value='<?php echo $_retailerProduct->base_product_id; ?>'/>
                <?php if(isset($update)){
                ?>
                <input type='hidden' name='order_line_id[]' value='<?php if(isset($orderLine[$_retailerProduct->base_product_id])){echo $orderLine[$_retailerProduct->base_product_id]['id'];} ?> '/>
                <?php } ?>
                <input type='hidden' name='store_offer_price[]' id='unitPrice_<?php echo $_retailerProduct->base_product_id; ?>' value='<?php echo $_retailerProduct->store_offer_price; ?>'/>

            <?php
                }
            ?>
            <div class="order_bottomdetails">
                <div class="span5 pull-right">

                    <h3><b>Total:</b> <i class="fa fa-inr"></i> <span id="sumAmountDisplay">

                        </span></h3>

                    <h3><b>Discount:</b><i class="fa fa-inr"></i><span id="discountChargeDisplay">

                        </span>

                    </h3>

                    <h3><b>Shipping Charge:</b><i class="fa fa-inr"></i><span id="shippingChargeDisplay">

                        </span>

                    </h3>

                    <h3><b>Discounted Total:</b><i class="fa fa-inr"></i> <span id="finalAmountDisplay">  </span></h3>

                    <?php if(isset($update)){ ?>

                        <input type="submit" class="button_new" value="Update" id="update" name="update" style="width: auto;"/>
                        <a href="index.php?r=OrderHeader/report&id=<?php echo $model->attributes['order_id']; ?>" class="button_new" style="width: auto;" target="_blank"  >Create Invoice</a>
                    <?php
                    }
                    else{ ?>
                        <input type="submit" class="button_new" value="Create Order" id="create" name="create" />

                    <?php
                    }
                    ?>



                    <input type="hidden" id="retailerId" name="retailerId" placeholder="0" class="form-control" style="width:120px;" value="<?php echo $retailer->id; ?>" >
                    <input type="hidden" id="minOrder" name="minOrder" placeholder="0" class="form-control" style="width:120px;" value="<?php echo $retailer->min_order_price; ?>" >
                    <input type="hidden" id="shipping" name="shipping" placeholder="0" class="form-control" style="width:120px;" value="<?php echo $retailer->shipping_charge; ?>" >
                    <input type="hidden" id="finalAmount" name="finalAmount" placeholder="0" class="form-control" style="width:120px;" value="" >
                    <input type="hidden" id="shippingCharge" name="shippingCharge" placeholder="0" class="form-control" style="width:120px;" value="" >
                    <input type="hidden" id="discountCharge" name="discountCharge" placeholder="0" class="form-control" style="width:120px;" value="" >
                    <input type="hidden" id="sumAmount" name="sumAmount" placeholder="0" class="form-control" style="width:120px;" value="" >
                </div>
            </div>

        </div>
    </form>
    <?php $this->endWidget(); ?>
    </div>

    <script type="text/javascript">
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace

        $(document).ready(function() {
            populateAllAmountFields();
            calculateTotalAmount();
        });


        function populateAmountField(prodId, unitPrice) {

            //this.value = this.value.replace(/[^0-9\.]/g,'');
            var quantity = $("#quantity_" + prodId).val();
            $("#amount_" + prodId).val(unitPrice * quantity);
            calculateTotalAmount();
        }

        function populateAllAmountFields() {
            $(".amount").each(function(){

                /*sumAmount += Number($(this).val());
                console.log(sumAmount);*/

                var prodId = $(this).attr('id').split("_")[1];

                var unitPrice = Number($("#unitPrice_" + prodId).val());
                var quantity = Number($("#quantity_" + prodId).val());
                console.log(unitPrice);
                console.log(quantity);
                if(quantity > 0){
                    $("#amount_" + prodId).val(unitPrice * quantity);
                }


            });
        }

        function calculateTotalAmount() {
            console.log("here123");

            var shipping = Number($("#shipping").val());
            //var discount = $("#discount").val();
            var minOrder = Number($("#minOrder").val());

            var sumAmount=0;
            var finalAmount=0;

            $(".amount").each(function(){

                sumAmount += Number($(this).val());
                console.log(sumAmount);
            });

            if(sumAmount < minOrder){
                finalAmount = sumAmount + shipping;

            }
            else{
                finalAmount = sumAmount;
                shipping = 0;
            }

            $("#shippingCharge").val(shipping);
            $("#shippingChargeDisplay").html(shipping);
            $("#sumAmount").val(sumAmount);
            $("#sumAmountDisplay").html(sumAmount);
            $("#finalAmount").val(finalAmount);
            $("#finalAmountDisplay").html(finalAmount);

        }

    </script>
