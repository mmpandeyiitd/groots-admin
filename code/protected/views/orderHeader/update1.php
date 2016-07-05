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
        'Update',
    );
}
?>
<div class="form">

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
    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($modelOrder); ?>
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="label label-success" style="color:green">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>

        <?php
    endif;
    //echo $form->errorSummary($model);
    // if (Yii::app()->user->hasFlash('error')):
    // print_r(Yii::app()->user->hasFlash('error'));die;
    ?>
    <!--        <div class="errorSummary" style="color:red">
    <?php //echo Yii::app()->user->getFlash('error'); ?>
            </div>-->
    <?php //endif; ?>

    <form name="update" method="post">         
        <div class="orderDetail">
            <h1 class="titleNew">Order Info(OrderId:<?php echo $modelOrder->attributes['order_id']; ?>) <a href="index.php?r=OrderHeader/admin" class="backBtn_new">Back</a></h1> 
            <div class="prod_orderDetail_row"> 

                <?php
                $counter = 0;
                $grandtotal = 0;
                $wsptotal = '';
                $qtytotal = 0;
                $isize = 0;

                foreach ($model as $key => $value) {
                    $qtytotal = 0;
                    $wsptotal = '';
                    $subcatinfo = new SubscribedProduct;
                    $infodetail = $subcatinfo->getinfobyid($model[$key]->attributes['subscribed_product_id']);


                    $linedescinfo = new OrderLine;
                    $lineinfo = $linedescinfo->getlinedescById($value->id);
                    $lineinfodeltail = $linedescinfo->getlinedetailcById($value->id);
                    if (isset($lineinfo[0]['qty'])) {
                        $qtytotal = $qtytotal + $lineinfo[0]['qty'];
                    }
                    if (isset($lineinfo[1]['qty'])) {
                        $qtytotal = $qtytotal + $lineinfo[1]['qty'];
                    }
                    if (isset($lineinfo[2]['qty'])) {
                        $qtytotal = $qtytotal + $lineinfo[2]['qty'];
                    }
                    if (isset($lineinfo[3]['qty'])) {
                        $qtytotal = $qtytotal + $lineinfo[3]['qty'];
                    }
                    if (isset($lineinfo[4]['qty'])) {
                        $qtytotal = $qtytotal + $lineinfo[4]['qty'];
                    }
                    if (isset($lineinfo[5]['qty'])) {
                        $qtytotal = $qtytotal + $lineinfo[5]['qty'];
                    }
                    if (isset($lineinfodeltail[0]['unit_price'])) {
                        $wsptotal = $qtytotal * ($lineinfodeltail[0]['unit_price'] - $lineinfodeltail[0]['unit_price_discount']);
                    }
                    if (isset($lineinfodeltail[0]['total_price_discount'])) {
                        $wsptotal = $wsptotal - $lineinfodeltail[0]['total_price_discount'];
                    }
                    $grandtotal = $wsptotal + $grandtotal;
                    ?>  
                    <?php if ($counter == 0) { ?>

                        <div class="span4">
                            <h3 class="subTitle">Billing Address:</h3>

                            <label>Name:</label> <span class="detail"><?php echo $modelOrder->attributes['billing_name']; ?></span>
                            <div class="clearfix"></div>
                            <label>Address:</label> <span class="detail"><?php echo $modelOrder->attributes['billing_address']; ?></span>
                            <div class="clearfix"></div>
                            <label>City:</label> <span class="detail"><?php echo $modelOrder->attributes['billing_city']; ?></span>
                            <div class="clearfix"></div> 
                            <label>State:</label> <span class="detail"><?php echo $modelOrder->attributes['billing_state']; ?></span>
                            <div class="clearfix"></div> 
                            <label>Pincode</label> <span class="detail"><?php echo $modelOrder->attributes['billing_pincode']; ?></span>
                            <div class="clearfix"></div> 
                            <label>Country:</label> <span class="detail">India</span>
                            <div class="clearfix"></div>
                            <label>Mobile:</label> <span class="detail"><?php echo $modelOrder->attributes['billing_phone']; ?></span>
                            <div class="clearfix"></div>  
                        </div>
                        <div class="span4 pull-right">
                            <h3 class="subTitle">Shipping Address: 
                                <a id="contentEdit" style=" cursor: pointer;" onclick="display_editfields();">Edit</a></h3>
                            <label>Name:</label>
                            <span class="detail">
                                <div id="old_shipping_name" style="<?php if (empty($form->errorSummary($modelOrder))) {
                    echo 'display: inline';
                } else {
                    echo 'display: none';
                } ?>;"><?php echo $modelOrder->attributes['shipping_name']; ?></div>
                                <input type="text" id="shipping_name" name="shipping_name" style="<?php if (!empty($form->errorSummary($modelOrder))) {
                    echo 'display: inline';
                } else {
                    echo 'display: none';
                } ?>;margin-top:7px;" value="<?php echo $modelOrder->attributes['shipping_name']; ?>"/>
                            </span>
                            <div class="clearfix"></div>
                            <label>Address:</label> <span class="detail">
                                <div id="old_shipping_address" style="<?php if (empty($form->errorSummary($modelOrder))) {
                    echo 'display: inline';
                } else {
                    echo 'display: none';
                } ?>;"><?php echo $modelOrder->attributes['shipping_address']; ?></div>
                                <input type="text" id="shipping_address" name="shipping_address" style="<?php if (!empty($form->errorSummary($modelOrder))) {
                    echo 'display: inline';
                } else {
                    echo 'display: none';
                } ?>;margin-top:7px;" value="<?php echo $modelOrder->attributes['shipping_address']; ?>"/>
                            </span>
                            <div class="clearfix"></div>
                            <label>City:</label> 
                            <span class="detail">
                                <div id="old_shipping_city" style="<?php if (empty($form->errorSummary($modelOrder))) {
                    echo 'display: inline';
                } else {
                    echo 'display: none';
                } ?>;"><?php echo $modelOrder->attributes['shipping_city']; ?></div>
                                <input type="text" id="shipping_city" name="shipping_city" style="<?php if (!empty($form->errorSummary($modelOrder))) {
                    echo 'display: inline';
                } else {
                    echo 'display: none';
                } ?>;margin-top:7px;" value="<?php echo $modelOrder->attributes['shipping_city']; ?>"/>
                            </span>
                            <div class="clearfix"></div> 
                            <label>State:</label>
                            <span class="detail">
                                <div id="old_shipping_state" style="<?php if (empty($form->errorSummary($modelOrder))) {
                    echo 'display: inline';
                } else {
                    echo 'display: none';
                } ?>;"><?php echo $modelOrder->attributes['shipping_state']; ?></div>
                                <input type="text" id="shipping_state" name="shipping_state" style="<?php if (!empty($form->errorSummary($modelOrder))) {
                    echo 'display: inline';
                } else {
                    echo 'display: none';
                } ?>;margin-top:7px;" value="<?php echo $modelOrder->attributes['shipping_state']; ?>"/></span>
                            <div class="clearfix"></div> 
                            <label>Pincode</label> 
                            <span class="detail">
                                <div id="old_shipping_pincode" style="<?php if (empty($form->errorSummary($modelOrder))) {
                    echo 'display: inline';
                } else {
                    echo 'display: none';
                } ?>;"> <?php echo $modelOrder->attributes['shipping_pincode']; ?></div>
                                <input type="text" id="shipping_pincode" name="shipping_pincode" style="<?php if (!empty($form->errorSummary($modelOrder))) {
                    echo 'display: inline';
                } else {
                    echo 'display: none';
                } ?>;margin-top:7px;" value="<?php echo $modelOrder->attributes['shipping_pincode']; ?>"/></span>
                            <div class="clearfix"></div> 
                            <label>Country:</label> <span class="detail">India</span>
                            <div class="clearfix"></div>
                            <label>Mobile:</label> <span class="detail">
                                <div id="old_shipping_phone" style="<?php if (empty($form->errorSummary($modelOrder))) {
                    echo 'display: inline';
                } else {
                    echo 'display: none';
                } ?>;"><?php echo $modelOrder->attributes['shipping_phone']; ?></div>
                                <input type="text" id="shipping_phone" name="shipping_phone" style="<?php if (!empty($form->errorSummary($modelOrder))) {
                    echo 'display: inline';
                } else {
                    echo 'display: none';
                } ?>;margin-top:7px;" value="<?php echo $modelOrder->attributes['shipping_phone']; ?>"/></span>
                            <input type="submit" class="activebutton" id="update_shipping_address" name="update_shipping_address" style="<?php if (!empty($form->errorSummary($modelOrder))) {
                    echo 'display: inline';
                } else {
                    echo 'display: none';
                } ?>;margin-right: 200px; margin-top: 5px;" value="Update"/>
                            <div class="clearfix"></div>  
                        </div>
                        <div class="clearfix spacerNew"></div>

    <?php } ?>
                    <div class="clearfix"></div> 
                    <div class="dynamic_content">

                        <div class="clearfix"></div> 
                        <div class="row final-productList">
                            <div class="span2" style=" width:200px;">
                                <div class="row finalProd_img">
                                    <a href="javascript:void(0)" class="thumbnail"><img src="http://yorder.canbrand.in/images/product_04.jpg"></a>
                                </div>
                            </div>
                            <div class="span9 finalDetail">
                                <h2>
    <?php echo $infodetail[0]['seller_name']; ?> <span>Store price <i class="fa fa-inr"></i> <?php if (isset($lineinfodeltail[0]['unit_price'])) echo $lineinfodeltail[0]['unit_price']; ?></span>
                                </h2>

                                <table class = "table">
                                    <tbody>
                                        <tr>
                                            <td>Order Sub_id:</td>
                                            <td><?php echo $model[$key]->attributes['id']; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Unit Price:</td>
                                            <td id="uprice_<?php echo $isize; ?>"><?php if (isset($lineinfodeltail[0]['unit_price'])) echo $lineinfodeltail[0]['unit_price']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Discount on Unit Price:</td>
                                            <td><input type="text" id="unit_price_discount_<?php echo $isize; ?>" name="unit_price_discount[]" class="form-control" placeholder="0" style="width:120px;" value="<?php if (isset($lineinfodeltail[0]['unit_price_discount'])) echo $lineinfodeltail[0]['unit_price_discount']; ?>" onblur="discountperunitcount(<?php echo $isize; ?>)"></td>
                                        </tr>
                                        <tr>
                                            <td>Total Qty:</td>
                                            <td id="tqy_<?php echo $isize; ?>"><?php echo $qtytotal; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total Amount:</td>
                                            <td id="tamount_<?php echo $isize; ?>"><?php echo $wsptotal; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Discount on Total Amount:</td>
                                            <td><input type="text" id="total_price_discount_<?php echo $isize; ?>" name="total_price_discount[]" class="form-control" placeholder="0" style="width:120px;" value="<?php if (isset($lineinfodeltail[0]['total_price_discount'])) echo $lineinfodeltail[0]['total_price_discount']; ?>" onblur="discountcount(<?php echo $isize; ?>)"></td>
                                        </tr>
                                        <tr>
                                    </tbody>

                                </table>
                                <div class="status_top">

                                    <span>status</span>
                                    <span>
                                        <select name="Status[]" class="selectNew" style="width:120px;">
                                            <option value="Pending" <?php if ($model[$key]->attributes['status'] == 'Pending') echo 'selected="selected"'; ?> >Pending </option>
                                            <option value="Processing" <?php if ($model[$key]->attributes['status'] == 'Processing') echo 'selected="selected"'; ?> >Processing </option>
                                            <option value="Confirmed" <?php if ($model[$key]->attributes['status'] == 'Confirmed') echo 'selected="selected"'; ?> > Confirmed </option>
                                            <option value="Shipped" <?php if ($model[$key]->attributes['status'] == 'Shipped') echo 'selected="selected"'; ?>>Shipped</option>
                                            <option value="Delivered" <?php if ($model[$key]->attributes['status'] == 'Delivered') echo 'selected="selected"'; ?> >Delivered</option>
                                            <option value="Cancelled" <?php if ($model[$key]->attributes['status'] == 'Cancelled') echo 'selected="selected"'; ?> >Cancelled</option>
                                            <option value="ReturnedRequested" <?php if ($model[$key]->attributes['status'] == 'ReturnedRequested') echo 'selected="selected"'; ?> >Returne Requested</option>
                                            <option value="ReturnedComplete" <?php if ($model[$key]->attributes['status'] == 'ReturnedComplete') echo 'selected="selected"'; ?>>Returne Complete</option>
                                        </select>
                                    </span>
                                </div>     
                                <div class="order_sizecontain">

                                    <div class="span2"style="margin-left: 0px;">
                                        <div class="row form-group">
                                            <h3>Size</h3>
                                            <input type="text" class="form-control size" name="sizeqty_<?php echo $model[$key]->attributes['id']; ?>[]" id="size4_<?php echo $isize; ?>" placeholder="0"  style="width:80px;" value="<?php if (isset($lineinfo[0]['qty'])) echo $lineinfo[0]['qty']; ?>" onblur="sizecount(<?php echo $isize; ?>)">
                                        </div>
                                    </div>
                                    
                                    
                                  </div>
                               </div>
                            </div>

                        </div>
                    </div>  
                </div>
                <input type="hidden" id="id" name="id[]" value="<?php echo $model[$key]->attributes['id']; ?>"/>
                <input type="hidden" id="order_id" name="order_id" value="<?php echo $modelOrder->attributes['order_id']; ?>"/> 

    <?php
    $counter++;
    $isize++;
}
?> 
            <div class="order_bottomdetails">
                <div class="span5 pull-right">
                    <h3><b>Grand Total:</b> <span id="grandt"><?php echo $grandtotal; ?></span></h3>
                    <h3><b>Discount Grand Total:</b><input type="text" id="gtotal_price_discount" name="gtotal_price_discount" class="form-control" placeholder="0" style="width:120px;" value="<?php if (isset($modelOrder->attributes['gtotal_price_discount'])) echo $modelOrder->attributes['gtotal_price_discount']; ?>" onblur="granddiscount(this.id)"></h3>
                    <h3><b>Discounted Grand Total:</b><span id="grandtd"> <?php echo $grandtotal - $modelOrder->attributes['gtotal_price_discount']; ?></span></h3>

                    <input type="hidden" id="grand_total" class="button_new" name="grand_total" value="<?php echo $grandtotal; ?>"/>
                    <input type="hidden" class="button_new" value="<?php echo $isize; ?>" id="isize" name="isize" /> 
                    <input type="submit" class="button_new" value="Update Status" id="Update" name="Update" /> 
                    <a href="index.php?r=OrderHeader/report&id=<?php echo $modelOrder->attributes['order_id']; ?>" class="button_new" target="_blank"  >Create Invoice</a>
                </div> 
            </div>
        </div>
    </form>   
<?php $this->endWidget(); ?>
    <script >

        function sizecount(Id)
        {

            if ($("#size10_" + Id).val() == '')
                $("#size10_" + Id).val("0");

            if ($("#size12_" + Id).val() == '')
                $("#size12_" + Id).val(0);

            if ($("#size14_" + Id).val() == '')
                $("#size14_" + Id).val(0);

            if ($("#size8_" + Id).val() == '')
                $("#size8_" + Id).val(0);

            if ($("#size6_" + Id).val() == '')
                $("#size6_" + Id).val(0);

            if ($("#size4_" + Id).val() == '')
                $("#size4_" + Id).val(0);

            var tqty = parseInt($("#size10_" + Id).val()) + parseInt($("#size6_" + Id).val()) + parseInt($("#size4_" + Id).val()) + parseInt($("#size8_" + Id).val()) + parseInt($("#size12_" + Id).val()) + parseInt($("#size14_" + Id).val());
            $("#tqy_" + Id).html(tqty);

            var discoutTotal = parseInt($('#unit_price_discount_' + Id).val()) * tqty;

            var totalprice = parseInt($('#uprice_' + Id).text()) * tqty;

            totalprice = parseInt(totalprice) - parseInt(discoutTotal);
            totalprice = parseInt(totalprice) - parseInt($('#total_price_discount_' + Id).val());
            $("#tamount_" + Id).html(totalprice);
            var grandtotal = 0;

            for (i = 0; i < parseInt($("#isize").val()); i++) {

                grandtotal = parseInt($('#tamount_' + i).text()) + parseInt(grandtotal);

            }
            $("#grandt").html(grandtotal);
            grandtotal = parseInt(grandtotal) - parseInt($('#gtotal_price_discount').val());

            $("#grandtd").html(grandtotal);
        }
        function discountcount(Id)
        {
            if ($("#size10_" + Id).val() == '')
                $("#size10_" + Id).val("0");

            if ($("#size12_" + Id).val() == '')
                $("#size12_" + Id).val(0);

            if ($("#size14_" + Id).val() == '')
                $("#size14_" + Id).val(0);

            if ($("#size8_" + Id).val() == '')
                $("#size8_" + Id).val(0);

            if ($("#size6_" + Id).val() == '')
                $("#size6_" + Id).val(0);

            if ($("#size4_" + Id).val() == '')
                $("#size4_" + Id).val(0);

            var tqty = parseInt($("#size10_" + Id).val()) + parseInt($("#size6_" + Id).val()) + parseInt($("#size4_" + Id).val()) + parseInt($("#size8_" + Id).val()) + parseInt($("#size12_" + Id).val()) + parseInt($("#size14_" + Id).val());
            $("#tqy_" + Id).html(tqty);

            var discoutTotal = parseInt($('#unit_price_discount_' + Id).val()) * tqty;

            var totalprice = parseInt($('#uprice_' + Id).text()) * tqty;

            totalprice = parseInt(totalprice) - parseInt(discoutTotal);
            totalprice = parseInt(totalprice) - parseInt($('#total_price_discount_' + Id).val());
            $("#tamount_" + Id).html(totalprice);
            var grandtotal = 0;

            for (i = 0; i < parseInt($("#isize").val()); i++) {

                grandtotal = parseInt($('#tamount_' + i).text()) + parseInt(grandtotal);

            }
            $("#grandt").html(grandtotal);
            grandtotal = parseInt(grandtotal) - parseInt($('#gtotal_price_discount').val());

            $("#grandtd").html(grandtotal);
        }
        function discountperunitcount(Id)
        {
            if ($("#size10_" + Id).val() == '')
                $("#size10_" + Id).val("0");

            if ($("#size12_" + Id).val() == '')
                $("#size12_" + Id).val(0);

            if ($("#size14_" + Id).val() == '')
                $("#size14_" + Id).val(0);

            if ($("#size8_" + Id).val() == '')
                $("#size8_" + Id).val(0);

            if ($("#size6_" + Id).val() == '')
                $("#size6_" + Id).val(0);

            if ($("#size4_" + Id).val() == '')
                $("#size4_" + Id).val(0);

            var tqty = parseInt($("#size10_" + Id).val()) + parseInt($("#size6_" + Id).val()) + parseInt($("#size4_" + Id).val()) + parseInt($("#size8_" + Id).val()) + parseInt($("#size12_" + Id).val()) + parseInt($("#size14_" + Id).val());
            $("#tqy_" + Id).html(tqty);

            var discoutTotal = parseInt($('#unit_price_discount_' + Id).val()) * tqty;

            var totalprice = parseInt($('#uprice_' + Id).text()) * tqty;

            totalprice = parseInt(totalprice) - parseInt(discoutTotal);
            totalprice = parseInt(totalprice) - parseInt($('#total_price_discount_' + Id).val());
            $("#tamount_" + Id).html(totalprice);
            var grandtotal = 0;

            for (i = 0; i < parseInt($("#isize").val()); i++) {

                grandtotal = parseInt($('#tamount_' + i).text()) + parseInt(grandtotal);

            }
            $("#grandt").html(grandtotal);
            grandtotal = parseInt(grandtotal) - parseInt($('#gtotal_price_discount').val());

            $("#grandtd").html(grandtotal);
        }
        function granddiscount(id)
        {
            var dis = parseInt($('#grandt').text()) - parseInt($('#' + id).val())
            $("#grandtd").html(dis);
        }

        //.............................. display edit address.................................//

        function display_editfields() {
            document.getElementById("old_shipping_name").style.display = "none";
            document.getElementById("shipping_name").style.display = "inline";
            document.getElementById("old_shipping_address").style.display = "none";
            document.getElementById("shipping_address").style.display = "inline";
            document.getElementById("old_shipping_city").style.display = "none";
            document.getElementById("shipping_city").style.display = "inline";
            document.getElementById("old_shipping_state").style.display = "none";
            document.getElementById("shipping_state").style.display = "inline";
            document.getElementById("old_shipping_pincode").style.display = "none";
            document.getElementById("shipping_pincode").style.display = "inline";
            document.getElementById("old_shipping_phone").style.display = "none";
            document.getElementById("shipping_phone").style.display = "inline";
            document.getElementById("update_shipping_address").style.display = "inline";


        }

    </script>   
