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
   
}?>  
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
        vertical-align: top;
    }
</style>

<div class="container">
    <table border="1">
        <tr>
            <td colspan="2">Order Id: <?php echo $modelOrder->attributes['order_number']; ?></td>
            <td colspan="3"><h3>Retail/ Tax Invoice/ Bill</h3></td>
        </tr>
        <tr>
            <td colspan="5">
                <p><strong>Registered Office:</strong> <?php echo $brand_address . '<br>' . $brand_city . '<br>' . $brand_state . '<br>' . $brand_pincode . '<br>' . $brand_country; ?></p>
            </td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">Ph: <?php echo $brand_mobile; ?></td>
            <td colspan="3">www.yorder.com</td>
        </tr>
        <tr>
            <td colspan="3">
                <h3>Shipping Address</h3>
                <h5 style="margin: 0;"><?php echo $modelOrder->attributes['shipping_name']; ?></h5>
                <p><?php echo $modelOrder->attributes['shipping_address'] . ', ' . $modelOrder->attributes['shipping_city'] . ', ' . $modelOrder->attributes['shipping_state'] . ', ' . $modelOrder->attributes['shipping_pincode']; ?></p>
            </td>
            <td colspan="2">
                <h3>Billing Address</h3>
                <h5 style="margin: 0;"><?php echo $modelOrder->attributes['billing_name']; ?></h5>
                <p><?php echo $modelOrder->attributes['billing_address'] . ', ' . $modelOrder->attributes['billing_city'] . ', ' . $modelOrder->attributes['billing_state'] . ', ' . $modelOrder->attributes['billing_pincode']; ?></p>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <p><strong>Sold By: </strong><?php echo $brand_address . ', ' . $brand_city . ', ' . $brand_state . ', ' . $brand_pincode . ', ' . $brand_country;  ?></p>
            </td>
            <td colspan="2">
                VAT/TIN 33696318777<br>
                OD305351980752670003<br>
                Invoice No.<br>
                chn_puzhal_0120160200384478<br>
                DT:29-02-2016

            </td>
        </tr>

        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Tax</th>
            <th>Total</th>
        </tr>

        <?php
        $counter = 0;
        $grandtotal = 0;
        $grand_producttotal = 0;
        $qtytotal = 0;
        $i=0;
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
             
                $qtytotal = $qtytotal +$model[$key]->attributes['product_qty'];
            }
           
            $wsptotal = $qtytotal * ($lineinfodeltail[0]['unit_price'] - $lineinfodeltail[0]['unit_price_discount']);
            $wsptotal = $wsptotal - $lineinfodeltail[0]['total_price_discount'];
            $grandtotal = $wsptotal + $grandtotal;
            $grand_producttotal = $qtytotal + $grand_producttotal;
            
            ?>  
             <?php }?>
            <tr>
                <td>
                    <?php echo $model[$key]->attributes['product_name']; ?>
                </td>
                <td> <?php echo $qtytotal; ?></td>
                <td><?php echo $model[$key]->attributes['unit_price']; ?></td>
                <td><?php echo '0.0'; ?></td>
                <td><?php echo $wsptotal; ?></td>
            </tr>
   
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td><strong>Total</strong></td>
            <td><?php echo $qtytotal; ?></td>
            <td><?php echo $wsptotal; ?></td>
            <td><?php echo '0.0'; ?></td>
            <td><?php echo $grandtotal; ?></td>
        </tr>


    </table>
</div>