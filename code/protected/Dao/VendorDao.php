<?php 

class VendorDao{
	public function getProcExecutiveDropdownData(){
        $connection = Yii::app()->db;
        $sql = 'select ge.id, ge.name from cb_dev_groots.groots_employee as ge left join employee_department ed on ed.employee_id = ge.id where ed.department_id = 2 and status = 1';
        //echo $sql; die;
        $command = $connection->createCommand($sql);
        $command->execute();
        $data = $command->queryAll();
        $array = array();
        foreach ($data as $key => $value) {
        	$array[$value['id']] = $value['name'];
        }
        return $array;
	}

    public function getVendorProductList($productId){
        $connection = Yii::app()->secondaryDb;
        $sql = 'select vpm.vendor_id, v.name from cb_dev_groots.vendor_product_mapping as vpm left join cb_dev_groots.vendors as v on v.id = vpm.vendor_id where vpm.base_product_id = '.$productId;
        //echo $sql; die;
        $command = $connection->createCommand($sql);
        $command->execute();
        $data = $command->queryAll();
        //var_dump($data);die;
        $array = array();
        foreach ($data as $key => $value) {
            $array[$value['vendor_id']] = $value['name'];
        }
        //var_dump($array);die;
        return $array;
    }

    public function getVendorProductDetails($vendor_id){
        $sql = 'select id, base_product_id, price from cb_dev_groots.vendor_product_mapping where vendor_id = '.$vendor_id;
        $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sql);
        $command->execute();
        $data = $command->queryAll();
        $result = array();
        if(!empty($data)){
            foreach ($data as $key => $value) {
                $result[$value['base_product_id']] = $value;
            }
        }
        return $result;
    }

    public function updateVendorProductById($array){
        foreach ($array as $key => $value) {
            $sql = 'update vendor_product_mapping set price = '.$value['price'].' where id = '.$value['id'];
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->execute();
        }
    }

    public function deleteVendorProductById($ids){
        if(empty($ids))
            return;
        else{
            $sql = 'delete from vendor_product_mapping where id in ('.$ids.')';
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
        }
    }

    public function insertVendorProductById($array, $vendor_id){
        if(empty($array) || count($array) == 0){
            return;
        }
        else{
            $userId = Yii::app()->user->getId();
            $sql = 'insert into vendor_product_mapping values';
            $values = '';
            $count = 1;
            foreach ($array as $key => $value) {
                $values.= '(null,'.$vendor_id.', '.$value['base_product_id'].', '.$value['price'].', 1, CURDATE(), null, '.$userId.')';
                if($count != count($array)){
                    $values.= ', ';
                }
                $count++;
            }
            $sql.= $values;
            $connection = Yii::app()->db;
            //echo $sql;die;
            $command = $connection->createCommand($sql);
            $command->execute();
        }
    }

    public function getVendorTypeDropdownData(){
        $connection = Yii::app()->db;
        $result = Utility::get_enum_values($connection, 'vendors', 'vendor_type' );
        $vendorTypes = array();
        foreach ($result as $key => $value) {
            $vendorTypes[$value['value']] = $value['value'];
        }
        return $vendorTypes;
    }

    public function getAllVendorSkus(){
        $connection = Yii::app()->db;
        $sql = 'select bp.title , vpm.vendor_id from cb_dev_groots.vendor_product_mapping as vpm left join base_product as bp on vpm.base_product_id = bp.base_product_id where bp.priority != 1';
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        $map = array();
        foreach ($result as $key => $value) {
            if(!isset($map[$value['vendor_id']])){
                $map[$value['vendor_id']] = array();
                array_push($map[$value['vendor_id']], $value['title']);
            }
            else{
                array_push($map[$value['vendor_id']], $value['title']);
            }
        }
        return $map;
    }

    public function getAllVendorPayableAmount($startDate, $endDate){
       // $endDate = date('Y-m-d', strtotime($endDate.' + 1 day'));
        //var_dump($endDate);die;
        $connection = Yii::app()->secondaryDb;
        $orderSql = 'select l.vendor_id as vendor_id,  sum(l.price) as price from purchase_header as h left join purchase_line as l on h.id = l.purchase_id where h.delivery_date BETWEEN "'.$startDate.'" AND "'.$endDate.'" and l.status = "pending" and l.price > 0 and (l.received_qty > 0 or l.order_qty > 0) group by l.vendor_id';
        $paymentSql = 'select vendor_id , sum(paid_amount) as paid_amount from vendor_payments where date between "'.$startDate.'" and "'.$endDate.'" and status = 1 group by vendor_id';
        $command = $connection->createCommand($orderSql);
        $orderAmount = $command->queryAll();
        $command = $connection->createCommand($paymentSql);
        $paymentAmount = $command->queryAll();
        $order = array();
        $payment  =array();
        foreach ($orderAmount as $key => $value) {
            if(!empty($value['price']))
                $order[$value['vendor_id']] = $value['price'];
        }
        foreach ($paymentAmount as $key => $value) {
            if(! empty($value['paid_amount']))
                $payment[$value['vendor_id']] = 0 - $value['paid_amount'];
        }
        //var_dump($order, $payment);die;
        foreach ($order as $key => $value) {
            if(array_key_exists($key, $payment)){
                $order[$key] += $payment[$key];
            }
        }
        foreach ($payment as $key => $value) {
            if(! array_key_exists($key, $order)){
                $order[$key] = $value;
            }
        }
        return $order;
    }

    public function getVendorPayableAmount($startDate, $endDate, $vendor_id, $paymentEndDate){
        //$endDate = date('Y-m-d', strtotime($endDate.' + 1 day'));
        //$paymentEndDate = date('Y-m-d', strtotime($paymentEndDate.' + 1 day'));
        $connection = Yii::app()->secondaryDb;
        $orderSql = 'select l.vendor_id as vendor_id,  sum(l.price) as price, h.id from purchase_header as h left join purchase_line as l on h.id = l.purchase_id where h.delivery_date BETWEEN "'.$startDate.'" AND "'.$endDate.'" and l.status = "pending" and (l.vendor_id = '.$vendor_id.' or h.vendor_id = '.$vendor_id.') and l.price > 0 and (l.received_qty > 0 or l.order_qty > 0)' ; //group by h.delivery_date order by h.delivery_date';
        $paymentSql = 'select vendor_id , sum(paid_amount) as paid_amount from vendor_payments where date between "'.$startDate.'" and "'.$paymentEndDate.'" and status = 1 and vendor_id = '.$vendor_id;
        $command = $connection->createCommand($orderSql);
        $orderAmount = $command->queryAll();
        $command = $connection->createCommand($paymentSql);
        $paymentAmount = $command->queryAll();
    //     if($vendor_id == 1){
    //     var_dump($orderAmount);
    //     var_dump($paymentAmount);die;
    // }
        $result = 0;
        foreach ($orderAmount as $key => $value) {
            $result += $value['price'];
            $result -= $paymentAmount[$key]['paid_amount'];
        }
        return $result;
    }

    public function getLastDueDateFrom($startDate, $dueDate, $creditDays){
        if(strtotime($startDate) >= strtotime($dueDate)){
            return $dueDate;
        }
        else{
            while(strtotime($startDate) < strtotime($dueDate)){
                $dueDate = date('Y-m-d', strtotime($dueDate.' - '.$creditDays.' day'));
            }
            return $dueDate;
        }
    }

    public function getPayable($date, $initialPendingDate){
        $criteria = new CDbCriteria;
        $criteria->select = 'id, credit_days, due_date, payment_days_range';
        $criteria->condition = 'status = 1';
        $vendors = Vendor::model()->findAll($criteria);
        $result = array();
        foreach ($vendors as $key => $value) {
          $lastDueDate = self::getLastDueDateFrom($date , $value['due_date'], $value['credit_days']);
          $startDate = date('Y-m-d', strtotime($lastDueDate.' - '.$value['credit_days'].' day'));
          $endDate = date('Y-m-d', strtotime($startDate.' + '.$value['payment_days_range'].' day'));
          $amount = self::getVendorPayableAmount($initialPendingDate, $endDate, $value['id'], $date);
          $result[$value['id']]['amount'] = $amount;
          $result[$value['id']]['dueDate'] = $lastDueDate;
          $result[$value['id']]['lastDueDate'] = date('Y-m-d', strtotime($lastDueDate.' - '.$value['payment_days_range'].' day'));
        }
        return $result;
    }

    public function getVendorOrderQuantity($vendorId){
        $connection = Yii::app()->secondaryDb;
        $sql = 'select pl.id,sum(pl.received_qty) as received_qty, sum(pl.price) as price, ph.delivery_date from purchase_line as pl left join purchase_header as ph on pl.purchase_id = ph.id where pl.status = "pending" and (pl.received_qty > 0 or pl.order_qty > 0) and pl.price > 0 and (pl.vendor_id = '.$vendorId.' or ph.vendor_id = '.$vendorId.') group by ph.delivery_date order by ph.delivery_date';
        // $sql = 'select sum(pl.received_qty) as received_qty, sum(pl.price) as price, ph.delivery_date from purchase_line as pl left join purchase_header as ph on pl.purchase_id = ph.id where pl.status = "pending" and pl.received_qty != null and pl.price != null and pl.vendor_id = 1 and ph.delivery_date != null group by ph.delivery_date order by ph.delivery_date';
        $command = $connection->createCommand($sql);
        $orderedAmount = $command->queryAll();
        //var_dump($orderedAmount);die;
        return $orderedAmount;

    }

    public function getLastPendingDate($date, $initialPendingDate){
        while($date > $initialPendingDate){
            $initialPendingDate = date('Y-m-d', strtotime($initialPendingDate.' - 2 month'));
        }
    }

    public function getInitialPendingDate(){
        $connection = Yii::app()->db;
        $sql = 'select initial_pending_date from vendors limit 1';
        $command = $connection->createCommand($sql);
        return $command->queryScalar();
    }

    public function getAllVendorInitialPending($startDate){
        $map = array();
        $connection = Yii::app()->db;
        $sql = 'select id from vendors where status = 1';
        $command = $connection->createCommand($sql);
        $ids = $command->queryAll();
        foreach ($ids as $key => $value) {
            $sql = 'select total_pending from vendor_log where vendor_id = '.$value['id'].' and base_date = "'.$startDate.'" order by id desc limit 1';
            $command = $connection->createCommand($sql);
            $amount = $command->queryScalar();
            $map[$value['id']] = $amount;
        }
        return $map;
    }

    public function getVendorLastPaymentDetails(){
        $map = array();
        $sql = 'select vp1.vendor_id, vp1.date, sum(vp1.paid_amount) as paid_amount from vendor_payments as vp1 inner join (select max(date) as date, vendor_id from vendor_payments group by vendor_id ) as vp2 on (vp2.date = vp1.date and vp1.vendor_id = vp2.vendor_id and vp1.status = 1) group by vp1.vendor_id, vp1.date';
        $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sql);
        $result  = $command->queryAll();
        //var_dump($result);
        foreach ($result as $key => $value) {
            $map[$value['vendor_id']]['date'] = $value['date'];
            $map[$value['vendor_id']]['amount'] = $value['paid_amount'];
        }
        return $map;
    }

    public function getAllVendorsPriceMap(){
        $sql = 'select base_product_id, vendor_id, price from vendor_product_mapping';
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $data = $command->queryAll();
        $result = array();
        foreach ($data as $key => $value) {
            $result[$value['vendor_id']][$value['base_product_id']] = $value['price'];
        }
        //var_dump($result);die;
        return $result;
    }

}


?>