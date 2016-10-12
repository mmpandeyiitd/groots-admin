<?php
$file = fopen(dirname(__FILE__).'/../files/procurementRequest.csv', "r");
	echo "<pre>";
		// $username = "root";
		// $password = "root";
		// $localhost = "localhost";
		// $database = "cb_dev_groots";
		// $dates = array();
		// $connection = mysql_connect($localhost,$username, $password);
		$index = 0;
		$dates = array();
while(! feof($file))
  {
  	$row = fgetcsv($file);
  	if($index == 4){
  		for($i = 5 ; $i <= 44 ; i++){
  		$date = date_create($row[$i]);
  		$date = date_format('Y-m-d',$date);
  		array_push($dates, $date);	
  		}
  	}
  	//vegetable update 
  	if($index >= 6 && $index <= 172 && $index >=180 && $index <= 263){
  		$item_name = $row[3];
  		$x = 5;
  		foreach ($dates as $cur_date){
  			if($row[$x] != ' - '){
  			$amount = $row[$x];
  			$sqlVeg = "";
  			mysql_query($sqlVeg);
  		}
  			$x++;
  		}
  	}


  	echo $index;
  	echo "<br>";
  	var_dump($row);
  	$index++;
  }

?>