<?php
$file = fopen(dirname(__FILE__).'/../files/Revenue-Final.csv', "r");
echo "<pre>";
$count = 0;
		$username = "root";
		$password = "root";
		$localhost = "localhost";
		$database = "cb_dev_groots";
		$dates = array();
		$connection = mysql_connect($localhost,$username, $password);
while(! feof($file))
  {
  	$row = fgetcsv($file);
  	if($count == 0){
  		for($i = 3 ; $i<=33; $i++){
            $date = DateTime::createFromFormat('d/m/y', $row[$i]);
			$date = date_format($date,"Y-m-d");
  			array_push($dates,$date);
  		}
  		//print_r($dates); die;
  	}
  	if($count > 0){
		$sql1 = "update cb_dev_groots.retailer set initial_payable_amount = ".$row['2']." where id = ".$row['1'].";";
		mysql_query($sql1);
		$num = 3;
		foreach ($dates as $cur_date) {
		    $paid_amount = $row[$num];
            if($paid_amount > 0){
                $sql2 = "insert into groots_orders.retailer_payments (retailer_id, paid_amount, date, created_at) 
					 values (".$row['1'].", ".$paid_amount.", '".$cur_date."', '".$cur_date."');";
                echo $sql2;
                mysql_query($sql2);
                $sql3 = "update cb_dev_groots.retailer set total_payable_amount = total_payable_amount-".$paid_amount." where id = ".$row['1'];
                mysql_query($sql3);
                echo $sql3;
            }

			$num++;

		}
		
  	}
  $count++;


  }
fclose($file);

?>