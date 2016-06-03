<?php
$brand_info = array();
foreach ($model as $key => $value) {
    $store_id = $value->store_id;
    if (!empty($store_id)) {
        break;
    }
}
if (is_numeric($store_id)) {
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
}
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
        width: 795px; 
        border-collapse: collapse; 
        display: block;
        margin: 20px auto 0;
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
            <td colspan="2" style="vertical-align:middle;">Order Id: <?php echo $modelOrder->attributes['order_number']; ?></td>
            <td colspan="3" style="vertical-align:middle;"><h3 style="margin:0; text-align:center;"> Invoice </h3></td>
        </tr>
        <tr>
            <td width="100%" style="width:100%" colspan="5">
                   <table width="100%" border="0" style="width:100%">
                       <tr>
                        <td align="left">
                            
                            <img src="http://admin.groots.dev.canbrand.in/themes/abound/img/logo.png" style="width:150px;"/>
                            
                        </td>
                        <td width="400">&nbsp;</td>
                        <td align="left">
                            <p style="logoRight">
                    <strong>Registered Office:</strong> 
                    <span style="word-wrap: break-word">
                        <?php
                        echo '<br> Address - ';
                        echo wordwrap($brand_address,20, "<br/>\n");
                        ?>
                    </span>
                    <?php echo '<br> City - ' . $brand_city . '<br> State - ' . $brand_state . '<br> Pincode - ' . $brand_pincode . '<br> country - ' . $brand_country; ?></p>
                
                        </td>
                    </tr>
                   </table>
               </td>
        </tr>
        <?php 
             $modelOrderline = new OrderLine;
                $website = $modelOrderline->webiste($modelOrder->attributes['user_id']);
                //echo $website; 
        if($website=='') {?>
         <tr>
            <td colspan="4"><b>Contact no:</b> <?php 
            $modelOrderline = new OrderLine;
                $mobile= $modelOrderline->mobile($modelOrder->attributes['user_id']);
            echo $mobile; ?></td>
         </tr>
        <?php } else { ?>
        <tr>
            <td colspan="2"><b>Contact no:</b> <?php 
            $modelOrderline = new OrderLine;
                $mobile= $modelOrderline->mobile($modelOrder->attributes['user_id']);
            echo $mobile;
            ?></td>
            <td colspan="3"><b>Website:</b> <?php 
             $modelOrderline = new OrderLine;
                $website = $modelOrderline->webiste($modelOrder->attributes['user_id']);
                echo $website; ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="4">
                <h3 style="font-size:16px;">Address:</h3>
                <h5><?php echo $modelOrder->attributes['shipping_name']; ?></h5>
                <p><?php echo $modelOrder->attributes['shipping_address'] . ', ' . $modelOrder->attributes['shipping_city'] . ', ' . $modelOrder->attributes['shipping_state'] . ', ' . $modelOrder->attributes['shipping_pincode']; ?></p>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="vertical-align:middle;">
                <p><strong>Sold By: </strong><?php echo  "Groots";?></p>
            </td>
            <td colspan="1" >
                <br>
                   <strong>Invoice No : </strong>
                
                <?php
                echo $modelOrder->attributes['invoice_number']; 
//                $modelOrderline = new OrderLine;
//                $productname = $modelOrderline->productname($modelOrder->attributes['user_id']);
//
//                $delivery_date = $modelOrder->attributes['delivery_date'];
//                //echo $delivery_date;
//                // echo $productname;die;
//                $name = substr($productname, 0, 3);
//                $mont = date('m', strtotime($delivery_date));
//                $year = date('Y', strtotime($delivery_date));
//                $date = date('d', strtotime($delivery_date));
//                echo $name . $mont . $year . $date;
                ?>
            </td>
        </tr>

        <tr>
            <th style="text-align:center;"> Product </th>
            <th style="text-align:center;"> Qty </th>
            <th style="text-align:center;" colspan="1"> Unit price </th>
            <th style="text-align:center;"> Total </th>
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
//        //echo $model;
//        print_r($model);die;
        foreach ($model as $key => $value) {
            $subcatinfo = new SubscribedProduct;
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
            $grand_producttotal = $qtytotal + $grand_producttotal;
            ?>  

            <tr>
                <td style="text-align:center;">
                    <?php
                        echo wordwrap($model[$key]->attributes['product_name'], 90, "<br/>\n");
                        ?>
                  
                </td>
                <td style="text-align:center;"> <?php
                    echo $model[$key]->attributes['product_qty'] * $model[$key]->attributes['pack_size'];
                    echo ' ';
                    echo $model[$key]->attributes['pack_unit'];
                    ?></td>
                <td style="text-align:center;"><?php echo " Rs. "; ?><?php echo $model[$key]->attributes['unit_price']; ?> </td>
                <td style="text-align:right;"><?php echo " Rs. "; ?><?php echo $wsptotal1; ?></td>
            </tr>
        <?php } ?>

        <tr>
            <td colspan="3" style="text-align:right;"><strong>Total Amount </strong></td>
            <td style="text-align:right;"><?php echo " Rs. "; ?> <?php echo $wsptotal; ?></td>
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
                    Contact number: +91-997-111-4020<br>
                    Contact email id: sales@gogroots.com
                </p>
            </td>

        </tr>
        

    </table>
</div>
