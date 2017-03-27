<?php
$dbConfig = dirname(__FILE__).'/../config/db-config.php';
require_once($dbConfig);
$connection = mysql_connect($localhost,$username, $password);
function getAllVendorPayableAmount($startDate, $endDate){
    $orderSql = 'select l.vendor_id as vendor_id,  sum(l.price) as price from groots_orders.purchase_header as h left join groots_orders.purchase_line as l on h.id = l.purchase_id where h.delivery_date BETWEEN "'.$startDate.'" AND "'.$endDate.'" and h.status = "received" and l.price > 0 and (l.received_qty > 0 or l.order_qty > 0) group by l.vendor_id';
    $paymentSql = 'select vendor_id, payment_type, cheque_status , paid_amount as paid_amount from groots_orders.vendor_payments where date between "'.$startDate.'" and "'.$endDate.'" and status = 1 ';
    $result1 = mysql_query($orderSql);
    $rows1 = mysql_num_rows($result1);
    $i = 0;
    $orderAmount = array();
    while($i < $rows1){
        $temp = mysql_fetch_array($result1);
        array_push($orderAmount, $temp);
        $i++;
    }
    $result2 = mysql_query($paymentSql);
    $rows1 = mysql_num_rows($result2);
    $i = 0;
    $paymentAmount = array();
    while($i < $rows1){
        $temp = mysql_fetch_array($result2);
        array_push($paymentAmount, $temp);
        $i++;
    }
    $order = array();
    $payment  =array();
    foreach ($orderAmount as $key => $value) {
        if(!empty($value['price']))
            $order[$value['vendor_id']] = $value['price'];
    }
    foreach ($paymentAmount as $key => $value) {
        if(!empty($value['paid_amount'])) {
            if (!($value['payment_type'] == 'Cheque' && $value['cheque_status'] != 'Cleared')) {
                if(array_key_exists($value['vendor_id'], $payment)){
                    $payment[$value['vendor_id']] -= $value['paid_amount'];
                }
                else{
                    $payment[$value['vendor_id']] = 0 - $value['paid_amount'];
                }
            }
        }
    }
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
//get initial pendingmap for all vendors with startdate = initialPendingDate for that vendor
function getAllVendorInitialPending($startDate){
    $map = array();
    $sql = 'select id from cb_dev_groots.vendors where status = 1';
    $result = mysql_query($sql);
    $rows = mysql_num_rows($result);
    $i = 0;
    $ids = array();
    while($i < $rows){
        $temp = mysql_fetch_array($result);
        array_push($ids, $temp);
        $i++;
    }//base_date(vendor_log) = initial_pending_date of that vendor
    foreach ($ids as $key => $value) {
        $sql = 'select total_pending from cb_dev_groots.vendor_log where vendor_id = '.$value['id'].' and base_date = "'.$startDate.'" order by id desc limit 1';
        $result = mysql_query($sql);
        $amount = mysql_fetch_array($result);
        $map[$value['id']] = (!empty($result)) ? $amount['total_pending'] : 0   ;
    }
    return $map;
}



date_default_timezone_set("Asia/Kolkata");
mysql_select_db('cb_dev_groots');
$sql = 'select due_date, id, name, payment_start_date, payment_days_range, initial_pending_date, initial_pending_amount from cb_dev_groots.vendors where status = 1';
$query = mysql_query($sql);
$rows = mysql_num_rows($query);
$i=0;
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime($today.' - 1 day'));
$initial_pending_date = mysql_result($query, 0, 3);
mysql_data_seek($query, 0);
$initialPendingMap = getAllVendorInitialPending($initial_pending_date);
$totalPendingMap = getAllVendorPayableAmount(date('Y-m-d', strtotime($initial_pending_date.' + 1 day')), $yesterday);
while($i < $rows){
    //update due_date for current vendor
    $current = mysql_fetch_array($query);
    if(strtotime($current['due_date']) == strtotime($yesterday)){
        $newDueDate = date('Y-m-d', strtotime($current['due_date'].' + '.$current['payment_days_range'].' day'));
        $newStartDate = date('Y-m-d', strtotime($current['payment_start_date'].' + '.$current['payment_days_range'].' day'));
        $sql2 = 'update vendors set due_date = "'.$newDueDate.'", payment_start_date = "'.$newStartDate.'" where id = '.$current['id'];

        $update = mysql_query($sql2);
    }//uodate initial_pending_date and initial_pending_amount vendor for current vendor
    $totalNow = $initialPendingMap[$current['id']] + $totalPendingMap[$current['id']];
    $checkLog = 'select id from vendor_log where vendor_id = '.$current['id'];
    $query = mysql_query($checkLog);
    $rows = mysql_num_rows($query);
    if($rows==0){
        $insertVendorLog = 'insert into vendor_log VALUES(null, '.$current['id'].', '.$totalNow.', "'.$initial_pending_date.'", CURDATE(), null)';
        $query = mysql_query($insertVendorLog);
    }
    if(strtotime($yesterday) == strtotime(date('Y-m-d', strtotime($current['initial_pending_date'].' + 2 month')))){
        $newBaseDate = date('Y-m-d', strtotime($current['initial_pending_date'].' + 2 month'));
        $updateLog = 'insert into vendor_log values(null, '.$current['id'].', '.$totalNow.', "'.$newBaseDate.'", CURDATE(), null)';
        $updateVendorTable = 'update vendors set initial_pending_date = "'.$yesterday.'" , initial_pending_amount = "'.$totalNow.'" where id = '.$current['id']	;
        $update = mysql_query($updateVendorTable);
        $update = mysql_query($updateLog);
    }
    $i++;
}


?>