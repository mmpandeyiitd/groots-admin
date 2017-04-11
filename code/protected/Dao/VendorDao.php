<?php 

class VendorDao{
	public function getProcExecutiveDropdownData(){
        $connection = Yii::app()->db;
        $sql = 'select ge.id, ge.name from cb_dev_groots.groots_employee as ge left join employee_department ed on ed.employee_id = ge.id where ed.department_id = 2 and ge.status = 1';
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

    public function getVendorProductList($productId, $w_id){
        $connection = Yii::app()->secondaryDb;
        $sql = 'select vpm.vendor_id, v.bussiness_name from cb_dev_groots.vendor_product_mapping as vpm left join cb_dev_groots.vendors as v on v.id = vpm.vendor_id where vpm.base_product_id = '.$productId.' and v.allocated_warehouse_id = '.$w_id ;
        //echo $sql; die;
        $command = $connection->createCommand($sql);
        $command->execute();
        $data = $command->queryAll();
        //var_dump($data);die;
        $array = array();
        foreach ($data as $key => $value) {
            $array[$value['vendor_id']] = $value['bussiness_name'];
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
        $orderSql = 'select l.vendor_id as vendor_id,  sum(l.price) as price from purchase_header as h left join purchase_line as l on h.id = l.purchase_id where h.delivery_date BETWEEN "'.$startDate.'" AND "'.$endDate.'" and h.status = "received" and l.price > 0 and l.received_qty > 0 group by l.vendor_id';
        $paymentSql = 'select vendor_id,payment_type, cheque_status , sum(paid_amount) as paid_amount from vendor_payments where date between "'.$startDate.'" and "'.$endDate.'" and status = 1 group by vendor_id';
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
            if(!empty($value['paid_amount'])) {
                if (!($value['payment_type'] == 'Cheque' && $value['cheque_status'] != 'Cleared')) {
                    $payment[$value['vendor_id']] = 0 - $value['paid_amount'];
                }
            }
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
        $orderSql = 'select l.vendor_id as vendor_id,  sum(l.price) as price, h.id from purchase_header as h left join purchase_line as l on h.id = l.purchase_id where h.delivery_date BETWEEN "'.$startDate.'" AND "'.$endDate.'" and h.status = "received" and l.vendor_id = '.$vendor_id.'  and l.price > 0 and l.received_qty > 0' ; //group by h.delivery_date order by h.delivery_date';
        $paymentSql = 'select vendor_id,payment_type, cheque_status , sum(paid_amount) as paid_amount from vendor_payments where date between "'.$startDate.'" and "'.$paymentEndDate.'" and status = 1 and vendor_id = '.$vendor_id;
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
        }
        foreach ($paymentAmount as $value){
            if(!empty($value['paid_amount'])) {
                if (!($value['payment_type'] == 'Cheque' && $value['cheque_status'] != 'Cleared')) {
                    $payment[$value['vendor_id']] = 0 - $value['paid_amount'];
                }
            }
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
        $sql = 'select ph.id,sum(pl.received_qty) as received_qty, sum(pl.price) as price, ph.delivery_date from purchase_line as pl left join purchase_header as ph on pl.purchase_id = ph.id where ph.status = "received" and pl.received_qty > 0 and pl.price > 0 and pl.vendor_id = '.$vendorId.' group by ph.delivery_date order by ph.delivery_date';
        //$sql = 'select sum(pl.received_qty) as received_qty, sum(pl.price) as price, ph.delivery_date from purchase_line as pl left join purchase_header as ph on pl.purchase_id = ph.id where pl.status = "pending" and (pl.received_qty > 0 or pl.order_qty > 0) and pl.price > 0 and pl.vendor_id = '.$vendorId.' group by ph.delivery_date order by ph.delivery_date';
        //die($sql);
        $command = $connection->createCommand($sql);
        $orderedAmount = $command->queryAll();
        //var_dump($orderedAmount);die;
        return $orderedAmount;

    }

    public function getLastPendingDate($date, $initialPendingDate){
        while(strtotime($date) > strtotime($initialPendingDate)){
            $initialPendingDate = date('Y-m-d', strtotime($initialPendingDate.' - 2 month'));
        }
        return $initialPendingDate;
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

    public function getLineByPurchasId($vendorId, $purchaseId){
        $connection = Yii::app()->secondaryDb;
        $sql = 'select pl.*, bp.title as product_name , bp.parent_id from purchase_line as pl left join purchase_header as ph on ph.id = pl.purchase_id
        left join cb_dev_groots.base_product as bp on bp.base_product_id = pl.base_product_id where pl.purchase_id = '.$purchaseId.' and pl.vendor_id ='.$vendorId.' and ph.status = "received" and pl.received_qty > 0 and (bp.parent_id > 0 or bp.parent_id is null) ';
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        return $result; 
    }

    public function getVendorProductByIds($prodIds, $vendorId){
        $connection = Yii::app()->db;
        $sql = 'select id, base_product_id, price from vendor_product_mapping where vendor_id = '.$vendorId.' and  base_product_id in ('.$prodIds.')';
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        $map = array();
        if(isset($result)){
            foreach ($result as $key => $value) {
                $map[$value['base_product_id']] = $value;
            }
        }
        return $map;
    }

    public function getVendorSupplyTypeDropdown(){
        $connection = Yii::app()->db;
        $result = Utility::get_enum_values($connection, 'vendors', 'supplier_type' );
        $vendorTypes = array();
        foreach ($result as $key => $value) {
            $vendorTypes[$value['value']] = $value['value'];
        }
        return $vendorTypes;
    }

    public function getVendorInitialPendingAmount($vendor_id){
        $connection = Yii::app()->db;
        $sql = 'select initial_pending_amount from vendors where id = '.$vendor_id;
        $command = $connection->createCommand($sql);
        $amount = $command->queryScalar();
        return (isset($amount)) ? $amount: 0;
    }

    public function downloadLedger($dataArray){
        $fileName = 'VendorPaymert.csv';
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

    public function getLedgerData($vendor_id){
        //echo '<pre>';
        $connection = Yii::app()->secondaryDb;
        $orderQuery = 'select ph.id, GROUP_CONCAT(DISTINCT pl.urd_number order by pl.urd_number asc SEPARATOR ",") as urd_number,sum(pl.received_qty) as received_qty, sum(pl.price) as price, ph.delivery_date as date, "Order" as type
                          from purchase_line as pl left join purchase_header as ph on pl.purchase_id = ph.id 
                          where ph.status = "received" and pl.received_qty > 0 and pl.price > 0 and pl.vendor_id = '.$vendor_id.' 
                          group by ph.delivery_date order by ph.delivery_date';
        $paymentsQuery = 'select *, "Payment" as type from vendor_payments where vendor_id = '.$vendor_id.' and status = 1';
        $command = $connection->createCommand($orderQuery);
        $orders = $command->queryAll();
        $command = $connection->createCommand($paymentsQuery);
        $payments = $command->queryAll();
        $ledgerData = array_merge_recursive($orders, $payments);
        $dataProvider = array();
        foreach ($ledgerData as $key => $value) {
            $type[$key] = $value['type'];
            $date[$key] = $value['date'];
        }
        if (!empty($ledgerData)) {
            array_multisort($date, SORT_ASC, $type, SORT_ASC, $ledgerData);
        }
        $outstanding = VendorDao::getVendorInitialPendingAmount($vendor_id);
        foreach ($ledgerData as $key => $value){
            if($value['type'] == 'Order'){
                $outstanding+= $value['price'];
            }
            else if($value['type'] == 'Payment'){
                if(!($value['payment_type'] == 'Cheque' && $value['cheque_status'] != 'Cleared')){
                    $outstanding-= $value['paid_amount'];
                }
            }
            $value['outstanding'] = $outstanding;
            $ledgerData[$key] = $value;

        }
        $dataProvider = self::makeLedgerDataProvider($ledgerData);
        //echo '<pre>';
        //var_dump($dataProvider);die;
        $result = array('data' => $dataProvider);
        $dataProvider =  new CArrayDataProvider($dataProvider, array(
            'sort'=>array(
                'attributes'=>array('id','date','paid_amount','order_amount', 'order_quantity'),
            ),'pagination'=>array('pageSize'=>100)));
        $result['dataProvider'] = $dataProvider;
        return $result;

    }

    public function makeLedgerDataProvider($ledgerData){
        $dataProvider = array();
        foreach ($ledgerData as $ledgerRow){
            $tmp = array();
            $tmp['id'] = $ledgerRow['id'];
            $tmp['type'] = $ledgerRow['type'];
            $tmp['date'] = $ledgerRow['date'];
            $tmp['urd'] = isset($ledgerRow['urd_number']) ? $ledgerRow['urd_number'] : null;
            $tmp['paid_amount'] = isset($ledgerRow['paid_amount']) ? $ledgerRow['paid_amount']: null;
            $tmp['order_amount'] = isset($ledgerRow['price']) ? $ledgerRow['price']: null;
            $tmp['order_quantity'] = isset($ledgerRow['received_qty']) ? $ledgerRow['received_qty']: null;
            $tmp['paid_amount'] = isset($ledgerRow['paid_amount']) ? $ledgerRow['paid_amount']: null;
            $tmp['outstanding'] = $ledgerRow['outstanding'];
            $tmp['payment_type'] = isset($ledgerRow['payment_type']) ? $ledgerRow['payment_type']: null;
            $tmp['cheque_no'] = (isset($ledgerRow['cheque_no']) && $ledgerRow['payment_type'] == 'Cheque') ? $ledgerRow['cheque_no']: null;
            $tmp['debit_no'] = (isset($ledgerRow['debit_no']) && $ledgerRow['payment_type'] == 'Debit Note') ? $ledgerRow['debit_no']: null;
            $tmp['cheque_status'] = (isset($ledgerRow['cheque_status']) && $ledgerRow['payment_type'] == 'Cheque') ? $ledgerRow['cheque_status']: null;
            $tmp['cheque_issue_date'] = (isset($ledgerRow['cheque_issue_date']) && $ledgerRow['payment_type'] == 'Cheque') ? $ledgerRow['cheque_issue_date']: null;
            $tmp['cheque_name'] = (isset($ledgerRow['cheque_name']) && $ledgerRow['payment_type'] == 'Cheque') ? $ledgerRow['cheque_name']: null;
            $tmp['transaction_id'] = (isset($ledgerRow['transaction_id']) && $ledgerRow['payment_type'] == 'NetBanking') ? $ledgerRow['transaction_id']: null;
            $tmp['receiving_acc_no'] = (isset($ledgerRow['receiving_acc_no']) && $ledgerRow['payment_type'] == 'NetBanking') ? $ledgerRow['receiving_acc_no']: null;
            $tmp['bank_name'] = isset($ledgerRow['bank_name']) ? $ledgerRow['bank_name']: null;
            $tmp['isfc_code'] = isset($ledgerRow['isfc_code']) ? $ledgerRow['isfc_code']: null;
            $tmp['acc_holder_name'] = isset($ledgerRow['acc_holder_name']) ? $ledgerRow['acc_holder_name']: null;
            $tmp['comment'] = isset($ledgerRow['comment']) ? $ledgerRow['comment']: null;
            $tmp['status'] = isset($ledgerRow['status']) ? $ledgerRow['status']: null;
            array_push($dataProvider,$tmp);
        }
        return $dataProvider;
    }

}



?>