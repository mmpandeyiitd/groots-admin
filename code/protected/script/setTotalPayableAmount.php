<?php

$username = "root";
$password = "root";
$localhost = "localhost";
$database = "cb_dev_groots";
$connection = mysql_connect($localhost,$username, $password);
$sql = 'select id from cb_dev_groots.retailer';
	$result = mysql_query($sql);
	while($row= mysql_fetch_array($result)){
	$retailer_id = $row['id'];
	$query1 = 'select sum(paid_amount) as paid_amount from groots_orders.retailer_payments where retailer_id = '."'".$retailer_id."'".' and date>='."'".'2016-09-01'."'".' and status = 1';

	$query2 = 'select sum(total_payable_amount) as total_payable_amount from groots_orders.order_header where user_id = '."'".$retailer_id."'".' and delivery_date >='."'".'2016-09-01'."'".' and status ='."'".'Delivered'."'";
	$query4 = 'select initial_payable_amount from cb_dev_groots.retailer where id = '."'".$retailer_id."'";
	$paidAmount = mysql_query($query1);
	$payableAmount = mysql_query($query2);
	$initalAmount = mysql_query($query4);
	$initial_payable_amount = mysql_fetch_array($initalAmount);
	$paid_amount = mysql_fetch_array($paidAmount);
	$total_payable_amount = mysql_fetch_array($payableAmount);
	$newPayable = $total_payable_amount[0]-$paid_amount[0] + $initial_payable_amount['initial_payable_amount'];
	$query3 = 'update cb_dev_groots.retailer set total_payable_amount = '."'".$newPayable."'".' where id = '."'".$retailer_id."'";
	$output = mysql_query($query3);

}
?>
