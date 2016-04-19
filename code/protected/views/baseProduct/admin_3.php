<?php
/* @var $this CategoryController */
/* @var $model Category */

$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 1) {
    if (!(isset($_GET['store_id'])) || (empty($_GET['store_id']))) {
        $this->redirect(array('site/logout'));
    }
    $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_admin_id'] != $store_id) {
        $this->redirect(array('site/logout'));
    }
    $store_name = Yii::app()->session['store_name'];
    $this->breadcrumbs = array(
        'Brand' => array('store/admin'),
        $store_name => array('store/update', "id" => $store_id),
        'Style' => array('admin', 'store_id' => $store_id),);
} else {
    $store_id = Yii::app()->session['brand_id'];

    if (Yii::app()->session['brand_id'] == '') {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }

    if (Yii::app()->session['brand_id'] != $store_id) {
        $this->redirect(array('site/logout'));
    }
    $this->breadcrumbs = array(
        'Linesheet' => array('admin', 'store_id' => $store_id),
        'Manage',);
}


#......Menu & Action Visibility.....#
$visible_dropdownmenu = FALSE;
$visible_action_edit = FALSE;
$visible_action_delete = FALSE;
if (array_key_exists('baseproduct', Yii::app()->session['premission_info']['module_info'])) {
    if (strstr(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C')) {
        $visible_dropdownmenu = strstr(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C');
    } else {
        $visible_dropdownmenu = FALSE;
    }
    if (strstr(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'U')) {
        $visible_action_edit = strstr(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'U');
    } else {
        $visible_action_edit = FALSE;
    }
}

#.........End Visibility.....#

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
    });
    $('.search-form form').submit(function(){
    $('#category-grid').yiiGridView('update', {
    data: $(this).serialize()
    });
    return false;
    });
    ");
?>

<form method="post" class="grid_form">
    <div class="top_searcstrip">
        <div class="top_searchbox">
            <input type="text" name="searchtext" value="" placeholder ="Search Here" />
            <input type="submit" name="searchsubmit" value="Search"/>
        </div>
    </div>
    <div class="grid_contain">
       
        <?php
        if ($visible_dropdownmenu) {
            ?>
            <div class="add_new">
                <a href="index.php?r=baseProduct/create&store_id=<?php echo $store_id; ?>" title="Add New" type="button" class="imagehover"data-placement='bottom'>
                    <i class="fa fa-plus"></i>
                    <h5>Add New<h5>
                            </a>
                            </div>
                        <?php } ?>

                        <?php
                        if (!empty($search)) {
                            $dataprovider = BaseProduct::model()->getSearchByTitle($search, $store_id);
                            $maxrecord = count($dataprovider);
                        } else {
                            $dataprovider = BaseProduct::model()->findAllByAttributes(array('store_id' => $store_id));
                            $maxrecord = count($dataprovider);
                        }
                        for ($i = 0; $i < $maxrecord; $i++) {
                            $base_product_id = $dataprovider[$i]['base_product_id'];
                            $img = Media::model()->getOneMediaByBaseProductId($base_product_id);
                            ?>
                            <a href="index.php?r=baseProduct/update&id=<?php echo $dataprovider[$i]['base_product_id']; ?>&store_id=<?php echo $store_id; ?>" > 

                                <div class="look_grid ">
                                    <a href="#styleinfo<?php echo $dataprovider[$i]['base_product_id']; ?>" role="button" data-toggle="modal" class="detail_top" alt="detail"><i class="fa fa-info"></i></a>
                                    <a href="index.php?r=baseProduct/update&id=<?php echo $dataprovider[$i]['base_product_id']; ?>&store_id=<?php echo $store_id; ?>">
                                        <div class="imagehover-wrap">
                                            <img src="<?php
                        if (file_exists($img))
                            echo str_replace("main", "original", $img);
                        else
                            echo 'themes/abound/img/default.jpg';
                            ?>"  >

                                        </div>
                                        <h4>(<?php echo $dataprovider[$i]['style_no']; ?>) - <?php echo $dataprovider[$i]['title']; ?></h4></a>
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
                                </div>
                            </a>

                            <div id="styleinfo<?php echo $dataprovider[$i]['base_product_id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h5 id="myModalLabel">Style Information</h5>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-hover">

                                        <tr>
                                            <td>Style Name </td>
                                            <td><?php echo $dataprovider[$i]['title']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Style No. </td>
                                            <td><?php echo $dataprovider[$i]['style_no']; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Color</td>
                                            <td><?php if (!empty($dataprovider[$i]['color'])) { ?>
                                                    <span style="background-color:<?php echo $dataprovider[$i]['color']; ?>" class="proColor"></span><?php } else {
                                    echo "N/A";
                                } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Color Index</td>
                                            <td><?php
                                                if (!empty($dataprovider[$i]['color_index'])) {
                                                    echo $dataprovider[$i]['color_index'];
                                                } else {
                                                    echo "N/A";
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>Size</td>
                                            <td><?php
                                                if (!empty($dataprovider[$i]['size'])) {
                                                    echo $dataprovider[$i]['size'];
                                                } else {
                                                    echo "N/A";
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>Size Brand</td>
                                            <td><?php
                                                if (!empty($dataprovider[$i]['size_brand'])) {
                                                    echo $dataprovider[$i]['size_brand'];
                                                } else {
                                                    echo "N/A";
                                                }
                                                ?></td>
                                        </tr>

                                        <tr>
                                            <td>MRP</td>
                                            <td><?php echo $mrp; ?></td>
                                        </tr>

                                        <tr>
                                            <td>WSP</td>
                                            <td><?php echo $wsp; ?></td>
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
                                            <td>Season</td>

                                            <td><?php
                                                if (!empty($dataprovider[$i]['season'])) {
                                                    echo $dataprovider[$i]['season'];
                                                } else {
                                                    echo "N/A";
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>Available Quantity</td>
                                            <td><?php
                                                if (!empty($dataprovider[$i]['available_quantity'])) {
                                                    echo $dataprovider[$i]['available_quantity'];
                                                } else {
                                                    echo "N/A";
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Minimum Order Quantity</td>
                                            <td><?php echo $dataprovider[$i]['minimum_order_quantity']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Order Place Cut Off Date</td>
                                            <td>
                                                <?php
                                                if (!empty($dataprovider[$i]['order_placement_cut_off_date'])) {
                                                    echo $dataprovider[$i]['order_placement_cut_off_date'];
                                                } else {
                                                    echo "N/A";
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Delivery Date</td>
                                            <td><?php
                                                if (!empty($dataprovider[$i]['delevry_date'])) {
                                                    echo $dataprovider[$i]['delevry_date'];
                                                } else {
                                                    echo "N/A";
                                                }
                                                ?></td>
                                        </tr>

                                        <tr>
                                            <td>Fabric</td>
                                            <td><?php
                                                if (!empty($dataprovider[$i]['fabric'])) {
                                                    echo $dataprovider[$i]['fabric'];
                                                } else {
                                                    echo "N/A";
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
                                                <td><?php //echo $dataprovider[$i]['description'];   ?></td>
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


                        </div>

                        </form>

                        <style type="text/css">
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
