<?php
$username = "root";
$password = "root";
$localhost = "localhost";
$database = "cb_dev_groots";
$connection = mysql_connect($localhost,$username, $password);
$sql = "select due_date, collection_frequency, status, id from cb_dev_groots.retailer order by id asc";


if ($result=mysql_query($sql))
  {
    echo date("t");
    while($rowinfo=mysql_fetch_array($result)){

    	$days = 0;
    	if($rowinfo['collection_frequency']=='daily')
    		$days = 1;
    	else if($rowinfo['collection_frequency'] =='weekly')
    		$days = 7;
    	else if($rowinfo['collection_frequency'] =='fortnight')
    		$days = 15;
    	else if($rowinfo['collection_frequency'] =='monthly')
    		$days = date("t");
    	else
    		$days = date("t")+15;

        $cur_date = date('Y-m-d');
    	if($rowinfo['status'] == 1 && date('Y-m-d')==date('Y-m-d', strtotime($rowinfo['due_date'].' +'.$days.'days'))){
           
    		$query = "update cb_dev_groots.retailer set due_date = '".date('Y-m-d')."'"." where id = '".$rowinfo['id']."'";
    		mysql_query($query);
    	}
    }
}
else{
	echo "Connection failed!.....";
}
?>