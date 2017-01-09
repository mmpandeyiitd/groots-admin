
<!-- Custom Fonts -->
<style >
    body {
        width: 100%;
        height: 100%;
        // font-family: sans-serif;
        color: #000;
        background-color: #fff;
        margin: 0 ;
        padding: 0;
    }
    html {
        width: 100%;
        height: 100%;
    }
    .container {
        width: 100%; 
        max-width: 1000px;
        margin: 0 auto;
    }
    h1, h2, h3, h4, h5, h6 {
        margin: 0 0 10px;
        //font-family:  sans-serif;
        font-weight: 600;
        letter-spacing: 1px;
    }

    p {
        margin: 0 0 5px;
        font-size: 13px;
        line-height: 20px;
    }
    table {
        //font-family: sans-serif; 
        width: 700px;
        border-collapse: collapse;
        display: block;
        margin: 5px auto 0;
    }
    table tr td {
        padding: 5px;
        vertical-align: middle;
    }
    .logoInvoice {float:left; width:150px;}

    .logoRight {float:right; width:300px;}
</style>
<?php
if($type == "invoice"){
    $title = "Invoice";
    $challanNoText = "Invoice No";
    $text = "";
}
elseif($type == "dc"){
    $title = "Delivery Challan";
    $challanNoText = "DC No";
    $text = "This is the copy of delivery challan. Invoice will be sent to you after the delivery process is completed.";
}
elseif($type == 'mi'){
    $title = "Invoice Email";
    $challanNoText = "Invoice No";
    $text = "";
}


?>
<page>
    <div class="container">
        <table border="1">
            <tr>

                <td colspan="6" style="vertical-align:middle;"><h3 style="margin:0; text-align:center;"> <?php echo $title; ?> </h3></td>
            </tr>
            <tr>
                <td width="100%" style="width:100%" colspan="6">
                    <table  border="1" style="width:690px">
                        <tr>
                            <td  style="vertical-align:top;align:left;width=70%;">
                                <table border="0" style="width:100%">
                                    <tr>
                                        <td>
                                            <img src="themes/abound/img/logo.png" style="width:150px;"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="logoRight">
                                                <strong><?php echo $modelOrder->groots_authorized_name; ?></strong></p>
                                                <p style="logoRight">
                                                    <strong>Registered Office:</strong>
                                                    <span style="word-wrap: break-word">
                                                        <?php
                                                        echo '<br> Address:- ';
                                                        echo wordwrap($modelOrder->groots_address, 50, "<br/>\n");
                                                        ?>
                                                    </span>
                                                    <?php echo  wordwrap($modelOrder->groots_city, 18, "<br/>\n") ."-"  . $modelOrder->groots_pincode; ?></p>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>


                                    <td  style="align:left;width=30%;">
                                        <table border="0" style="width:100%">
                                            <tr >
                                                <td style="border-bottom:1pt solid black;">
                                                    <span style="float:left;">
                                                        <strong>Order Id: </strong><?php echo $modelOrder->attributes['order_number']; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td style="border-bottom:1pt solid black;">
                                                    <span>
                                                        <strong><?php echo $challanNoText;?> : </strong>
                                                        <?php
                                                        $deliveryDateArray = explode("-", $modelOrder->attributes['delivery_date']);
                                                        echo INVOICE_TEXT.$deliveryDateArray[0].$deliveryDateArray[1].$modelOrder->attributes['order_id'];
                                                        ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td style="border-bottom:1pt solid black;">
                                                    <span>
                                                        <strong>Date : </strong>
                                                        <?php
                                                        echo substr($modelOrder->attributes['delivery_date'],0,10);
                                                        ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="6">

                            <strong><?php echo $retailer->attributes['name']; ?></strong>
                            <br>

                            <?php echo $retailer->attributes['address'] . ', ' . $retailer->attributes['city'] . ', ' . $retailer->attributes['state'] . ', ' . $retailer->attributes['pincode']; ?>
                            <br>

                            <?php
                            $modelOrderline = new OrderLine;
                            $mobile = $modelOrderline->mobile($modelOrder->attributes['user_id']);
                            echo '+91-' . $mobile;
                            ?>


                        </td>
                    </tr>



                    <tr>
                        <th style="text-align:left;  padding: 5px; width:7%;"> S.No. </th>
                        <th style="text-align:left;  padding: 5px; width:35%;"> Product </th>
                        <th style="text-align:center; padding: 5px;  width:15%;  "> Units * Pack Size </th>
                        <th style="text-align:center; padding: 5px;  width:15%;  "> Total Qty (Kgs.) </th>
                        <th style="text-align:center; padding: 5px; width:14%;" colspan="1"> Unit price (Rs.) </th>
                        <th style="text-align:center; padding: 5px; width:14%;"> Total (Rs.) </th>
                    </tr>

                    <?php
                    $grossTotal = 0;
                    $qtytotal = 0;
                    $first = true; 
                    $ascii = 97;
                    foreach ($newModel as $key => $model) {

                     ?>
                     <tr><td colspan="6"><strong><?php echo chr($ascii).'. '.$key; ?></strong></td></tr>
                     <?php 
                     $first = false;
                     $counter = 0;
                     $grandtotal = 0;
                     $grand_producttotal = 0;
                     $subtotalQty = 0;
                     $subTotalAmount = 0;
                     $wsptotal1 = 0;
                     $wsptotal = 0;
                     $i = 0;
//        echo '<pre>';
        //print_r($model[2]->shipping_charges);die;
//        //echo $model;
        //echo round($model[2]->shipping_charges);    
                     if(isset($modelOrder->shipping_charges) && !empty(round($modelOrder->shipping_charges)))
                     {
                        $shipping_charge=$modelOrder->shipping_charges;
                    };
                    foreach ($model as $key => $value) {
                        $counter++;
                        $subTotalAmount += $model[$key]['price'];
                        $grossTotal += $model[$key]['price'];
            /*$subcatinfo = new SubscribedProduct;
            $infodetail = $subcatinfo->getinfobyid($model[$key]->attributes['subscribed_product_id']);
            $linedescinfo = new OrderLine;
            $lineinfo = $linedescinfo->getlinedescById($value->id);
            $lineinfodeltail = $linedescinfo->getlinedetailcById($value->id);
            if (!empty($linedescinfo)) {

                $qtytotal1 = $model[$key]->attributes['product_qty'];
                $qtytotal = $qtytotal + $model[$key]->attributes['product_qty'];
            }

            //$wsptotal = $qtytotal * ($lineinfodeltail[0]['unit_price']);
            $wsptotal1 = $qtytotal1 * ($lineinfodeltail[0]['unit_price']);
            // $wsptotal = $wsptotal - $lineinfodeltail[0]['total_price_discount'];
            $wsptotal = $wsptotal + $wsptotal1;
            $grandtotal = $wsptotal + $grandtotal;
            $grand_producttotal = $qtytotal + $grand_producttotal;*/
            $quantityInPacks = '';
            if($type == "invoice"){
                $quantityInPacks = $model[$key]['delivered_qty'];
                if($model[$key]['pack_unit']=='g'){
                   $qtytotal +=  ((float)$quantityInPacks) * ( (float)$model[$key]['pack_size'])/1000;
                   $subtotalQty += ((float)$quantityInPacks) * ( (float)$model[$key]['pack_size'])/1000;
               }
               else{
                $qtytotal +=  ((float)$quantityInPacks) * ((float)$model[$key]['pack_size']);
                $subtotalQty += ((float)$quantityInPacks) * ((float)$model[$key]['pack_size']);
            }
        }
        elseif($type == "dc"){
            $quantityInPacks = $model[$key]['product_qty'];
            if($model[$key]['pack_unit']=='g'){
               $qtytotal +=  ((float)$quantityInPacks) * ( (float)$model[$key]['pack_size'])/1000;
               $subtotalQty += ((float)$quantityInPacks) * ( (float)$model[$key]['pack_size'])/1000;
           }
           else{
            $qtytotal +=  ((float)$quantityInPacks) * ((float)$model[$key]['pack_size']);
            $subtotalQty += ((float)$quantityInPacks) * ((float)$model[$key]['pack_size']);
        }
    }
    ?>  

    <tr>
        <td style="text-align:left; width:7%; ">
            <?php
            echo $counter;
            ?>

        </td>
        <td style="text-align:left; width:35%; ">
            <?php
            echo $model[$key]['product_name'];
            ?>

        </td>
        <td style="text-align:center;  width: 15%;"> <?php
            echo $quantityInPacks;
            echo ' x ';
            echo $model[$key]['pack_size'];

            echo $model[$key]['pack_unit'];
            ?></td>
            <td style="text-align:center;  width: 15%;"> <?php
                if($model[$key]['pack_unit']=='g'){
                   echo  round(((float)$quantityInPacks) * ( (float)$model[$key]['pack_size'])/1000, 2);
               }
               else{
                echo round(((float)$quantityInPacks) * ((float)$model[$key]['pack_size']), 2);
            }

            ?></td>
            <td style="text-align:center;  width: 14%;"><?php echo $model[$key]['unit_price']; ?> </td>
            <td style="text-align:center;  width: 14%;"><?php echo $model[$key]['price']; ?></td>
        </tr>
        <?php }
        $ascii++;
        ?>
        <tr>
            <td style="text-align:left; width:7%;"></td>
            <th style="text-align:center; padding: 5px; width:35%;">Sub-total</th>
            <td style="text-align:center; padding: 5px;  width:15%;  "></td>
            <th style="text-align:center; padding: 5px;  width:15%;  "><?php echo round($subtotalQty, 2) ?></th>
            <td style="text-align:center; padding: 5px; width:14%;" ></td>
            <th style="text-align:center; padding: 5px; width:14%;"><?php echo round($subTotalAmount, 2) ?></th>
        </tr>

        <?php }
        ?>
        <tr><td colspan="6"><strong></strong></td></tr>
        <tr>
            <td colspan = "7" style="text-align:left; width:7%;"></td>
            <th style="text-align:center; padding: 5px; width:35%;">Gross Total</th>
            <td style="text-align:center; padding: 5px;  width:15%;  "></td>
            <th style="text-align:center; padding: 5px;  width:15%;  "><?php echo round($qtytotal, 2) ?></th>
            <td style="text-align:center; padding: 5px; width:14%;" ></td>
            <th style="text-align:center; padding: 5px; width:14%;"><?php echo round($grossTotal, 2) ?></th>
        </tr>

        <tr>
            <td colspan="5" style="text-align:right;"><strong>Shipping Charge (Rs.) </strong></td>
            <td style="text-align:center;"><strong><?php echo $modelOrder->shipping_charges; ?></strong></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align:right;"><strong>Net Total (Rs.) </strong></td>
            <td style="text-align:center;"><strong><?php echo round($grossTotal + $modelOrder->shipping_charges, 2); ?></strong></td>
        </tr>
        <?php if ($modelOrder->attributes['user_comment'] != '') { ?>

        <tr>
            <td colspan="6">
                <strong>Comment : </strong>
                <span style="word-wrap: break-word">
                    <?php
                    echo wordwrap($modelOrder->attributes['user_comment'], 90, "<br/>\n");
                    ?>
                </span>
            </td>

        </tr>

        <?php } ?>
        <tr>
            <td colspan="6">

                <p style="text-align: center; color:#949494; font-size: 11px; line-height: 14px; margin-bottom: 0;">
                    Thank you for your business! We look forward to serving you again<br>
                    Contact email id: <?php echo SALES_SUPPORT_EMAIL;?> <br>
                    Ordering Support: <?php echo ORDER_SUPPORT_NO;?><br>
                    Customer Support: <?php echo CUSTOMER_SUPPORT_NO;?><br>
                    Sales Support: <?php echo SALES_SUPPORT_NO;?><br>
                    <br>
                    <?php echo $text;?><br>
                    All disputes are subject to the jurisdiction of the courts of Delhi.
                </p>
            </td>

        </tr>


    </table>
</div>
<page_footer>
Order Id - <?php echo $modelOrder->attributes['order_number']; ?>
</page_footer>
</page>
