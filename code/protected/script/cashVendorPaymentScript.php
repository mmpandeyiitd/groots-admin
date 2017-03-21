<?php
$dbConfig = dirname(__FILE__).'/../config/db-config.php';
require_once($dbConfig);
$connection = mysql_connect($localhost,$username, $password);
$today = date('Y-m-d');
$sql = 'select vp.date from groots_orders.vendor_payments as vp where vendor_id = 4 order by vp.date desc limit 1';
$lastPaidDate = mysql_query($sql);
$lastPaidDate = mysql_result($lastPaidDate,0);
if(!$lastPaidDate){
    $lastPaidDate = $today;
}
$sql = 'select sum(pl.price) from groots_orders.purchase_line as pl
          left join groots_orders.purchase_header ph on pl.purchase_id = ph.id where pl.vendor_id = 4 and ph.delivery_date > "'.$lastPaidDate.'" and ph.delivery_date <="'.$today.'" and ph.status = "received"';
$query = mysql_query($sql);
$amount = mysql_result($query,0);

if($amount){
    $sql = 'insert into groots_orders.vendor_payments(vendor_id, paid_amount, date , created_at, status) values(4,'.$amount.',DATE_SUB(CURDATE(), INTERVAL 1 DAY),CURDATE(), 1)';
    $query = mysql_query($sql);
}

?>