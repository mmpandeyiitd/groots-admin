<!-- Custom Fonts -->
<style>
    body {
        width: 100%;
        height: 100%;
    / / font-family: sans-serif;
        color: #000;
        background-color: #fff;
        margin: 0;
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
    / / font-family: sans-serif;
        font-weight: 600;
        letter-spacing: 1px;
    }

    p {
        margin: 0 0 5px;
        font-size: 13px;
        line-height: 20px;
    }

    table {
    / / font-family: sans-serif;
        width: 700px;
        border-collapse: collapse;
        display: block;
        margin: 5px auto 0;
    }

    table tr td {
        padding: 5px;
        vertical-align: middle;
    }

    .logoInvoice {
        float: left;
        width: 150px;
    }

    .logoRight {
        float: right;
        width: 300px;
    }
</style>
<?php
if($model->payment_type == 'Debit Note'){
    $title = "Debit Note Acknowledgement";
}
else{
    $title = "Payment Acknowledgement";
}

$challanNoText = "Invoice No";
$text = "";


?>
<page>
    <div class="container">
        <table border="1">
            <tr>

                <td colspan="6" style="vertical-align:middle;"><h3
                            style="margin:0; text-align:center;"> <?php echo $title; ?> </h3></td>
            </tr>
            <tr>
                <td width="100%" style="width:100%" colspan="6">
                    <table border="1" style="width:690px">
                        <tr>
                            <td style="vertical-align:top;align:left;width=70%;">
                                <table border="0" style="width:100%">
                                    <tr>
                                        <td>
                                            <img src="themes/abound/img/logo.png" style="width:150px;"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="logoRight">
                                                <strong><?php echo $model->groots_authorized_name; ?></strong></p>
                                            <p style="logoRight">
                                                <strong>Registered Office:</strong>
                                                <span style="word-wrap: break-word">
                                                        <?php
                                                        echo '<br> Address:- ';
                                                        echo wordwrap($model->groots_address, 50, "<br/>\n");
                                                        ?>
                                                    </span>
                                                <?php echo wordwrap($model->groots_city, 18, "<br/>\n") . "-" . $model->groots_pincode; ?>
                                            </p>

                                        </td>
                                    </tr>
                                </table>
                            </td>


                            <td style="align:left;width=30%;">
                                <table border="0" style="width:100%">
                                    <tr>
                                        <td style="border-bottom:1pt solid black;">
                                                    <span style="float:left;">
                                                        <strong>Payment Id: </strong><?php echo $model->id; ?>
                                                    </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-bottom:1pt solid black;">
                                                    <span>
                                                        <strong><?php echo $challanNoText; ?> : </strong>
                                                        <?php
                                                        $deliveryDateArray = explode("-", $model->date);
                                                        echo VENDOR_PAYMENT_INVOICE_TEXT . $deliveryDateArray[0] . $deliveryDateArray[1] . $model->id;
                                                        ?>
                                                    </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-bottom:1pt solid black;">
                                                    <span>
                                                        <strong>Date : </strong>
                                                        <?php
                                                        echo substr($model->date, 0, 10);
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

                    <strong><?php echo $vendor->attributes['name']; ?></strong>
                    <br>

                    <?php echo $vendor->attributes['address'] . ', ' . $vendor->attributes['city'] . ', ' . $vendor->attributes['state'] . ', ' . $vendor->attributes['pincode']; ?>
                    <br>

                    <?php
                    $mobile = $vendor->attributes['mobile'];
                    echo '+91-' . $mobile;
                    ?>


                </td>
            </tr>


<!--            <tr>-->
<!--                <th style="text-align:center;  padding: 5px; width:45%;"> COLUMN NAME</th>-->
<!--                <th style="text-align:center; padding: 5px; width:55%;"> VALUE</th>-->
<!--            </tr>-->
            <tr>
                <td style="text-align:center;  padding: 5px; width:45%;">Payment Type</td>
                <td style="text-align:center; padding: 5px; width:55%;"> <?php echo $model->payment_type?></td>
            </tr>
            <tr>
                <td style="text-align:center;  padding: 5px; width:45%;">Paid Amount</td>
                <td style="text-align:center; padding: 5px; width:55%;"> <?php echo $model->paid_amount?></td>
            </tr>

            <?php if ($model->payment_type == "Cheque"){ ?>
            <tr>
                <td style="text-align:center;  padding: 5px; width:45%;">Cheque Number</td>
                <td style="text-align:center; padding: 5px; width:55%;"> <?php echo $model->cheque_no?></td>
            </tr>
            <tr>
                <td style="text-align:center;  padding: 5px; width:45%;">Cheque Name</td>
                <td style="text-align:center; padding: 5px; width:55%;"> <?php echo $model->cheque_name?></td>
            </tr>
            <tr>
                <td style="text-align:center;  padding: 5px; width:45%;">Cheque Status</td>
                <td style="text-align:center; padding: 5px; width:55%;"> <?php echo $model->cheque_status?></td>
            </tr>
            <tr>
                <td style="text-align:center;  padding: 5px; width:45%;">Cheque Issue Date</td>
                <td style="text-align:center; padding: 5px; width:55%;"> <?php echo $model->cheque_issue_date?></td>
            </tr>
            <?php }
            if($model->payment_type == "NetBanking"){
            ?>
                <tr>
                    <td style="text-align:center;  padding: 5px; width:45%;">Transaction Id</td>
                    <td style="text-align:center; padding: 5px; width:55%;"> <?php echo $model->transaction_id?></td>
                </tr>
            <?php }
            if($model->payment_type != "Cash"){?>
            <tr>
                <td style="text-align:center;  padding: 5px; width:45%;">Account Holder Name</td>
                <td style="text-align:center; padding: 5px; width:55%;"> <?php echo $model->acc_holder_name?></td>
            </tr>
            <tr>
                <td style="text-align:center;  padding: 5px; width:45%;">Receiving Account Number</td>
                <td style="text-align:center; padding: 5px; width:55%;"> <?php echo $model->receiving_acc_no?></td>
            </tr>
            <tr>
                <td style="text-align:center;  padding: 5px; width:45%;">Bank Name</td>
                <td style="text-align:center; padding: 5px; width:55%;"> <?php echo $model->bank_name?></td>
            </tr>
            <tr>
                <td style="text-align:center;  padding: 5px; width:45%;">ISFC Code</td>
                <td style="text-align:center; padding: 5px; width:55%;"> <?php echo $model->isfc_code?></td>
            </tr>
            <?php } ?>
            <tr>
                <td style="text-align:center;  padding: 5px; width:45%;">Comment</td>
                <td style="text-align:center; padding: 5px; width:55%;"> <?php echo $model->comment?></td>
            </tr>
            <tr>
                <td style="height:15px; text-align:center;  padding: 5px; width:45%;">Vendor Signature</td>
                <td style="height:15px; text-align:center; padding: 5px; width:55%;">__________________</td>
            </tr>




<!--            <tr>-->
<!--                <td colspan="6">-->
<!--                    <br>-->
<!--                    <p style="text-align: left; color:#949494; font-size: 11px; line-height: 14px; margin-bottom: 0;">-->
<!--                        --><?php //echo 'Vendor Signature  ..............'; ?>
<!--                        <br><br>-->
<!--                    </p>-->
<!--                </td>-->
<!---->
<!--            </tr>-->


        </table>
    </div>
    <page_footer>
        Purchase Id - <?php echo $model->attributes['id']; ?>
    </page_footer>
</page>
