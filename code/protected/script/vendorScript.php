<?php

$vendorDao = dirname(__FILE__).'/../Dao/VendorDao.php';
require_once($vendorDao);
$username = "root";
$password = "root";
$localhost = "localhost";
$connection = mysql_connect($localhost,$username, $password);

mysql_select_db('cb_dev_groots');
$sql = 'select due_date, id, name, payment_start_date, payment_days_range from cb_dev_groots.vendors where status = 1';
$query = mysql_query($sql);
$rows = mysql_num_rows($query);
$i=0;
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime($today.' - 1 day'));
while($i< $rows){
	$current = mysql_fetch_array($query);
	if(strtotime($current['due_date']) == strtotime($yesterday)){
		$newDueDate = date('Y-m-d', strtotime($current['due_date'].' + '.$current['payment_days_range'].' day'));
		$newStartDate = date('Y-m-d', strtotime($current['payment_start_date'].' + '.$current['payment_days_range'].' day'));
		$sql2 = 'update vendors set due_date = "'.$newDueDate.'", payment_start_date = "'.$newStartDate.'" where id = '.$current['id'];

		$update = mysql_query($sql2);
	}
	$i++;
}

$pays = VendorDao::getAllVendorPayableAmount('2016-10-01', '2016-12-23');
var_dump($pays);die;
?>