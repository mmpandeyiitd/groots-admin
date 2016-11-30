<?php
$issuperadmin = Yii::app()->session['is_super_admin'];
/*if ($issuperadmin == 0) {

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
}*/


//echo "<pre>";
//print_r($orderline_detail[0]['min_order_price']);die;


$isAdmin = false;
if($this->checkAccess('SuperAdmin')){
    $isAdmin = true;
}


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

    <?php if (Yii::app()->user->hasFlash('error')): ?>
        <div class="label label-error" style="color:red">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php endif; ?>


    <form name="create" method="post">
        <div class="orderDetail">

            <div class="prod_orderDetail_row">


                <div class="span4" style="width:70%;">
                    <label>Name:</label> <span class="detail"><?php echo $retailer->attributes['name']; ?></span>
                    <div class="clearfix"></div>
                    <label>Address:</label> <span class="detail"><?php echo $retailer->attributes['address']." ".$retailer->attributes['city']." ".$retailer->attributes['state']." ".$retailer->attributes['pincode']; ?></span>
                    <div class="clearfix"></div>

                    <label>Mobile:</label> <span class="detail"><?php echo isset($retailer->attributes['telephone']) ? $retailer->attributes['telephone'] : "none"; ?></span>
                    <div class="clearfix"></div>

                    <label>Delivery Date:</label>
                    <span class="detail"><?php  ?>
                        <?php
                    $delivery_date = substr($model->attributes['delivery_date'], 0, 10);
                        if(!isset($delivery_date) || empty($delivery_date)){
                            $delivery_date = Utility::getDefaultDeliveryDate();
                        }

                        $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'name'=>'deliveryDate',
                            'id'=>'deliveryDate',
                            'value'=> $delivery_date,
                            'options'=>array(
                                'dateFormat' => 'yy-mm-dd',
                                'showAnim'=>'fold',
                                'onSelect' => 'js:function(date) {updatePricesByDate(date);}'

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
                            $warehouse_id = $model->warehouse_id;
                            if($warehouse_id==''){
                                $warehouse_id = $retailer->allocated_warehouse_id;
                            }
                            foreach ($warehouses as $warehouse){
                                ?>
                                <option value= "<?php echo $warehouse->id ?>"  <?php if($warehouse_id==$warehouse->id) {echo "selected=selected";} ?> ><?php echo $warehouse->name ?> </option>
                                <?php
                            }
                            ?>
                        </select>
                    </span>
                    <div class="clearfix"></div>
                    <label>Status:</label> <span class="">
                        <select name="status" class="selectNew">
                            <option value="Pending" <?php if($model->status=='Pending') {echo "selected='selected' ";} ?> >Pending </option>
                            <option value="Confirmed" <?php if($model->status=='Confirmed') {echo "selected='selected' ";} ?>> Confirmed </option>
                            <option value="Out for Delivery" <?php if($model->status=='Out for Delivery') {echo "selected='selected' ";} ?>>Out for Delivery</option>
                            <option value="Delivered" <?php if($model->status=='Delivered') {echo "selected='selected' ";} ?> >Delivered</option>
                            <option value="Cancelled" <?php if($model->status=='Cancelled') {  echo "selected='selected' ";} ?> >Cancelled</option>
                            <option value="Paid" <?php if($model->status=='Paid') {echo "selected='selected' ";} ?> >Paid</option>
                        </select>
                    </span>
                    <div class="clearfix"></div>
                    <label>Comment:</label> <textarea name='comment' rows="4" cols="150" width="250px"><?php echo $model->user_comment ?></textarea>
                    <div class="clearfix"></div>
                </div>

            </div>

            <div class="clearfix"></div>


            <table id="media_gallery" class="table table-striped table-hover table-bordered">
                <thead >
                <tr>

                    <th style="font-weight:normal; width: 40%;" ><strong>Product</strong></th>
                    <th style="font-weight:normal; width: 12%;" ><strong>Pack Unit Size</strong></th>
                    <th style="font-weight:normal; width: 12%;"><strong>Unit Price</strong></th>
                    <th style="font-weight:normal; width: 12%;" ><strong>Quantity in Packs</strong></th>
                    <th style="font-weight:normal; width: 12%;"><strong>Total Quantity (Kg)</strong></th>
                    <?php
                        if(isset($update)){
                            ?>
                            <th style="font-weight:normal; width: 12%;"><strong>Delivered Quantity (Kg)</strong></th>

                    <?php
                        }
                    ?>
                    <th style="font-weight:normal; width: 12%;"><strong>Total Amount (Rs)</strong></th>
                </tr>
                </thead>

                <tbody id="media_gallery_body">

                    <?php
                    //  $updationclose = TRUE;
                    foreach ($retailerProducts as $_retailerProduct) {
                        $unitPrice=$_retailerProduct->effective_price;
                        $isEffectivePrice = 1;
                        if((int)$unitPrice==0){
                            $unitPrice=$_retailerProduct->store_offer_price;
                            $isEffectivePrice = 0;
                        }
                    ?>

                    <tr>
                        <div class="dynamic_content row_<?php echo $_retailerProduct->base_product_id; ?>">
                            <div class="clearfix"></div>


                            <td style="width: 40%;"> <?php echo $_retailerProduct->title;; ?></td>

                            <td style="width: 12%;"> <?php echo $_retailerProduct->pack_size . $_retailerProduct->pack_unit;; ?></td>
                            <td style="width: 12%;" class="unitPrice" id="unitPrice_<?php echo $_retailerProduct->base_product_id; ?>"> <?php echo $unitPrice; ?></td>



                            <td style="width: 12%;">

                                <input type="text" style="width:80px;" class="quantityInPacks readOnlyInput" name="quantity[]"
                                                           id="quantityInPacks_<?php echo $_retailerProduct->base_product_id; ?>"
                                                           value="<?php if (isset($orderLine[$_retailerProduct->base_product_id])) {
                                                               echo $orderLine[$_retailerProduct->base_product_id]['delivered_qty'];
                                                           } ?> "
                                                           onchange="populateAmountField(<?php echo $_retailerProduct->base_product_id . ",". $_retailerProduct->pack_size.",'".$_retailerProduct->pack_unit."'" ; ?>)" readonly="readonly">
                            </td>

                            <td style="width: 12%; align="center" >
                            <?php
                            $totalQuantity = '';
                            if (isset($orderLine[$_retailerProduct->base_product_id])) {
                                if ($_retailerProduct->pack_unit == 'g') {
                                    $totalQuantity = ($orderLine[$_retailerProduct->base_product_id]['product_qty']) * ((int)$_retailerProduct->pack_size)/1000;
                                }
                                else {
                                    $totalQuantity = ($orderLine[$_retailerProduct->base_product_id]['product_qty']) * ((int)$_retailerProduct->pack_size);
                                }
                            }
                            if(isset($update)){
                                $updateAmountField = 'false';
                            }
                            else{
                                $updateAmountField = 'true';
                            }

                            ?>

                                <input type="text" style="width:80px;" class="inputs" name="quantityInKg" class="quantityInKg inputs"
                                   id="quantityInKg_<?php echo $_retailerProduct->base_product_id; ?>"
                                   value="<?php echo $totalQuantity ?>"
                                   onchange="onQuanityInputChange(<?php echo $_retailerProduct->base_product_id . "," . $_retailerProduct->pack_size.",'".$_retailerProduct->pack_unit."'".",'".$updateAmountField."'" ; ?>)" >

                            </td>
                            <?php
                            if(isset($update)){
                            ?>
                                <td style="width: 12%; align="center" >
                                <?php
                                $delvQuantityInKg = '';
                                if (isset($orderLine[$_retailerProduct->base_product_id])) {
                                    if ($_retailerProduct->pack_unit == 'g') {
                                        $delvQuantityInKg = ($orderLine[$_retailerProduct->base_product_id]['delivered_qty']) * ((int)$_retailerProduct->pack_size)/1000;
                                    }
                                    else {
                                        $delvQuantityInKg = ($orderLine[$_retailerProduct->base_product_id]['delivered_qty']) * ((int)$_retailerProduct->pack_size);
                                    }
                                }

                                ?>

                            <input type="text" style="width:80px;"  name="delvQuantityInKg" class="delvQuantityInKg inputs"
                                   id="delvQuantityInKg_<?php echo $_retailerProduct->base_product_id; ?>"
                                   value="<?php echo $delvQuantityInKg ?>"
                                   onchange="onDelvQuanityInputChange(<?php echo $_retailerProduct->base_product_id . "," . $_retailerProduct->pack_size.",'".$_retailerProduct->pack_unit."'" ; ?>)" >

                            </td>
                                <?php
                            }
                            ?>

                                    <td style="width: 12%;"> <input type="text" style="width:80px;" id="amount_<?php echo $_retailerProduct->base_product_id; ?>" class="amount readOnlyInput" name="amount[]" value="" readonly="readonly"/>
                                    </td>




                        </div>
                        </tr>
                        <input type='hidden' name='subscribed_product_id[]' value='<?php echo $_retailerProduct->subscribed_product_id; ?>'/>
                        <input type='hidden' name='base_product_id[]' class='base_product_id' value='<?php echo $_retailerProduct->base_product_id; ?>'/>
                        <input type='hidden' name='product_qty[]'  id="product_qty_<?php echo $_retailerProduct->base_product_id;?>" value="<?php if (isset($orderLine[$_retailerProduct->base_product_id])) {
                            echo $orderLine[$_retailerProduct->base_product_id]['product_qty'];
                        } ?>"/>
                        <?php if(isset($update)){
                            ?>
                            <input type='hidden' name='order_line_id[]' value='<?php if(isset($orderLine[$_retailerProduct->base_product_id])){echo $orderLine[$_retailerProduct->base_product_id]['id'];} ?> '/>
                        <?php } ?>
                        <input type='hidden' name='store_offer_price[]' id='unitPrice_<?php echo $_retailerProduct->base_product_id; ?>' value='<?php echo $unitPrice; ?>'/>
                        <input type='hidden' name='is_effective_price[]' id='isEffectivePrice_<?php echo $_retailerProduct->base_product_id; ?>' value='<?php echo $isEffectivePrice; ?>'/>
                        <?php
                    }
                    ?>
                </tbody>
            </table>



            <div class="order_bottomdetails">
                <div class="span5 pull-right">

                    <h3><b>Total:</b> <i class="fa fa-inr"></i> <span id="sumAmountDisplay">

                        </span></h3>

                    <h3><b>Discount:</b><i class="fa fa-inr"></i><span id="discountChargeDisplay">

                        </span>

                    </h3>

                    <h3><b>Shipping Charge:</b><i class="fa fa-inr"></i><span >
                    <input type="text" style="width:80px;"  name="shippingCharge" class="inputs" id="shippingCharge" onchange ="calculateTotalAmount()" value="<?php echo $retailer->shipping_charge; ?>">
                        </span>

                    </h3>

                    <h3><b>Discounted Total:</b><i class="fa fa-inr"></i> <span id="finalAmountDisplay">  </span></h3>

                    <?php if(isset($update)){
                        if(($model->delivery_date < date('Y-m-d') || $model->status=='Delivered') && !$isAdmin){
                        }
                        else {
                            ?>
                            <input type="submit" class="button_new" value="Update" id="update" name="update"
                                   style="width: auto;"/>
                            <!--<a href="index.php?r=OrderHeader/report&id=<?php //echo $model->attributes['order_id'];
                            ?>" class="button_new" style="width: auto;" target="_blank"  >Create Invoice</a>-->


                            <?php
                        }
                    }
                    else{ ?>
                        <input type="submit" class="button_new" value="Create Order" id="create" name="create" onclick=""/>

                        <?php
                    }
                    ?>



                    <input type="hidden" id="retailerId" name="retailerId" placeholder="0" class="form-control" style="width:120px;" value="<?php echo $retailer->id; ?>" >
                    <input type="hidden" id="selectDelvDate" name="selectDelvDate" placeholder="0" class="form-control" style="width:120px;" value="<?php echo $delivery_date; ?>" >
                    <input type="hidden" id="minOrder" name="minOrder" placeholder="0" class="form-control" style="width:120px;" value="<?php echo $retailer->min_order_price; ?>" >
                   
                    <input type="hidden" id="finalAmount" name="finalAmount" placeholder="0" class="form-control" style="width:120px;" value="" >
                    <input type="hidden" id="shippingOriginal" name="" placeholder="0" class="form-control" style="width:120px;" value="<?php echo $retailer->shipping_charge; ?>" > 
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

        $('.inputs').keydown(function (e) {
            if (e.which === 13) {
                var index = $('.inputs').index(this);
                if(e.shiftKey){
                    $('.inputs').eq(index-1).focus();
                }
                else{
                    $('.inputs').eq(index+1).focus();
                }
                return false;
            }
        });

        $('.readOnlyInput').keydown(function (e) {
            if (e.which === 13) {
                return false;
            }
        });

        $("#create").click(function(event){
            var sumAmount = Number($("#sumAmount").val());
            if (sumAmount==0){
                alert("Order at least one item");
                event.preventDefault();
            }
        });

        $("#update").click(function(event){
            if(beforeUpdate(event)){
                //event.preventDefault();
            }
        });


    });


    function updatePricesByDate(newDate){

        var prevDelvDate = $("#selectDelvDate").val();
        console.log(prevDelvDate);
        console.log(newDate);
        if(prevDelvDate != newDate){
            console.log("changed");
        }
        else {
            console.log("not changed");
        }

        var retailerId = Number($("#retailerId").val());
        console.log("retailerId"+retailerId);
        var data = {"date":newDate, "retailerId":retailerId};

        if (retailerId && data) {
            $.ajax({
                'url': '?r=orderHeader/productPricesByRetailerAndDate',
                'cache': false,
                'method': "POST",
                'data': data,
                'success': function (data) {
                    console.log("here1");
                    setProductPrices(data);
                    $("#selectDelvDate").val(newDate);
                },
                'error': function () {
                    alert('prices not available for the selected date');
                }

            });

        }
    }

    function setProductPrices(data) {
        console.log(data);
        if(data){
            var data = $.parseJSON(data);
            $.each(data, function(k, v) {
                //if($('#isEffectivePrice_'+k).val()==0){
                    $("#unitPrice_"+k).html(v);
                //}
            });
            populateAllAmountFields();
            calculateTotalAmount();

        }
        else{
            alert('prices not available for the selected date, Please select some other date');
        }
    }

    function onQuanityInputChange(prodId, packSize, packUnit, updateAmountField){
        var quantityInKg = $("#quantityInKg_" + prodId).val();

        if(packUnit=="g"){
            quantityInPacks = quantityInKg*1000/packSize;
        }
        else{
            quantityInPacks = quantityInKg/packSize;
        }
        $("#product_qty_" + prodId).val(quantityInPacks);
       // console.log("quantityInPacks"+quantityInPacks);
        //console.log(updateAmountField);
        if(updateAmountField=='true'){
            $("#delvQuantityInKg_" + prodId).val(quantityInKg);
            populateAmountField(quantityInKg, prodId, packSize, packUnit);
        }


    }

    function onDelvQuanityInputChange(prodId, packSize, packUnit){
        var quantityInKg = $("#delvQuantityInKg_" + prodId).val();
        populateAmountField(quantityInKg, prodId, packSize, packUnit);
    }

    function populateAmountField(quantityInKg, prodId, packSize, packUnit) {
        var quantityInPacks;
        var unitPrice = Number($("#unitPrice_" + prodId).html());
        if(packUnit=="g"){
            quantityInPacks = quantityInKg*1000/packSize;
        }
        else{
            quantityInPacks = quantityInKg/packSize;
        }
        var amount = unitPrice * quantityInPacks;
        $("#amount_" + prodId).val(amount.toFixed(2));
        $("#quantityInPacks_" + prodId).val(quantityInPacks);
        calculateTotalAmount();
    }



    function populateAllAmountFields() {
        $(".amount").each(function(){


            var prodId = $(this).attr('id').split("_")[1];

            var unitPrice = Number($("#unitPrice_" + prodId).html());
            var quantityInPacks = Number($("#quantityInPacks_" + prodId).val());

            if(quantityInPacks > 0){
                var amount = unitPrice * quantityInPacks;
                $("#amount_" + prodId).val(amount.toFixed(2));
            }


        });
    }

    function calculateTotalAmount() {
        /*var num = parseFloat($(this).val());
        var cleanNum = num.toFixed(2);*/
        console.log("here");

        var shipping = Number($("#shippingCharge").val());
        var originalShipping = Number($("#shippingOriginal").val());

        //var discount = $("#discount").val();
        var minOrder = Number($("#minOrder").val());

        var sumAmount=0.00;
        var finalAmount=0.00;

        $(".amount").each(function(){

            sumAmount += Number($(this).val());
        });
        if(shipping == originalShipping){
            if(sumAmount < minOrder){
                finalAmount = sumAmount + shipping;

            }
            else{
                finalAmount = sumAmount;
                shipping = 0;
            }
        }
        else{
            finalAmount = sumAmount + shipping;
        }

        shipping = shipping.toFixed(2);
        sumAmount = sumAmount.toFixed(2);
        finalAmount = finalAmount.toFixed(2);
        $("#sumAmount").val(sumAmount);
        $("#sumAmountDisplay").html(sumAmount);
        $("#finalAmount").val(finalAmount);
        $("#finalAmountDisplay").html(finalAmount);

    }


    function beforeUpdate(event) {
        $(".base_product_id").each(function(){
            base_prod_id = $(this).val();
            order_qt = $("#quantityInKg_" + base_prod_id).val().trim();
            //console.log("order qt "+order_qt);
            delv_qt = $("#delvQuantityInKg_" + base_prod_id).val().trim();

            //console.log("delv qt "+delv_qt);
            if((order_qt=='' && delv_qt>0) || order_qt>0 && delv_qt==''){
                alert("either order or deliver quantity field is zero");
                event.preventDefault();
                return false;
            }


            /*if(order_qt > 0 && delv_qt > 0){
                console.log("non zero");
            }
            else if((order_qt==undefined || order_qt==0) && (delv_qt==undefined ||delv_qt == 0)){
                //console.log("zero");
                //$(".row_"+base_prod_id).children(':input').attr("disabled", "disabled");

            }
            else{
                alert("either order or deliver quantity field is zero");
                event.preventDefault();
                return false;
                //

            }*/
        });
        return true;
    }



</script>
