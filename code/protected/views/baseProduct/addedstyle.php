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

    $store_name = Store::model()->getstore_nameByid($store_id);
    if (isset($_GET['id'])) {
        $style_id = $_GET['id'];
        $style_title = BaseProduct::getStyleTitleByID($style_id, $store_id);
    }
    $this->breadcrumbs = array(
        'Brand' => array('store/admin'),
        $store_name => array('store/update', "id" => $store_id),
        'Style' => array('admin', "store_id" => $store_id),
        'Add Recommended Styles',
    );
} else {
    if (!(isset($_GET['store_id'])) || (empty($_GET['store_id']))) {
        $this->redirect(array('site/logout'));
    }
    $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_id'] != $store_id) {
        $this->redirect(array('site/logout'));
    }
    if (isset($_GET['id'])) {
        $style_id = $_GET['id'];
        $style_title = BaseProduct::getStyleTitleByID($style_id, $store_id);
    }
}
$this->breadcrumbs = array(
     'Style' => array('admin', "store_id" => $store_id),
    'Recommended Styles' => array('configurablegrid','id'=>$style_id,"store_id" => $store_id,),
    'Add Styles In ' . $style_title,
);

$baseproduct_id = 0;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $baseproduct_id = $_GET['id'];
}


if (!empty($category_id)) {
    $this->breadcrumbs['Configurable Products']['category_id'] = $category_id;
}
//echo $model->configurable_with;die;
#......Menu & Action Visibility.....#
$visible_dropdownmenu = FALSE;
$visible_action_edit = FALSE;
$visible_action_delete = FALSE;
/*if (array_key_exists('baseproduct', Yii::app()->session['premission_info']['module_info'])) {
    if (strstr(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C')) {
        $visible_dropdownmenu = strstr(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C');
    } else {
        $visible_dropdownmenu = FALSE;
    }
}*/
$visible_dropdownmenu = true;
#.........End Visibility.....#
?>

<?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')): ?><div class="flash-error"><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>

    <?php
$ids = null;
?>

<form name="frm" method="post">
    <div class="form"  >
        <input type="hidden" id="oldIds" name="store_id" value="<?php echo $store_id; ?>">
        <input type="hidden" id="selectedIds" name="selectedIds" value="<?php echo $model->configurable_with; ?>">
        <input type="hidden" id="oldIds" name="oldIds" value="<?php echo $model->configurable_with; ?>">
   <input type="hidden" id="category_id" name="category_id" value="<?php echo $category_id; ?>"> 
        <?php
        $dataprovider = $base_product_model->getBaseProductListByIds($model->configurable_with);
        $maxrecord = count($dataprovider);
       
        if ($visible_dropdownmenu) {
            ?>
            <div class="add_new">
                <a href="index.php?r=baseProduct/configurable_group&id=<?php echo $baseproduct_id; ?>&store_id=<?php echo $store_id; ?>" title="Add New" type="button" class="imagehover"data-placement='bottom'>
                    <i class="fa fa-plus"></i>
                    <h5>Add New<h5>
                            </a>
                            </div>
                            <?php
                        }
                        if (!empty($dataprovider)) {

                            for ($i = 0; $i < $maxrecord; $i++) {

                                $img = Media::model()->getOneMediaByBaseProductId($dataprovider[$i]['base_product_id']);
                                ?>
                                <div class="look_grid" onclick="chech_checkbox(<?php echo $dataprovider[$i]['base_product_id']; ?>);" style="cursor: pointer;">
                                    <a href="#styleinfo<?php echo $dataprovider[$i]['base_product_id']; ?>" role="button" data-toggle="modal" class="detail_top" alt="detail"><i class="fa fa-info"></i></a>
                                    <a type="button" class="imagehover" data-placement='right'> 
                                        <div class="imagehover-wrap">
                                            <div class="check_new_span"  style="display:none;" id="check-div<?php echo $dataprovider[$i]['base_product_id']; ?>" >
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <img src="<?php if (file_exists($img)) echo str_replace("main", "original", $img);
                        else echo 'themes/abound/img/default.jpg'; ?>"  >
                                        </div>

                                        <h4>(<?php echo $dataprovider[$i]['style_no']; ?>) - <?php echo $dataprovider[$i]['title']; ?></h4></a>                                   
                                        <input  name="baseproduct[]" type="checkbox" id="checkboxid<?php echo $dataprovider[$i]['base_product_id']; ?>" value="<?php echo $dataprovider[$i]['base_product_id']; ?>" style="display: none;">
                                   
                                </div>
                                <?php
                                $mrp = '';
                                $wsp = '';
                                if (!empty($dataprovider[$i]['base_product_id']) && !empty($store_id)) {
                                    $get_test = SubscribedProduct::model()->findAllByAttributes(array('base_product_id' => $dataprovider[$i]['base_product_id'], 'store_id' => $store_id));
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
                                        <td><?php if (!empty($dataprovider[$i]['color'])) {?>
                                            <span style="background-color:<?php echo $dataprovider[$i]['color']; ?>" class="proColor"></span><?php } else { echo "N/A"; }?>
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
    <?php }
} ?>

                        <script type="text/javascript">
                            $(function () {
                                $('.imagehover').tooltip();
                            });
                        </script>

<?php if($maxrecord>0){?>
                        <div class="span12">
                            <div class=>
                                <input type="submit" class="center_btn" name="remove" value="Remove">
                            </div>
                        </div>
<?php }?>
                        </div>
                        <script >
                            function chech_checkbox(id) {
                                if (document.getElementById("checkboxid" + id).checked) {
                                    document.getElementById("check-div" + id).style.display = "none";
                                    document.getElementById("checkboxid" + id).checked = false;
                                } else {
                                    document.getElementById("check-div" + id).style.display = "inline";
                                    document.getElementById("checkboxid" + id).checked = true;
                                }
                            }
                        </script>
                        <script type="text/javascript">
                            function resetFilter() {
                                var url = '<?php echo Yii::app()->controller->createUrl("baseProduct/createconfigurable", array("id" => $base_product_id, "category_id" => $category_id,)); ?>';
                                window.location = url + '&reset=1';
                            }

                            jQuery(document).ready(function () {
                                checkRows();
                            });

                            jQuery(document).ajaxComplete(function (event, xhr, settings) {
                                checkRows();
                            });

                            function checkRows() {
                                jQuery("input[name='userids[]']").each(function () {
                                    var idStr = jQuery("#selectedIds").val();
                                    var ids = idStr.split(",");
                                    if (jQuery.inArray(jQuery(this).val(), ids) !== -1) {
                                        //if (ids.indexOf(jQuery(this).val()) != -1) {
                                        jQuery(this).prop('checked', true);
                                    }
                                });
                            }

                            function updateProductMapping(chkbx) {
                                var i = 0;
                                //var product = chkbx.getElementsByTagName('input');
                                var idStr = document.getElementById("selectedIds").value;
                                var ids = idStr.split(",");
                                if (chkbx.checked == true) {
                                    ids.push(chkbx.value);
                                } else {
                                    found = jQuery.inArray(chkbx.value, ids);//ids.indexOf(product[0].value);
                                    while (found !== -1) {
                                        ids.splice(found, 1);
                                        found = jQuery.inArray(chkbx.value, ids);
                                    }
                                }
                                document.getElementById("selectedIds").value = ids;
                            }

                            function updateMassProductMapping(chkbx) {
                                var idStr = document.getElementById("selectedIds").value;
                                var ids = idStr.split(",");

                                jQuery("input[name='userids[]']").each(function () {
                                    if (chkbx.checked == true) {
                                        found = jQuery.inArray(this.value, ids);
                                        if (found == -1) {
                                            ids.push(this.value);
                                        }
                                    } else {
                                        found = jQuery.inArray(this.value, ids);//ids.indexOf(jQuery(this).val());
                                        while (found !== -1) {
                                            ids.splice(found, 1);
                                            found = jQuery.inArray(this.value, ids);//ids.indexOf(jQuery(this).val());
                                        }
                                    }
                                });

                                document.getElementById("selectedIds").value = ids;
                            }

                            jQuery(document).on('change', "#base-product-grid_c0_all", function () {
                                updateMassProductMapping(this);
                            });

                            jQuery(document).on('change', "input[name='userids[]']", function () {
                                updateProductMapping(this);
                            });
                        </script>
                        </form>
