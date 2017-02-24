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
        $retailer->updated_at = date("Y-m-d H:i:s");
        $retailer->updated_by = Yii::app()->user->id;
        $retailer->save();
        //print_r($retailer->getErrors());die;
    }

    public function saveCreatePayment($retailer, $post_payment ,$retailerPayment){
        $retailerPayment->attributes = $post_payment;
        $retailerPayment->created_at = date('Y-m-d');
        $retailerPayment->updated_at = date('Y-m-d H:i:s');
        $retailerPayment->updated_by = Yii::app()->user->id;
        if($retailerPayment->payment_type == 'Cheque' && $retailerPayment->cheque_status != 'Cleared'){
            $retailerPayment->status = 0;
            $retailerPayment->save();
        }
        else if ($retailerPayment->save()) {
            self::savePayment($retailer, $retailerPayment->paid_amount);
        }    
        
    }

    public static function saveUpdatePayment($post){
        $retailerPayment = RetailerPayment::model()->findByPk($post['id']);
        $paid_amount = $retailerPayment->paid_amount;
        //$retailerPayment->load($post['RetailerPayment']);
        $intial_status = $retailerPayment->status;
        $retailerPayment->attributes = $post;
        //var_dump(Yii::app()->request());die;
        //$retailerPayment = $retailerPayment->load(Yii::app()->request->post('RetailerPayment'));
        //var_dump($retailerPayment);die;
        $retailerPayment->paid_amount = $post['paid_amount'];
        $retailerPayment->date = $post['date'];
        $retailerPayment->payment_type = $post['payment_type'];
        $retailerPayment->cheque_no = $post['cheque_no'];
        $retailerPayment->status = $post['status'];
        $retailerPayment->comment = $post['comment'];
        $retailerPayment->updated_at = date('Y-m-d H:i:s');
        $retailerPayment->updated_by = Yii::app()->user->id;
        if($retailerPayment->payment_type == 'Cheque'){
            if($retailerPayment->cheque_status != 'Cleared'){
                $retailerPayment->status = 0;
            }
            else{
                $retailerPayment->status = 1;
            }
            
        }
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
      }
      $retailer->updated_at = date("Y-m-d H:i:s");
      $retailer->updated_by = Yii::app()->user->id;
      $retailer->save();
      return $retailerPayment;
  }

      public function getDailyRetailerDetails(){
            $sql = 'select id, name , initial_payable_amount, status,due_date,collection_frequency from retailer where collection_frequency = "Daily"';
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $result = $command->queryAll();
            return $result;
      }

    public function getNonDailyRetailerDetails(){
        $sql = 'select id, name , initial_payable_amount,status,due_date,collection_frequency from retailer where collection_frequency != "Daily"';
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        return $result;
    }
    public function downloadDailyPastReport($dailyDataProvider,$date){
        $fileName = 'PastDailyCollectionReport'.$date.'.csv';
        ob_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);
        if (isset($dailyDataProvider['0'])) {
            $fp = fopen('php://output', 'w');
            $columnstring = implode(',', array_keys($dailyDataProvider['0']));
            $updatecolumn = str_replace('_', ' ', $columnstring);

            $updatecolumn = explode(',', $updatecolumn);
            fputcsv($fp, $updatecolumn);
            foreach ($dailyDataProvider AS $values) {
                fputcsv($fp, $values);
            }
            fclose($fp);
        }
        ob_flush();
    }

    public function downloadNonDailyPastReport($nonDailyDataProvider,$date){
        $fileName = 'PastNonDailyCollectionReport'.$date.'.csv';
        ob_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);
        if (isset($nonDailyDataProvider['0'])) {
            $fp = fopen('php://output', 'w');
            $columnstring = implode(',', array_keys($nonDailyDataProvider['0']));
            $updatecolumn = str_replace('_', ' ', $columnstring);

            $updatecolumn = explode(',', $updatecolumn);
            fputcsv($fp, $updatecolumn);
            foreach ($nonDailyDataProvider AS $values) {
                fputcsv($fp, $values);
            }
            fclose($fp);
        }
        ob_flush();
    }
}
?>