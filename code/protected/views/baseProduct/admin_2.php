<?php $store_id = 2; ?>
<?php foreach ($posts as $post):
    $img = '';
    ?>
    <div class="post">
        
        <span class="look_grid"> 
                <a type="button" class="imagehover" href="javascript:void(0);" > 

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
                    <h5><?php echo $post->title; ?></h5>
                    <h5><?php echo $post->style_no; ?></h5>
                    <?php
                    $mrp = '';
                    $wsp = '';
                    if (!empty($base_product_id) && !empty($store_id)) {
                        $get_test = SubscribedProduct::model()->findAllByAttributes(array('base_product_id' => $base_product_id, 'store_id' => $store_id));
                        $count = count($get_test);
                        if ($count > 0) {
                            $mrp = $get_test[0]['store_price'];
                            $wsp = $get_test[0]['store_offer_price'];
                        }
                    }
                    ?>
                </a>
                <span href="#styleinfo<?php echo $post->base_product_id; ?>" role="button" data-toggle="modal">  <i class="fa fa-info"></i>View Details</span>
    <?php //if ($visible_action_edit) {  ?>
                <span>
                    <a href="index.php?r=baseProduct/update&id=<?php echo $post->base_product_id; ?>&store_id=<?php echo $store_id; ?>"><i class="fa fa-pencil"></i> Edit</a>
                </span>
    <?php //}  ?>
        </span>
    </div>
<?php endforeach; ?>
<?php foreach ($posts as $post):
    $img = '';
    ?>
    <div id="posts" class="post">

        
            <span class="look_grid"> 
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
                    <h5><?php echo $post->title; ?></h5>
                    <h5><?php echo $post->style_no; ?></h5>
                    <?php
                    $mrp = '';
                    $wsp = '';
                    if (!empty($base_product_id) && !empty($store_id)) {
                        $get_test = SubscribedProduct::model()->findAllByAttributes(array('base_product_id' => $base_product_id, 'store_id' => $store_id));
                        $count = count($get_test);
                        if ($count > 0) {
                            $mrp = $get_test[0]['store_price'];
                            $wsp = $get_test[0]['store_offer_price'];
                        }
                    }
                    ?>
                </a>
                <span href="#styleinfo<?php echo $post->base_product_id; ?>" role="button" data-toggle="modal">  <i class="fa fa-info"></i>View Details</span>
    <?php //if ($visible_action_edit) {  ?>
                <span>
                    <a href="index.php?r=baseProduct/update&id=<?php echo $post->base_product_id; ?>&store_id=<?php echo $store_id; ?>"><i class="fa fa-pencil"></i> Edit</a>
                </span>
    <?php //}  ?>
            </span>
    </div>
<?php endforeach;
?>
<?php
$this->widget('ext.yiinfinite-scroll.YiinfiniteScroller', array(
    'itemSelector' => 'div.post',
    'pages' => $pages,
));
?>
<?php
$this->widget('ext.yiinfinite-scroll.YiinfiniteScroller', array(
    'contentSelector' => '#posts',
    'itemSelector' => 'div .post',
    'loadingText' => 'Loading...',
    'donetext' => 'This is the end... my only friend, the end',
    'pages' => $pages,
));
?>