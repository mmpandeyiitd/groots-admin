<?php
$store_id = 2;
$last_msg_id = $_GET['last_msg_id'];
$sql = mysql_query("SELECT * FROM base_product WHERE base_product_id < '$last_msg_id' ORDER BY base_product_id DESC LIMIT 5");
$last_msg_id = "";

while ($row = mysql_fetch_array($sql)) {
    $msgID = $row['base_product_id'];
    $msg = $row['title'];
    $img = '';
    ?>

    <div  id="<?php echo $msgID; ?>"   align="left" class="message_box" >
        <div class="look_grid ">
            <a type="button" class="imagehover" > 

                <div class="imagehover-wrap" role="button" data-toggle="modal">
                    <img src="<?php
                    if (file_exists($img))
                        echo str_replace("main", "original", $img);
                    else
                        echo 'themes/abound/img/default.jpg';
                    ?>"  >
                    <!-- <div id="hover_content">
                      <span>Style No : #ST0001</span>
                    </div>  -->
                </div>
                <h5><?php echo $row['title']; ?></h5>
                <h5><?php echo $row['style_no']; ?></h5>
                <?php
                $mrp = '';
                $wsp = '';
                if (!empty($base_product_id) && !empty($store_id)) {

                    $get_test = SubscribedProduct::model()->findAllByAttributes(array('base_product_id' => $msgID, 'store_id' => 2));
                    $count = count($get_test);
                    if ($count > 0) {
                        $mrp = $get_test[0]['store_price'];
                        $wsp = $get_test[0]['store_offer_price'];
                    }
                }
                ?>
            </a>
            <span href="#styleinfo<?php echo $row['base_product_id']; ?>" role="button" data-toggle="modal">  <i class="fa fa-info"></i>View Details</span>
            <?php // if ($visible_action_edit) { ?>
            <span>
                <a href="index.php?r=baseProduct/update&id=<?php echo $row['base_product_id']; ?>&store_id=<?php echo $store_id; ?>"><i class="fa fa-pencil"></i> Edit</a>
            </span>
            <?php //} ?>
        </div>

    </div>


    <?php
}
?>    <style type="text/css">
    .modal-backdrop, .modal-backdrop.fade.in {opacity: 0.2;}
    #floatbar {
        position:relative;
    }

    .popup {
        position:absolute;
        top:10px;
        left:0px;
        height:30px;
        background:#ccc;
        display:none;
    }
</style>