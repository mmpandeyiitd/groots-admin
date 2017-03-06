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

    public function downloadIntervalCollectionReport($fromDate, $toDate){
        echo '<pre>';
       $connection = Yii::app()->db;
       $sql1 = 'select retailer_id, paid_amount , payment_type , date, cheque_status from groots_orders.retailer_payments where date >= "2016-09-01"
                  and date <="'.$toDate.'" and status != 0';
       $sql2 = 'select user_id , total_payable_amount, delivery_date from groots_orders.order_header 
                  where delivery_date >= "2016-09-01" and delivery_date <= "'.$toDate.'" and status = "Delivered"';
       $command = $connection->createCommand($sql1);
       $payments = $command->queryAll();
       $command = $connection->createCommand($sql2);
       $orders = $command->queryAll();
       $data = self::calRetailerPayableAmount($payments, $orders,$fromDate);
       $finalData = array();
       foreach ($data['initial'] as $id => $initial){
           $prev = $initial+Retailer::getInitialPayableAmount($id);
           $date = $fromDate;
           $finalData[$id] = array();
           while(strtotime($date) <= strtotime($toDate)){
               $finalData[$id][$date] = $prev;
               $constraint = $date.'~'.$id;
               $finalData[$id][$date] = (isset($data['order'][$constraint])) ? $finalData[$id][$date]+(float)$data['order'][$constraint] : $finalData[$id][$date];
               $finalData[$id][$date] = (isset($data['payment'][$constraint])) ? $finalData[$id][$date]-(float)$data['payment'][$constraint] : $finalData[$id][$date];
               $prev = $finalData[$id][$date];
               $date = date('Y-m-d', strtotime('+1 Day', strtotime($date)));
           }
       }
       self::makeIntervalCollectionCsv($finalData, $fromDate, $toDate);
    }

    public function calRetailerPayableAmount($payments, $orders, $fromDate){
        $orderArr = $paymentArr = array();
        $initial = array();
        foreach ($payments as $payment) {
            if(strtotime($payment['date']) <= strtotime($fromDate)){
                if (!($payment['payment_type'] == "Cheque" && $payment['cheque_status'] != "Cleared")) {
                    if (isset($initial[$payment['retailer_id']])) {
                        $initial[$payment['retailer_id']] -= $payment['paid_amount'];
                    } else {
                        $initial[$payment['retailer_id']] = $payment['paid_amount'];
                    }
                }
            }
            else {
                if (!($payment['payment_type'] == "Cheque" && $payment['cheque_status'] != "Cleared")) {
                    $paymentArr[$payment['date'].'~'.$payment['retailer_id']] = $payment['paid_amount'];
                }

            }
        }

        foreach ($orders as $order){
            if(strtotime($order['delivery_date']) <= strtotime($fromDate)){
                if(isset($initial[$order['user_id']])) {
                    $initial[$order['user_id']] += $order['total_payable_amount'];
                }
                else{
                    $initial[$order['user_id']] = $order['total_payable_amount'];
                }
            }
            else{
                $orderArr[$order['delivery_date'].'~'.$order['user_id']] = $order['total_payable_amount'];
            }
        }

        return array('initial' => $initial, 'order' => $orderArr, 'payment' => $paymentArr);
    }

    public function makeIntervalCollectionCsv($data,$fromDate, $toDate){
        $fileName = $fromDate.'~'.$toDate.'collection.csv';
        ob_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);
        $fp = fopen('php://output', 'w');
        $date = $fromDate;
        $header = array('Client Name');
        while($date <= $toDate){
            array_push($header,$date);
            $date = date('Y-m-d', strtotime('+1 Day', strtotime($date)));
        }
        fputcsv($fp,$header);
        foreach ($data as $id => $row){
            $date = $fromDate;
            $line = array($id);
            while(strtotime($date)<= strtotime($toDate)){
                array_push($line,$row[$date]);
                $date = date('Y-m-d', strtotime('+1 Day', strtotime($date)));
            }
            fputcsv($fp,$line);

        }
        fclose($fp);
        ob_flush();


    }
}
?>