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
$order_id = '';
$orderline_detail = array();
$min_order_price=0;
$shipping_charge=0;
$chksip=0;
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    if (is_numeric($order_id)) {
        $orderline_detail = $modelOrder->GetOrderdetail($order_id);
        $min_order_price=$orderline_detail[0]['min_order_price'];
      
    }
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

    <?php echo $form->errorSummary($modelOrder); ?>
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="label label-success" style="color:green">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>

    <?php endif; ?>


    <form name="update" method="post">         
        <div class="orderDetail">
            <?php  
               if(isset($_REQUEST['bckstatus']))
               {
                 Yii::app()->session['sttus_sess'] = "1";
                 Yii::app()->session['bckstatus'] = $_REQUEST['bckstatus'];
               }
                 
//                  Yii::app()->session['status'] = $modelOrder->attributes['status'];
            ?>
            <h1 class="titleNew">Order Info(Order number:<?php echo $modelOrder->attributes['order_number']; ?>) <a href="index.php?r=OrderHeader/admin&status=<?php echo Yii::app()->session['bckstatus']; ?>" class="backBtn_new">Back</a></h1> 
            <div class="prod_orderDetail_row"> 

                <?php
                $counter = 0;
                $grandtotal = 0;
                $grand_discount = 0;
                $wsptotal = '';
                $qtytotal = 0;
                $isize = 0;
                
                $maxorder = count($orderline_detail);
                $grandtotal = $wsptotal + $grandtotal;
                
                ?>  
                <?php if ($maxorder > 0) { ?>

                    <div class="span4">
                        <h3 class="subTitle">Address:</h3>

                        <label>Name:</label> <span class="detail"><?php echo $modelOrder->attributes['billing_name']; ?></span>
                        <div class="clearfix"></div>
                        <label>Address:</label> <span class="detail"><?php echo $modelOrder->attributes['billing_address']; ?></span>
                        <div class="clearfix"></div>
                        <label>City:</label> <span class="detail"><?php echo $modelOrder->attributes['billing_city']; ?></span>
                        <div class="clearfix"></div> 
                        <label>State:</label> <span class="detail"><?php echo $modelOrder->attributes['billing_state']; ?></span>
                        <div class="clearfix"></div> 
                        <label>Pincode:</label> <span class="detail"><?php echo $modelOrder->attributes['billing_pincode']; ?></span>
                        <div class="clearfix"></div> 
                        <label>Country:</label> <span class="detail">India</span>
                        <div class="clearfix"></div>
                        <label>Mobile:</label> <span class="detail"><?php echo $modelOrder->attributes['billing_phone']; ?></span>
                        <div class="clearfix"></div>  
                    </div>
                    
                    <div class="clearfix spacerNew"></div>

                <?php } ?>
            </div>
            <?php
            $updationclose = TRUE;
            $orderline_ids = $_REQUEST['id'];
            //echo $orderline_ids;die;
            $status_array[0] = $modelOrder->attributes['status'];
            if ($status_array[0] == 'Confirmed' || $status_array[0] == 'Paid' || $status_array[0] == 'Shipped' || $status_array[0] == 'Delivered' || $status_array[0] == 'Cancelled' || $status_array[0] == 'ReturnedRequested' || $status_array[0] == 'ReturnedComplete' || $status_array[0] == 'ReturnedComplete' || $status_array[0] == 'Out for Delivery') {

                $updationclose = FALSE;
            }
            ?>
            <div class="clearfix"></div> 
            <div class="status_top">
                <span style="float: left;width: 150px;line-height: 28px;">Status:</span>
                <span>                                       

                    <select name="Status[]" class="selectNew">
                        <option value="Pending" <?php if ($status_array[0] == 'Pending') echo 'selected="selected"'; ?> >Pending </option>
                        <option value="Confirmed" <?php if ($status_array[0] == 'Confirmed') echo 'selected="selected"'; ?> > Confirmed </option>
                        <option value="Out for Delivery" <?php if ($status_array[0] == 'Out for Delivery') echo 'selected="selected"'; ?>>Out for Delivery</option>
                        <option value="Delivered" <?php if ($status_array[0] == 'Delivered') echo 'selected="selected"'; ?> >Delivered</option>
                        <option value="Cancelled" <?php if ($status_array[0] == 'Cancelled') echo 'selected="selected"'; ?> >Cancelled</option>
                        <option value="Paid" <?php if ($status_array[0] == 'Paid') echo 'selected="selected"'; ?> >Paid</option>
                    </select> 
                </span>
            </div>
            <?php
            //  $updationclose = TRUE;
            for ($i = 0; $i < $maxorder; $i++) {
                //  $updationclose =FALSE;
                $base_product_ids_array = array();
                $product_names_array = array();
                $sizes_array = array();
                $qtys_array = array();
                $unit_prices_array = array();
                $shipping_charges_array = array();
                $total_price_discounts_array = array();
                $unit_price_discounts_array = array();
                $seller_names_array = array();
                $orderline_ids_array = array();

                $base_product_ids = $orderline_detail[$i]['base_product_id'];
                if (!empty($base_product_ids)) {
                    $base_product_ids_array = explode(',', $base_product_ids);
                }

                $product_names = $orderline_detail[$i]['product_name'];
                if (!empty($product_names)) {
                    $product_names_array = explode(',', $product_names);
                }
                $sizes = $orderline_detail[$i]['size'];
                if (!empty($sizes)) {
                    $sizes_array = explode(',', $sizes);
                }
                $color = $orderline_detail[$i]['color'];

                $status = $orderline_detail[$i]['status'];
                if (!empty($status)) {
                    $status_array = explode(',', $status);
                }


                $qtys = $orderline_detail[$i]['qty'];
                if (!empty($qtys)) {
                    $qtys_array = explode(',', $qtys);
                }
                $unit_prices = $orderline_detail[$i]['unit_price'];
                if (!empty($unit_prices)) {
                    $unit_prices_array = explode(',', $unit_prices);
                }
                if($orderline_detail[$i]['header_shipping_charge']!='0.00')
                {
                   $shipping_charges = $orderline_detail[$i]['header_shipping_charge'];
                   $chksip=10; 
                }
                else
                {
                  $shipping_charges = $orderline_detail[$i]['shipping_charge'];   

                  
                }


                 
                
                if (!empty($shipping_charges))
                 {
                    $shipping_charges_array = explode(',', $shipping_charges);
                }
                /* $total_price_discounts = $orderline_detail[$i]['total_price_discount'];
                  if (!empty($total_price_discounts)) {
                  $total_price_discounts_array = explode(',', $total_price_discounts);
                  }
                  $unit_price_discounts = $orderline_detail[$i]['unit_price_discount'];
                  if (!empty($unit_price_discounts)) {
                  $unit_price_discounts_array = explode(',', $unit_price_discounts);
                  } */
                $seller_names = $orderline_detail[$i]['seller_name'];
                if (!empty($seller_names)) {
                    $seller_names_array = explode(',', $seller_names);
                }
                $orderline_ids = $orderline_detail[$i]['id'];
                if (!empty($orderline_ids)) {
                    $orderline_ids_array = explode(',', $orderline_ids);
                }
                $orderheader_id = $orderline_detail[$i]['order_id'];

                $total_price = $unit_prices_array[0] * array_sum($qtys_array);
                $grandtotal+=$total_price;
                // $total_discount = $unit_price_discounts_array[0] * array_sum($qtys_array);
                // $grand_discount+=$total_discount;
                $wsptotal = '';
                //echo $status_array[0];die;
                // echo $orderline_ids;die;
                if ($status_array[0] == 'Confirmed' || $status_array[0] == 'Shipped' || $status_array[0] == 'Delivered' || $status_array[0] == 'Cancelled' || $status_array[0] == 'ReturnedRequested' || $status_array[0] == 'ReturnedComplete' || $status_array[0] == 'Paid') {
                    $updationclose = FALSE;
                }
                
                ?>
                <div class="dynamic_content">

                    <div class="clearfix"></div> 
                    <div class="row final-productList">
                        <div class="span2" style=" width:200px;">
                            <div class="row finalProd_img">
                                <a href="javascript:void(0)" class="thumbnail">
                                    <?php
                                    $base_product_ids;
                                    if (is_numeric($base_product_ids_array[0])) {
                                        $media_model = new Media();
                                        $image_product = $media_model->getOneMediaByBaseProductId($base_product_ids_array[0]);
                                    }
                                    if (!empty($image_product)) {
                                        echo '<img src="' . $image_product . '">';
                                    } else {
                                        echo '<img src="http://admin.groots.dev.canbrand.in/noimage.jpg">';
                                    }
                                    ?>
                                </a>
                            </div>
                        </div>
                        <div class="span9 finalDetail">

                            <h2>
                                <span>Unit Price <i class="fa fa-inr"></i> <?php if (isset($unit_prices_array[0])) echo $unit_prices_array[0]; ?></span>
                            </h2>
                            <table class = "table">
                                <tbody>
                                    <tr>
                                        <td>Product Name:</td>
                                        <td style="width: 77px;"> <?php echo $orderline_detail[$i]['product_name'];
                                ; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Order Sub id:</td>
                                        <td><?php echo $orderline_ids; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Total Qty:</td>
                                        <td id="tqy_<?php echo array_sum($qtys_array); ?>"><?php echo array_sum($qtys_array)*$sizes_array[0]."&nbsp".$orderline_detail[$i]['pack_unit'];; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Amount: </td>
                                        <td id="tamount_<?php echo $isize; ?>"><i class="fa fa-inr"></i> <?php echo $total_price; ?></td>
                                    </tr>

                                    <tr>
                                </tbody>

                            </table>
                            <!--  <div class="status_top">
                                  <span>status</span>
                                  <span>                                       

                                      <select name="Status[]" class="selectNew" style="width:120px;">
                                          <option value="Pending<><?php //echo $orderline_ids;   ?>" <?php //if ($status_array[0] == 'Pending') echo 'selected="selected"';   ?> >Pending </option>
                                          <option value="Processing<><?php //echo $orderline_ids;   ?>" <?php //if ($status_array[0] == 'Processing') echo 'selected="selected"';   ?> >Processing </option>
                                          <option value="Confirmed<><?php // echo $orderline_ids;   ?>" <?php //if ($status_array[0] == 'Confirmed') echo 'selected="selected"';   ?> > Confirmed </option>
                                          <option value="Out for Delivery<><?php //echo $orderline_ids;   ?>" <?php if ($status_array[0] == 'Out for Delivery') echo 'selected="selected"'; ?>>Out for Delivery</option>
                                          <option value="Shipped<><?php //echo $orderline_ids;   ?>" <?php //if ($status_array[0] == 'shipped') echo 'selected="selected"';   ?>>Shipped</option>
                                          <option value="Delivered<><?php //echo $orderline_ids;   ?>" <?php //if ($status_array[0] == 'Delivered') echo 'selected="selected"';   ?> >Delivered</option>
                                          <option value="Cancelled<><?php //echo $orderline_ids;   ?>" <?php //if ($status_array[0] == 'Cancelled') echo 'selected="selected"';   ?> >Cancelled</option>
                                          <option value="ReturnedRequested<><?php // echo $orderline_ids;   ?>" <?php //if ($status_array[0] == 'ReturnedRequested') echo 'selected="selected"';   ?> >Return Requested</option>
                                          <option value="ReturnedComplete<><?php //echo $orderline_ids;   ?>" <?php //if ($status_array[0] == 'ReturnedComplete') echo 'selected="selected"';   ?>>Return Complete</option>
                                      </select> 
                                  </span>
                              </div> -->
                            <div class="order_sizecontain">
                                <?php
                                $no_baseproducts = count($base_product_ids_array);
                                if ($no_baseproducts > 0) {

                                    for ($j = 0; $j < $no_baseproducts; $j++) {
                                        ?>
                                        <table class = "table">
                                            <tbody>
                                                <tr>
                                                
                                                    <?php  
                                                    if($modelOrder->attributes['status']=="Pending"){?>
                                                         <td style="width: 196px;display: block;">Pack size:</td>
                                                 <?php   }else{?>
                                                     <td style="width: 196px;">Pack size:</td>
                                                <?php  }?>
                                                   
                                                    <td><?php
                                                        if ($sizes_array != Array()) {
                                                            echo $sizes_array[$j]."*".$qtys_array[$j];
                                                            }
                                                        ?></td>
                                                </tr>
                                                <tr>
                                                
                                                    <?php  
                                                    if($modelOrder->attributes['status']=="Pending"){?>
                                                         <td style="width: 196px;display: block;">Pack unit:</td>
                                                 <?php   }else{?>
                                                     <td style="width: 196px;">Pack unit:</td>
                                                <?php  }?>
                                                   
                                                    <td><?php
                                                        if ($sizes_array != Array()) {
                                                            echo  $orderline_detail[$i]['pack_unit'];
                                                            
                                                        }
                                                        ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Order Quantity Update:</td>

                                                    <td> <?php if ($updationclose) { ?>
                                                            <?php
                                                            if ($status_array[0] == 'Confirmed' || $status_array[0] == 'Shipped' || $status_array[0] == 'Delivered' || $status_array[0] == 'Cancelled' || $status_array[0] == 'ReturnedRequested' || $status_array[0] == 'ReturnedComplete') {
                                                                $updationclose = FALSE;
                                                            }
                                                            ?>
                                                            <input type="text" class="form-control size" name="sizeqty[]" id="size4_<?php echo $orderheader_id[$j] . '<:>' . $base_product_ids_array[$j]; ?>" placeholder="0"  style="width:80px;" value="<?php if (isset($qtys_array[$j])) echo $qtys_array[$j]; ?>" onblur="sizecount1(<?php echo $orderheader_id[$j] . "." . $base_product_ids_array[$j]; ?>)">
                                                            <input type="hidden"  name="sizeqty_old[]" placeholder="0"  value="<?php if (isset($qtys_array[$j])) echo $qtys_array[$j]; ?>" >
                                                            <input type="hidden" name="uniq_order_size[]" placeholder="0"  style="width:80px;"
                                                                   value="<?php echo $orderline_ids_array[$j] . '>' . $base_product_ids_array[$j]; ?>" > <?php
                                                               }else {
                                                                   echo $qtys_array[$j];
                                                               }
                                                               ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody></table>
                            </div>
                        </div>

                    </div>
                </div>  
                <input type="hidden" id="id" name="id[]" value="<?php //echo $model[$key]->attributes['id'];             ?>"/>
                <input type="hidden" id="order_id" name="order_id" value="<?php echo $modelOrder->attributes['order_id']; ?>"/> 

                <?php
                $counter++;
                $isize++;
            }
            //shipping charge add
           
            if(!empty($min_order_price)){
                    if(round($grandtotal) < $min_order_price){

                        if($orderline_detail[0]['header_shipping_charge']!='0.00')
                            {
                               $shipping_charge = $orderline_detail[0]['header_shipping_charge'];
                                 $chksip=10; 
                            }
                            else
                            {
                               $shipping_charge = $orderline_detail[0]['shipping_charge'];   

                                
                            }
                       
                }
            }
            else
            {
                   if($orderline_detail[0]['header_shipping_charge']!='0.00')
                            {
                               $shipping_charge = $orderline_detail[0]['header_shipping_charge'];
                                 $chksip=10; 
                            }
                            else
                            {
                               $shipping_charge = $orderline_detail[0]['shipping_charge'];   

                                
                            } 
            }


       

                if($chksip == 0)
                {

                   $updateShiphCharge = OrderLine::model()->shippingChargeUpdateView($order_id,$shipping_charge); 
                }
                
//            $modelOrder->updatelinedescById($modelOrder->attributes['order_id'], $grandtotal, $grand_discount);
            ?> 
            <div class="order_bottomdetails">
                <div class="span5 pull-right">
                    <h3><b>Total:</b> <i class="fa fa-inr"></i> <span id="grandt"><?php echo $grandtotal; ?>
                            <input type="hidden" id="gtotal_price" name="gtotal_price" placeholder="0" value="<?php echo $grand_discount; ?>" >
                        </span></h3>
                    <h3><b>Discount:</b><i class="fa fa-inr"></i> <?php echo $grand_discount; ?>
                        <!--onblur="granddiscount(this.id)"-->
                        <input type="hidden" name="gtotal_price_discount" placeholder="0" class="form-control" style="width:120px;" value="<?php echo $grand_discount; ?>" >
                    </h3>
                    <h3><b>Shipping Charge:</b><i class="fa fa-inr"></i> <?php echo $shipping_charge;?>
                         
                        <!--onblur="granddiscount(this.id)"-->
                        <input type="hidden" id="shipping_charges" name="shipping_charges" placeholder="0" class="form-control" style="width:120px;" value="<?php echo $shipping_charge; ?>" >
                    </h3>
                    <h3><b>Discounted Total:</b><i class="fa fa-inr"></i> <span id="grandtd"> <?php echo ($grandtotal+$shipping_charge) - $grand_discount; ?></span></h3>
                    <input type="hidden" id="grand_total" class="button_new" name="grand_total" value="<?php echo $grandtotal; ?>"/>
                    <input type="hidden" class="button_new" value="<?php echo $isize; ?>" id="isize" name="isize" /> 
                    <input type="submit" class="button_new" value="Update Status" id="Update" name="Update" onclick="checkShippingCharge()"/> 
                    <a href="index.php?r=OrderHeader/report&id=<?php echo $modelOrder->attributes['order_id']; ?>" class="button_new" target="_blank"  >Create Invoice</a>
                </div> 
            </div>
                <?php if($modelOrder->attributes['user_comment']!='')
                {?>   
                <div>
                    <h3><b>Comment :-</b></h3>
                    <?php 
                    echo $modelOrder->attributes['user_comment'];
                    	
                    ?>
                </div>
               <?php  } ?>
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
    <script type="text/javascript">
    var specialKeys = new Array();
    specialKeys.push(8); //Backspace
    
    $(function () {
        $(".dis_price").bind("keypress", function (e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            return ret;
        });
        $(".dis_price").bind("paste", function (e) {
            return false;
        });
        $(".dis_price").bind("drop", function (e) {
            return false;
        });
    });
    function checkShippingCharge(){
       var ship=$("#shipping_charges").val();
    }
</script>
