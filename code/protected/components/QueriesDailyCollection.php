<?php 

class QueriesDailyCollection{

    public static function yesterdayPendingCollectionQuery($w_id){
        $and = "";
         if($w_id < 3){
             $and = " and wa2.id = ".$w_id." ";
         }
        $sql = "SELECT re.name as retailer_name, re.id as id, re.collection_frequency, ca.name as                collection_agent, 
                re.total_payable_amount as total_payable_amount,
                sum(oh.total_payable_amount) as todays_order, re.due_payable_amount, wa.name as warehouse_name,
                wa2.name as collection_center,
                 rep.last_paid_amount, rep.last_paid_on, re.last_due_date
                from cb_dev_groots.retailer as re
                join cb_dev_groots.warehouses as wa2
                on re.collection_center_id = wa2.id and wa2.status = 1 ".$and."
                left join cb_dev_groots.collection_agent as ca
                on re.collection_agent_id = ca.id and ca.status = 1
                left join cb_dev_groots.warehouses as wa
                on re.allocated_warehouse_id = wa.id and wa.status = 1
                left join groots_orders.order_header as oh
                on (oh.user_id = re.id
                and oh.status != 'Delivered'
                and oh.status != 'Cancelled'
                and oh.delivery_date = CURDATE()
                )
                left join (
                            select rep2.retailer_id, rep2.date as last_paid_on,
                                sum(paid_amount) as last_paid_amount 
                            from groots_orders.retailer_payments as rep2 
                            inner join (select retailer_id, max(date) as date 
                                        from groots_orders.retailer_payments where status =1 group by retailer_id
                                        ) as rep1
                            on(rep2.retailer_id = rep1.retailer_id and rep2.date = rep1.date and rep2.status=1)
                            group by rep2.retailer_id, rep2.date
                            ) as rep
                on re.id = rep.retailer_id
                where re.collection_frequency != 'daily'
                group by re.id";
        return $sql;
    }

    public static function yesterdayPendingCollection($w_id){
        $connection = Yii::app()->secondaryDb;
        $sql = self::yesterdayPendingCollectionQuery($w_id);
        //echo $sql; die;
        $command = $connection->createCommand($sql);
        $command->execute();
        return $bsae_id = $command->queryAll();
    }

 public static function downloadBackDateCollectionCsv($w_id){
        $sql = self::yesterdayPendingCollectionQuery($w_id);


        $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sql);
        $command->execute();
        $dataArray = $command->queryAll();
        foreach ($dataArray as $key => $value) {
            $value['total_payable_amount'] = round(Utility::calTotPayAmoByRetailer($value['id']), 2);
            $value['due_payable_amount'] = round(Utility::calLastPayAmoByRetailer($value['id']), 2);
            $dataArray[$key] = $value;
        }
        $fileName = date('Y-m-d')."backDAtecollection.csv";
        ob_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);

        if (isset($dataArray['0'])) {
            $fp = fopen('php://output', 'w');
            $columnstring = implode(',', array_keys($dataArray['0']));
            $updatecolumn = str_replace('_', ' ', $columnstring);

            $updatecolumn = explode(',', $updatecolumn);
            fputcsv($fp, $updatecolumn);
            foreach ($dataArray AS $values) {
                fputcsv($fp, $values);
            }
            fclose($fp);
        }
        ob_flush();
    }

public static function todaysCollectionQuery($w_id){
    $and = "";
    if($w_id < 3){
         $and = " and wa2.id = ".$w_id." ";
    }
    $sql =  "SELECT re.name as retailer_name, re.id as id, re.collection_frequency, ca.name as collection_agent,
                re.total_payable_amount as total_payable_amount, re.due_payable_amount,
                sum(oh.total_payable_amount) as todays_order,wa.name as warehouse_name,
                wa2.name as collection_center, sum(rep.paid_amount) as last_paid_amount
                FROM cb_dev_groots.retailer as re
                join cb_dev_groots.warehouses as wa2
                on re.collection_center_id = wa2.id and wa2.status = 1 ".$and."
                left join cb_dev_groots.collection_agent as ca
                on re.collection_agent_id = ca.id and ca.status = 1
                left join groots_orders.order_header as oh
                on (oh.user_id = re.id 
                    and oh.status != 'Delivered' 
                    and oh.status != 'Cancelled' 
                    and oh.delivery_date = CURDATE()
                    )
                left join cb_dev_groots.warehouses as wa
                on re.allocated_warehouse_id = wa.id 
                left join groots_orders.retailer_payments as rep 
                on re.id = rep.retailer_id and rep.status = 1 and rep.date = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
                where re.total_payable_amount > 0 and re.collection_frequency = 'daily'
                group by re.id";
    return $sql;
}

 public static function todaysCollection($w_id) {
        $connection = Yii::app()->secondaryDb;
        $sql = self::todaysCollectionQuery($w_id);
        $command = $connection->createCommand($sql);
        $command->execute();
        return $bsae_id = $command->queryAll();
    }


 public static function downloadDailyCollectionCsv($w_id){
        $sql = self::todaysCollectionQuery($w_id);
        $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sql);
        $command->execute();
        $dataArray = $command->queryAll();
        foreach ($dataArray as $key => $value) {
            $value['total_payable_amount'] = round(Utility::calTotPayAmoByRetailer($value['id']), 2);
            $value['due_payable_amount'] = round(Utility::calLastPayAmoByRetailer($value['id']), 2);
            $dataArray[$key] = $value;
        }
        $fileName = date('Y-m-d')."collection.csv";
        ob_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);

        if (isset($dataArray['0'])) {
            $fp = fopen('php://output', 'w');
            $columnstring = implode(',', array_keys($dataArray['0']));
            $updatecolumn = str_replace('_', ' ', $columnstring);

            $updatecolumn = explode(',', $updatecolumn);
            fputcsv($fp, $updatecolumn);
            foreach ($dataArray AS $values) {
                fputcsv($fp, $values);
            }
            fclose($fp);
        }
        ob_flush();
    }

 public static function totalPaidAmount(){
    $totalCollection = array();
    $sql = "SELECT sum(rep.paid_amount) AS total_paid_yesterday
            from groots_orders.retailer_payments as rep
            where rep.date = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
            and status  = 1
            ";
     $connection = Yii::app()->secondaryDb;      
    $command = $connection->createCommand($sql);
    $command->execute();
    return $bsae_id = $command->queryAll();
 }

 

}


?>
