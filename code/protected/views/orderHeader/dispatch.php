<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
    $(function () {
        $("#datepicker").datepicker();
    });
</script>
 <?php
 $remaing_qty = 0;
$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 0) {

    if (empty(Yii::app()->session['brand_admin_id']) && empty(Yii::app()->session['brand_id'])) {

        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
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
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
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
        'id' => 'order-header-form1',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($dispatch_model); ?>
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

                <div class="dynamic_content">
                    <div class="span4">

                        <label>Courier Name:</label> <span class="detail">
                            <input type="text" name="courier_name" value="<?php echo $courier_name; ?>"/></span>

                        <div class="clearfix"></div>
                        <label>Tracking No.*:</label> <span class="detail"><input type="text" name="track_id" value="<?php echo $track_id; ?>"/></span>
                        <div class="clearfix"></div>
                        <label>Dispatch Date:</label> 
                        <input type="text" id="datepicker" name="dispatched_date" value="<?php echo $dispatched_date; ?>"/>
                        <div class="clearfix"></div>  
                    </div>
                    <div class="clearfix"></div> 
                   <table   class="tablts" >
                                <tbody>
                                    <tr>
                                        <th nowrap align="center">Product id:</th>
                                        <th nowrap align="center">Total Quantity:</th>
                                        <th nowrap align="center">Remaining Quantity:</th>
                                        <th nowrap align="center">Shipped Quantity:</th>
                                    </tr>
                                    <?php
                                    $counter = 0;
                                    $button_flag=0;
                                    foreach ($model as $key => $value) {
                                        
                                        ?>  
                                        <tr>
                                            <td align="center" >&nbsp;<?php echo $model[$key]->attributes['base_product_id'] ?>
                                                <input type="hidden" value="<?php echo $model[$key]->attributes['base_product_id'] ?>" name="baseproduct_id[]"/></td>
                                            <td align="center">&nbsp;
    <?php echo $model[$key]->attributes['product_qty']; ?>
                                                <input type="hidden" value="<?php echo $model[$key]->attributes['product_qty'] ?>" name="total_qty[]"/></td>
                                                                                      
                                            <td align="center">&nbsp;
                                                <?php
                                                $sum = $dispatch_model->getRemainigQuantityById($modelOrder->attributes['order_id'], $model[$key]->attributes['base_product_id']);
                                                $remaing_qty = $model[$key]->attributes['product_qty'] - $sum;
                                                echo $remaing_qty;
                                                
                                                if($remaing_qty>0){
                                                     $button_flag++;
                                                }
                                                ?>
                                                <input type="hidden" value="<?php echo $remaing_qty; ?>" name="remaining_qty[]"/>
                                            </td> 
                                            <td align="center">&nbsp;<?php if ($remaing_qty > 0) { ?>
                                                <input type="text"  name="qty[]" value="<?php if(isset($qty[$counter])){ echo $qty[$counter];} ?>" style="width:50px;" />
                                                <?php
                                                } else {
                                                    echo $sum;
                                                }
                                                ?></td>
                                        </tr>
                                        <?php
                                        $counter++;
                                    }
                                    if ($button_flag > 0) {
                                        ?>
                                        <tr>
                                            <td  colspan="4"><input type="submit" name="save" value="Save" class="activebutton" /></td>

                                        </tr>
<?php } ?>

                                </tbody>

                            </table>

                </div>  
            </div>
            <input type="hidden" id="id" name="id[]" value="<?php echo $model[$key]->attributes['id']; ?>"/>
            <input type="hidden" id="order_id" name="order_id" value="<?php echo $modelOrder->attributes['order_id']; ?>"/> 



        </div>
    </form>   
<?php $this->endWidget(); ?>
    <script >
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
    <style>
                   table,  th, td {
            border-bottom: 1px solid #ccc; padding: 10px; margin-left: 5px;
}
           </style>


