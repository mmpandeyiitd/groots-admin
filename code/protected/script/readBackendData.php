<?php
$file = fopen(dirname(__FILE__).'/../files/procurementRequest.csv', "r");
	echo "<pre>";
		// $username = "root";
		// $password = "root";
		// $localhost = "localhost";
		// $database = "cb_dev_groots";
		// $dates = array();
		// $connection = mysql_connect($localhost,$username, $password);
		$count = 0;
		$dates = array();
while(! feof($file))
  {
  	$row = fgetcsv($file);
  	// if($count == 4){
  	// 	for($i = 5 ; $i <= 44 ; i++){
  	// 	$date = date_create($row[$i]);
  	// 	$date = date_format('Y-m-d',$date);
  	// 	array_push($dates, $date);	
  	// 	}
  	// }
  	
  	echo $count;
  	echo "<br>";
  	var_dump($row);
  	$count++;
  }

?>