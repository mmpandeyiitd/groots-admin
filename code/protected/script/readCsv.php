<?php
//$csv = dirname(__FILE__)./../files/Revenue-Final.csv;
$file = fopen(dirname(__FILE__).'/../files/Revenue-Final.csv', "r");
//$file = fopen('/home/ashu/Projects/Revenue-Final.csv', "r");
//echo "<pre>";
$count = 0;
		$username = "root";
		$password = "root";
		$localhost = "localhost";
		$database = "cb_dev_groots";
		$dates = array();
		$connection = mysql_connect($localhost,$username, $password);
		//echo strtotime('09/03/2016'); die("here");
while(! feof($file))
  {
  	$row = fgetcsv($file);
  	if($count == 0){
  		for($i = 3 ; $i<=33; $i++){
  			$date=date_create("$row[$i]");
			$date = date_format($date,"Y-m-d");
  			echo $date; 
  			array_push($dates,$date);
  		}
  	}
  	if($count > 0){
		var_dump($row);
		$sql1 = "update cb_dev_groots.retailer set initial_payable_amount = ".$row['2']." where id = ".$row['1'].";";
		mysql_query($sql1);
		$num = 3;
		foreach ($dates as $cur_date) {
			$connection = mysql_connect($localhost,$username, $password);
			$sql2 = "insert into groots_orders.retailer_payments (retailer_id, paid_amount, date, created_at) 
					 values (".$row['1'].", ".$row[$num].", '".$cur_date."', '".$cur_date."');";
			$num++;
			mysql_query($sql2);
		}
		
  	}
  $count++;


  }
fclose($file);

?>