<?php
/* @var $this CategoryController */
/* @var $model Category */
$issuperadmin = Yii::app()->session['is_super_admin'];

$id = '';
$linesheet_name = '';


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
        $store_front_id = $_GET['id'];
        $linesheet_name = StoreFront::getLinsheetNameByID($store_front_id, $store_id);
    }
    $this->breadcrumbs = array(
        'Brand' => array('store/admin'),
        $store_name => array('store/update', "id" => $store_id),
        'Linesheet' => array('admin', 'store_id' => $store_id),
        'Add Styles In ' . $linesheet_name . ' Linesheet',);
} else {
    if (!(isset($_GET['store_id'])) || (empty($_GET['store_id']))) {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
    $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_id'] != $store_id) {
        $this->redirect(array('site/logout'));
    }
    $store_name = Store::model()->getstore_nameByid($store_id);
    if (isset($_GET['id'])) {
        $store_front_id = $_GET['id'];
        $linesheet_name = StoreFront::getLinsheetNameByID($store_front_id, $store_id);
    }
    $this->breadcrumbs = array(
        'Linesheet' => array('admin', 'store_id' => $store_id),
        'Add Styles In ' . $linesheet_name . ' Linesheet',);
}


#......Menu & Action Visibility.....#
$visible_dropdownmenu = true;
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



<form name="frm" method="post" class="grid_form">
    
    <div class="top_searcstrip">
        <div class="top_searchbox">
            <input type="text" name="searchtext" value="" />
            <input type="submit" name="searchsubmit" value="Search"/>
        </div>
    </div>
     <div class="grid_contain">
         <?php if (Yii::app()->user->hasFlash('error_error')): ?><div class="errorSummary" style="color:red;"><b><?php echo Yii::app()->user->getFlash('error_error'); ?></b></div><?php endif; ?>

<?php if (Yii::app()->user->hasFlash('success')): ?><div class="errorSummary" style="color: green;"><b><?php echo Yii::app()->user->getFlash('success'); ?></b></div><?php endif; ?>

    <div class="form"  >
        
        <?php
        if (!empty($search)) {
            $dataprovider = BaseProduct::model()->getSearchByTitle($search, $store_id);
            $maxrecord = count($dataprovider);
        } else {
            $dataprovider = BaseProduct::model()->getProducforMappingLinesheet($_GET['id'], $store_id);
            $maxrecord = count($dataprovider);
        }
        $already_product = StoreFront::getMappedbaseproductbystorefront($_GET['id']);
        if ($visible_dropdownmenu) {
            
        }
        for ($i = 0; $i < $maxrecord; $i++) {
            $img = Media::model()->getOneMediaByBaseProductId($dataprovider[$i]['base_product_id']);
            ?>
            <div class="look_grid"  onclick="chech_checkbox(<?php echo $dataprovider[$i]['base_product_id']; ?>);" style="cursor: pointer;">
                <a href="#styleinfo<?php echo $dataprovider[$i]['base_product_id']; ?>" role="button" data-toggle="modal" class="detail_top" alt="detail"><i class="fa fa-info"></i></a>
                <a type="button" class="imagehover" data-placement='right'> 
                    <div class="imagehover-wrap" role="button" data-toggle="modal">
                        <div class="check_new_span"  style="display:none;" id="check-div<?php echo $dataprovider[$i]['base_product_id']; ?>" >
                            <i class="fa fa-check"></i>
                        </div>
                        <img src="<?php
                        if (file_exists($img))
                            echo str_replace("main", "original", $img);
                        else
                            echo 'themes/abound/img/default.jpg';
                        ?>"  >
                    </div>
                    <h4>(<?php echo $dataprovider[$i]['style_no']; ?>) - <?php echo $dataprovider[$i]['title']; ?></h4>
                </a>

                <input  name="productsids[]" type="checkbox" id="checkboxid<?php echo $dataprovider[$i]['base_product_id']; ?>" value="<?php echo $dataprovider[$i]['base_product_id']; ?>" style="display: none;">
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
                                <h5 id="myModalLabel">Style Information</h5>
                            </div>
                            <div class="modal-body">
                                <table class="table table-hover">

                                    <tr>
                                        <td>Product Name </td>
                                        <td><?php echo $dataprovider[$i]['title']; ?></td>
                                    </tr>
                                    

                                    <tr>
                                        <td>Color</td>
                                        <td><?php if (!empty($dataprovider[$i]['color'])) {?>
                                            <span style="background-color:<?php echo $dataprovider[$i]['color']; ?>" class="proColor"></span><?php } else { echo "N/A"; }?>
                                        </td>
                                    </tr>
 
                                    
                                    <tr>
                                        <td>Store Price</td>
                                        <td><?php echo $mrp; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Store Offer price</td>
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

        <?php
        }
//} 
        ?>

        <script type="text/javascript">
            $(function () {
                $('.imagehover').tooltip();
            });
        </script>

<?php if ($maxrecord > 0) { ?>
            <div class="span10">
                <div class="row buttons">
                    <input type="submit" name="save" value="Add">
                </div>
            </div>
<?php } ?>
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
    </div>
</form>