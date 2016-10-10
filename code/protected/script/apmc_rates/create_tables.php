<?php
$linker = mysqli_connect("localhost", "root", "Aakash24.duaa", "daily_rates");

    if (!$linker) {
      echo "Error: Unable to connect to MySQL." . PHP_EOL;
      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
      echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
      exit;
    }

    echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
    echo "Host information: " . mysqli_get_host_info($linker) . PHP_EOL;
     // connection estabilised   
//$sql = "CREATE DATABASE daily_rates"
$sqll="CREATE TABLE DailyData (   date date DEFAULT NULL,   item varchar(256) DEFAULT NULL,   place varchar(256) DEFAULT NULL,   variety varchar(256) DEFAULT NULL,   weight varchar(256) DEFAULT NULL,   unit varchar(256) DEFAULT NULL,   type_of_packing varchar(256) DEFAULT NULL,   grade_size varchar(256) DEFAULT NULL,   price_mini varchar(256) DEFAULT NULL,   price_modal varchar(256) DEFAULT NULL,   price_max varchar(256) DEFAULT NULL )";



if ($linker->query($sqll) === TRUE) {
        echo "New record created successfully \n ";
    } else {
    echo "Error: " . $sqll . "<br>" . $linker->error;
    }

 $que = "CREATE TABLE price_header (id int(40) AUTO_INCREMENT ,date date ,city varchar(256) DEFAULT NULL,mandi varchar(256),status enum('success','failure'),PRIMARY KEY (id))"; 
 
 if ($linker->query($que) === TRUE) {
        echo "New record created successfully \n ";
    } else {
    echo "Error: " . $que . "<br>" . $linker->error;
    }  

$linker->close();


?>