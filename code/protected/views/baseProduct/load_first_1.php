<?php

$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "root";
$mysql_database = "ecom_stack";
$prefix = "";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
mysql_select_db($mysql_database, $bd) or die("Could not select database");

$store_id = 2;
$last_msg_id = $_POST['last_msg_id'];

$sql = mysql_query("SELECT * FROM base_product WHERE base_product_id < '$last_msg_id' ORDER BY base_product_id DESC LIMIT 5");
$last_msg_id = "";
$return = '';
while ($row = mysql_fetch_array($sql)) {
    $msgID = $row['base_product_id'];
    $msg = $row['title'];
    $img = '';
    ?>

    <?php $return .= '<div  id="<?php echo $msgID; ?>"   align="left" class="message_box" >
    <div class="look_grid ">
            <a type="button" class="imagehover" > 

                <div class="imagehover-wrap" role="button" data-toggle="modal">
                    <img src="themes/abound/img/default.jpg" >
                </div>
                <h5>' . $row['title'] . '</h5>
                <h5>' . $row['style_no'] . '</h5></a>

            <span>
                <a href="index.php?r=baseProduct/update&id="' . $row['base_product_id'] . '&store_id=' . $store_id . '"><i class="fa fa-pencil"></i> Edit</a>
            </span>
   
        </div>

    </div>';
}

echo $return;
die;
?>