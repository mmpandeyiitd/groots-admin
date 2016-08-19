<?php
$brand_info = array();
//print_r($model);die;
foreach ($model as $value) {
    $store_id = $value['store_id'];
    if (!empty($store_id)) {
        break;
    }
}
/*if (is_numeric($store_id)) {
    $store_model = new Store();
    $brand_info = $store_model->findAllByAttributes(array('store_id' => 1));
    $maxrecord = count($brand_info);
    $brand_name = '';
    $brand_seller = '';
    $brand_address = '';
    $brand_country = '';
    $brand_state = '';
    $brand_city = '';
    $brand_pincode = '';
    $brand_email = '';
    $brand_mobile = '';
    $shipping_charge = 0;

    if ($maxrecord > 0) {
        for ($i = 0; $i < $maxrecord; $i++) {
            $brand_name = $brand_info[$i]['store_name'];
            $brand_seller = $brand_info[$i]['seller_name'];
            $brand_address = $brand_info[$i]['business_address'];
            $brand_country = $brand_info[$i]['business_address_country'];
            $brand_state = $brand_info[$i]['business_address_state'];
            $brand_city = $brand_info[$i]['business_address_city'];
            $brand_pincode = $brand_info[$i]['business_address_pincode'];
            $brand_email = $brand_info[$i]['email'];
            $brand_mobile = $brand_info[$i]['mobile_numbers'];
        }
    }
}*/
//else{
//    Yii::app()->user->setFlash('premission_info', 'Store id not found.');
//      Yii::app()->controller->redirect("index.php?r=OrderHeader/admin");
//}
?>  



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
<div class="container">
    <table border="1">
        <tr>

            <td colspan="5" style="vertical-align:middle;"><h3 style="margin:0; text-align:center;"> Invoice </h3></td>
        </tr>
        <tr>
            <td width="100%" style="width:100%" colspan="5">
                <table  border="0" style="width:690px">
                    <tr>
                        <td align="left" colspan="4" width="65%" style="vertical-align:top">
                            <table border="0" style="width:100%"><tr><td>
                            <img src="themes/abound/img/logo.png" style="width:150px;"/>
                                    </td>
                             </tr>
                                <tr><td>
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

                                    </td></tr></table>
                        </td>
                        <td align="left" width="200px"></td>

                        <td align="left top" width="35%" style="vertical-align:top">
                            Order Id: <?php echo $modelOrder->attributes['order_number']; ?>
                            <br>
                            <strong>Invoice No : </strong>

                            <?php
                            echo INVOICE_TEXT.date('Y').date('m').$modelOrder->attributes['order_id'];
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="4">

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
            <th style="text-align:left;  padding: 5px; width:40%;"> Product </th>
            <th style="text-align:center; padding: 5px;  width:15%;  "> Total Qty </th>
            <th style="text-align:center; padding: 5px; width:15%;" colspan="1"> Unit price </th>
            <th style="text-align:center; padding: 5px; width:30%;"> Total </th>
        </tr>

        <?php
        $counter = 0;
        $grandtotal = 0;
        $grand_producttotal = 0;
        $qtytotal = 0;
        $qtytotal1 = 0;
        $wsptotal1 = 0;
        $wsptotal = 0;
        $i = 0;
//        echo '<pre>';
        //print_r($model[2]->shipping_charges);die;
//        //echo $model;
        //echo round($model[2]->shipping_charges);    
       if(isset($model[0]->shipping_charges) && !empty(round($model[0]->shipping_charges)))
         {
            $shipping_charge=$model[0]->shipping_charges;
         };
        foreach ($model as $key => $value) {
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
            ?>  

            <tr>
                <td style="text-align:left; width:40%; ">
                    <?php
                    echo wordwrap($model[$key]['product_name'], 20, "<br/>\n");
                    ?>

                </td>
                <td style="text-align:center;  width: 15%;"> <?php
                    echo $model[$key]['product_qty'];
                    echo ' x ';
                    echo $model[$key]['pack_size'];

                    echo $model[$key]['pack_unit'];
                    ?></td>
                <td style="text-align:center;  width: 15%;"><?php echo " Rs. "; ?><?php echo $model[$key]['unit_price']; ?> </td>
                <td style="text-align:center;  width: 30%;"><?php echo " Rs. "; ?><?php echo $model[$key]['price']; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="3" style="text-align:right;"><strong>Shipping Charge </strong></td>
            <td style="text-align:center;"><strong><?php echo " Rs. "; ?> <?php echo $modelOrder->shipping_charges; ?></strong></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:right;"><strong>Total Amount </strong></td>
            <td style="text-align:center;"><strong><?php echo " Rs. "; ?> <?php echo $modelOrder->total_payable_amount; ?></strong></td>
        </tr>
        <?php if ($modelOrder->attributes['user_comment'] != '') { ?>

            <tr>
                <td colspan="4">
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
            <td colspan="4">

                <p style="text-align: center; color:#949494; font-size: 11px; line-height: 14px; margin-bottom: 0;">
                    Thank you for your business! We look forward to serving you again<br>
                    Contact email id: sales@gogroots.com <br>
                    Ordering Support: +91-11-3958-9893<br>
                    Customer Support: +91-11-3958-8984<br>
                    Sales Support: +91-11-3958-9895<br>
                </p>
            </td>

        </tr>


    </table>
</div>
