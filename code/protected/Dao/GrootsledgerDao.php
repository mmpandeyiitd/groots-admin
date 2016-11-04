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
	}

}
?>