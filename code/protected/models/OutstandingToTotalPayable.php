<?php
// $retailerModel =dirname(__FILE__).'/protected/models/Retailer.php';
// require_once($retailerModel);
// $paymentModel =dirname(__FILE__).'/protected/models/RetailerPayment.php';
// require_once($paymentModel);
// $orderModel =dirname(__FILE__).'/protected/models/OrderHeader.php';
// require_once($orderModel);

 $retailer= Retailer::model()->findAll();
 foreach ($retailer as $current_retailer) {
 	$retailerId = $current_retailer->id;
 	if($retailerId>0) {
                $retailerOrders = OrderHeader::model()->findAllByAttributes(array('user_id'=>$retailerId ),array('condition'=>'status = "Delivered" and delivery_date >= "2016-09-01"' ,'order'=> 'delivery_date ASC'));
                $retailerPayments = RetailerPayment::model()->findAllByAttributes(array('retailer_id'=>$retailerId), array('condition'=>'status != 0 and date >= "2016-09-01"', 'order'=> 'date ASC'));
    $outstanding = $current_retailer->initial_payable_amount;
    foreach ($retailerOrders as $order) {
	   	$outstanding += $order->total_payable_amount;
    }
    foreach ($retailerPayments as $payment){
    	$outstanding -= $payment->paid_amount;
    }
    $current_retailer->total_payable_amount = $outstanding;
    $current_retailer->save();
 }
}
?>