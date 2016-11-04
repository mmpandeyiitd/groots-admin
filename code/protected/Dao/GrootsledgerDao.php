<?php 

class GrootsledgerDao{

	public static function savePayment($retailer, $paid_amount){
		$retailer->total_payable_amount -= $paid_amount;
		$retailer->due_payable_amount -= $paid_amount;
        if($retailer->due_payable_amount <= 0){
            $retailer->due_payable_amount = 0;
            $retailer->collection_fulfilled = true;
        }
        else{
        	$retailer->collection_fulfilled = false; 
        }
        $retailer->save();
        //print_r($retailer->getErrors());die;
	}

    public static function saveUpdatePayment($post){
        $retailerPayment = RetailerPayment::model()->findByPk($post['RetailerPayment']['id']);
        $paid_amount = $retailerPayment->paid_amount;
        //$retailerPayment->load($post['RetailerPayment']);
        $intial_status = $retailerPayment->status;
        $retailerPayment->attributes = $post['RetailerPayment'];
        //var_dump(Yii::app()->request());die;
        //$retailerPayment = $retailerPayment->load(Yii::app()->request->post('RetailerPayment'));
        //print_r($retailerPayment);die;
        $retailerPayment->paid_amount = $post['RetailerPayment']['paid_amount'];
        $retailerPayment->date = $post['RetailerPayment']['date'];
        $retailerPayment->payment_type = $post['RetailerPayment']['payment_type'];
        $retailerPayment->cheque_no = $post['RetailerPayment']['cheque_no'];
        $retailerPayment->status = $post['RetailerPayment']['status'];
        $retailerPayment->comment = $post['RetailerPayment']['comment'];
        if ($retailerPayment->save()) {

        $retailer = Retailer::model()->findByPk($retailerPayment->retailer_id);
        $retailer->total_payable_amount += $paid_amount;
        $retailer->due_payable_amount += $paid_amount;
        if($intial_status == $retailerPayment->status){
            self::savePayment($retailer, $retailerPayment->paid_amount);
        }
        else{
          $retailer->collection_fulfilled = ($retailer->due_payable_amount <= 0);
        }
        $retailer->save();
        }
}
?>