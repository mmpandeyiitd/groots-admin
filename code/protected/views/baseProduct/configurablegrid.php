<?php
/* @var $this BaseProductController */
/* @var $model BaseProduct */
$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 1) {

    if (!(isset($_GET['store_id'])) || (empty($_GET['store_id']))) {
        $this->redirect(array('site/logout'));
    }
    $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_admin_id'] != $store_id) {
        $this->redirect(array('site/logout'));
    }
    $store_obj = new Store();
    $store_name = $store_obj->getstore_nameByid($store_id);
    $this->breadcrumbs = array(
        'Brand' => array('store/admin'),
        $store_name => array('store/update', "id" => $store_id),
        'Style' => array('admin', "store_id" => $store_id),
        'Recommended Styles',
    );
} else {
    if (!(isset($_GET['store_id'])) || (empty($_GET['store_id']))) {
        $this->redirect(array('site/logout'));
    }
    $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_id'] != $store_id) {
        $this->redirect(array('site/logout'));
    }

    $this->breadcrumbs = array(
        'Style' => array('admin', "store_id" => $store_id),
        'Recommended Styles',
    );
}


#......Menu & Action Visibility.....#
$visible_dropdownmenu = TRUE;
$visible_action_edit = FALSE;
$visible_action_delete = FALSE;
/*if (array_key_exists('baseproduct', Yii::app()->session['premission_info']['module_info'])) {
    if (strstr(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C')) {
        $visible_dropdownmenu = strstr(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C');
    } else {
        $visible_dropdownmenu = FALSE;
    }
}*/
#.........End Visibility.....#

$this->menu = array(
        //  array('label' => 'Create Style', 'url' => array('create',"store_id" => $store_id)),
        // array('label' => 'Bulk Upload Styles', 'url' => array('baseProduct/bulkupload',"store_id" => $store_id)),
        //   array('label' => 'Manage Style', 'url' => array('baseProduct/admin',"store_id" => $store_id)),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#base-product-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
$catgeoryFilter = '';
if (!empty($category_id) AND is_numeric($category_id)) {
    $catgeoryFilter = $category_id;
}
?>
<?php $categoryData = Category::model()->getCategoriesByLevel($level = 2); ?>
<!--<select onchange="addCatFilter(this.value);">
    <option value="">- Please select a Category Filter -</option>
<?php //foreach ($categoryData as $_category) { ?>
        <option value="<?php // echo $_category->category_id;   ?>" <?php
//    if (!empty($category_id) AND $category_id == $_category->category_id) {
//        echo "selected='selected'";
//    }
?>><?php //echo $_category->category_name; ?></option>
<?php //} ?>
</select>-->

<div class="form"  >
    <?php
    $dataprovider = BaseProduct::model()->findAllByAttributes(array('store_id' => $store_id));
    $maxrecord = count($dataprovider);

    for ($i = 0; $i < $maxrecord; $i++) {
        $img = Media::model()->getOneMediaByBaseProductId($dataprovider[$i]['base_product_id']);
        ?>
        <div class="look_grid">
            <a href="#styleinfo<?php echo $dataprovider[$i]['base_product_id']; ?>" role="button" data-toggle="modal" class="detail_top" alt="detail"><i class="fa fa-info"></i></a>
            <a href="index.php?r=baseProduct/addedstyle&id=<?php echo $dataprovider[$i]['base_product_id']; ?>&store_id=<?php echo $store_id; ?>">
                <div class="imagehover-wrap">
                    <img src="<?php if (file_exists($img))
        echo str_replace("main", "original", $img);
    else
        echo 'themes/abound/img/default.jpg';
    ?>"  >

                </div>
                <h4>(<?php echo $dataprovider[$i]['base_product_id']; ?>) - <?php echo $dataprovider[$i]['title']; ?></h4>
            </a>

        </div>
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
        <div id="styleinfo<?php echo $dataprovider[$i]['base_product_id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 id="myModalLabel">Product Information</h5>
            </div>
            <div class="modal-body">
                <table class="table table-hover">

                    <tr>
                        <td>Product Name </td>
                        <td><?php echo $dataprovider[$i]['title']; ?></td>
                    </tr>
                    
                        <td>Color</td>
                        <td><?php if (!empty($dataprovider[$i]['color'])) { ?>
                                <span style="background-color:<?php echo $dataprovider[$i]['color']; ?>" class="proColor"></span><?php } else {
            echo "N/A";
        } ?>
                        </td>
                    </tr>
                   

                    <tr>
                        <td>Status</td>
                        <td><?php
                            if ($dataprovider[$i]['status']) {
                                echo "Published";
                            } else {
                                echo "Unpublished";
                            }
                            ?></td>
                    </tr>
                     <tr>
                        <td>Description</td>
                        <td><?php
                            if (!empty($dataprovider[$i]['description'])) {
                                echo $dataprovider[$i]['description'];
                            } else {
                                echo "N/A";
                            }
                            ?></td>
                    </tr>
    <?php if (!empty($dataprovider[$i]['specofic_keys'])) { ?>
                        <tr>
                            <td>Add Attribute</td>
                            <td><?php //echo $dataprovider[$i]['description'];  ?></td>
                        </tr>


        <?php
        $specofic_keys = json_decode($dataprovider[$i]['specofic_keys'], TRUE);
        if (count($specofic_keys) > 0) {
            foreach ($specofic_keys['specific_key'] as $specific_key => $value) {
                ?>
                                <tr>
                                    <td>   <?php
                                        if (!empty($specific_key)) {
                                            echo $specific_key;
                                        } else {
                                            echo "N/A";
                                        }
                                        ?>  </td>
                                    <td> <?php
                                        if (!empty($value)) {
                                            echo $value;
                                        } else {
                                            echo "N/A";
                                        }
                                        ?></td>
                                </tr>
                <?php
            }
        }
    }
    ?>
                </table>
            </div>
        </div>
<?php } ?>

    <script type="text/javascript">
        $(function () {
            $('.imagehover').tooltip();
        });
    </script>


</div>
<script type="text/javascript">
    var url = '<?php echo Yii::app()->controller->createUrl("baseProduct/configurablegrid"); ?>';
    var store_id =<?php echo $_GET['store_id']; ?>;
    function addCatFilter(catId) {
        if (arguments.length === 0) {
            catId = 0;
        }

        //Relaod with new category id
        if (catId > 0) {
            window.location = url + '&category_id=' + catId + '&store_id=' + store_id;
        } else {
            window.location = url;
        }
    }
</script>