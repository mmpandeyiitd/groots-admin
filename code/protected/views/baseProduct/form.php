
<script src="themes/abound/js/bootstrap-tagsinput.js" type="text/javascript" charset="utf-8"></script>
<link href="themes/abound/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css">
<?php
/* @var $this BaseProductController */
/* @var $model BaseProduct */
/* @var $form CActiveForm */
$count = 0;

/* $issuperadmin = Yii::app()->session['is_super_admin'];
  if ($issuperadmin == 1) {

  if (!(isset($_GET['store_id'])) || (empty($_GET['store_id']))) {
  Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
  $this->redirect(array('DashboardPage/index'));
  }
  $store_id = $_GET['store_id'];
  if (Yii::app()->session['brand_admin_id'] != $store_id) {
  Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
  $this->redirect(array('DashboardPage/index'));
  }
  $store_name = Store::model()->getstore_nameByid($store_id);
  //    $this->breadcrumbs = array(
  //        'Brand' => array('store/admin'),
  //        $store_name => array('store/update', "id" => $store_id),
  //        'Style' => array('admin', "store_id" => $store_id),
  //        'Create',
  //    );
  } else {
  if (!(isset($_GET['store_id'])) || (empty($_GET['store_id']))) {
  Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
  $this->redirect(array('DashboardPage/index'));
  }
  $store_id = $_GET['store_id'];
  if (Yii::app()->session['brand_id'] != $store_id) {
  Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
  $this->redirect(array('DashboardPage/index'));
  }
  //    $this->breadcrumbs = array(
  //        'Style' => array('admin', "store_id" => $store_id),
  //        'Create');
  } */
?>




<script language="javascript">
    $(document).ready(function () {
        $("#datepicker").datepicker({
            minDate: 0
        });
    });
</script>


<div class="form create_styleform"  >   
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'base-product-form',
        'focus' => '.error:first',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
//        'clientOptions' => array(
//            'validateOnSubmit' => true,
//        ),
    ));
    ?>


    <?php //print_r($_POST);die;//echo'<pre>';print_r($category_id);die; ?>
    <div class="span3 category_tree">
        <?php $this->renderPartial('category_tree', array('model' => $model)); ?>
    </div>
    <div class="span8" style="margin-top:0;">
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php echo $form->errorSummary($model); ?>
        <?php if (Yii::app()->user->hasFlash('error')): ?><div class="errorSummary" style="color: "><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>
        <?php if (Yii::app()->user->hasFlash('MRP')): ?><div class="errorSummary" style="color:"><?php echo Yii::app()->user->getFlash('MRP'); ?></div><?php endif; ?>
        <?php if (Yii::app()->user->hasFlash('WSP')): ?><div class="errorSummary" style="color:"><?php echo Yii::app()->user->getFlash('WSP'); ?></div><?php endif; ?>
        <?php if (Yii::app()->user->hasFlash('title')): ?><div class="errorSummary" style="color:"><?php echo Yii::app()->user->getFlash('title'); ?></div><?php endif; ?>
        <?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-error" style="color: green;"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>

        <div class="">
            <?php
            if (isset($imageinfo[0]['thumb_url'], $imageinfo[0]['thumb_url']))
                $imagethumb = $imageinfo[0]['thumb_url'];
            else
                $imagethumb = '';
            ?>
            <?php if ($model->isNewRecord) { ?>
                <div class="row">
                    <?php echo $form->labelEx($model, 'Search By title Name'); ?>
                    <?php
                    if ($model->isNewRecord) {
                        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name' => 'normal',
                            'source' => $this->createUrl("baseProduct/ajax", array('store_id' => $_REQUEST['store_id'])),
                            // additional javascript options for the autocomplete plugin
                            'options' => array(
                                'minLength' => '1',
                                'change' => 'js:function(event, ui) {
                   
                    $("#BaseProduct_title").val(ui.item.title);
                    $("#BaseProduct_description").val(ui.item.description);
                    $("#BaseProduct_season").val(ui.item.season);
                    $("#BaseProduct_color").val(ui.item.color);
                    $("#BaseProduct_minimum_order_quantity").val(ui.item.minimum_order_quantity);
                    $("#BaseProduct_available_quantity").val(ui.item.available_quantity);
                    $("#BaseProduct_fabric").val(ui.item.fabric);
                    $("#BaseProduct_order_placement_cut_off_date").val(ui.item.order_placement_cut_off_date);
                    $("#BaseProduct_delevry_date").val(ui.item.delevry_date);
                    $("#BaseProduct_size").val(ui.item.size);
                    $("#BaseProduct_size_brand").val(ui.item.size_brand);
                    $("#BaseProduct_tags").val(ui.item.tags);
                    $("#BaseProduct_specofic_keys").val(ui.item.specofic_keys);
                }'
                            ),
                            'htmlOptions' => array(
                                'style' => 'height:20px;',
                            ),
                        ));
                    } /* else {
                      echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255));
                      } */
                    ?> 
                    <?php //echo $form->error($model, 'title'); ?>
                </div>
            <?php } ?>
            <div class="row">
                <?php echo $form->labelEx($model, 'title'); ?>
                <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
                <?php echo $form->error($model, 'title'); ?>
            </div>
            <div class="row">
                <?php
                echo $form->labelEx($model, 'description');
                echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50));
                echo $form->error($model, 'description');
                ?>
            </div>
            <div class="row">
                <?php echo $form->labelEx($model, 'color'); ?>
                <?php echo $form->textField($model, 'color', array('maxlength' => 10)); ?>
                <?php echo $form->error($model, 'color'); ?>
            </div>
            <div class="row">
                <label for="grade"><?php echo 'grade ' ?></label>
                <input type="text" name="a" value="<?php echo $a; ?>"/>
            </div>
            <div class="row">
                <label for="diameter"><?php echo 'diameter ' ?></label>
                <input type="text" name="new_data" value="<?php echo $new_data; ?>"/>
            </div>

            <div class="row">
                <?php
                echo $form->labelEx($model, 'pack_size');
                echo $form->textField($model, 'pack_size', array('size' => 60, 'maxlength' => 255));
                echo $form->error($model, 'pack_size');
                ?>
            </div>
            <div class="row">
                <?php
                echo $form->labelEx($model, 'pack_unit');
                echo $form->textField($model, 'pack_unit', array('size' => 60, 'maxlength' => 255));
                echo $form->error($model, 'pack_unit');
                ?>
            </div>



            <?php
            if (isset($_GET['id']) && isset($_GET['store_id'])) {
                $get_test = SubscribedProduct::model()->findAllByAttributes(array('base_product_id' => $_GET['id'], 'store_id' => $_GET['store_id']));
                $count = count($get_test);
                if ($count > 0) {
                    $mrp = $get_test[0]['store_price'];
                    $wsp = $get_test[0]['store_offer_price'];
                } else {
                    $mrp = '';
                    $wsp = '';
                }
            }
            ?>

            <div class="row">
                <label for="BaseProduct_size"><?php echo 'store price *' ?></label>

                <input type="text" name="MRP" id="MRP" value="<?php echo $mrp; ?>" />
            </div>

            <div class="row">
                <label for="BaseProduct_size"><?php echo 'store offer price *' ?></label>
                <input type="text" name="WSP" id="WSP" value="<?php echo $wsp; ?>"/>
            </div>

            <div class="row">
                <label for="BaseProduct_size"><?php echo 'Indicated Weight ' ?></label>
                <input type="text" name="Weight" id ="Weight"  value="<?php echo $Weight; ?>"/>
            </div>
            <div class="row">
                <label for="BaseProduct_size"><?php echo 'Indicated Weight Unit' ?></label>
                <input type="text" name="WeightUnit" value="<?php echo $WeightUnit; ?>"/>
            </div>
            <div class="row">
                <label for="BaseProduct_size"><?php echo 'Indicated Length' ?></label>
                <input type="text" name="Length" id="Length" value="<?php echo $Length; ?>"/>
            </div>
            <div class="row">
                <label for="BaseProduct_size"><?php echo 'Indicated Length Unit' ?></label>
                <input type="text" name="LengthUnit" value="<?php echo $LengthUnit; ?>"/>
            </div>
        </div>
        <div class="">
            <?php
            echo $form->hiddenField($model, 'quantity', array('value' => '0'));
            ?>
            <div style="clear:both;"></div>
            <div class="row">
                <?php echo $form->labelEx($model, 'status'); ?>
                <div class="check-awesome" style="float: left;">  
                    <?php if (!$model->isNewRecord) { ?>
                        <input  name="status" type="checkbox" id="check-one" value="1" <?php
                        if ($model->status == 1) {
                            echo 'checked';
                        }
                        ?>>
                            <?php } else { ?>
                        <input name="status" type="checkbox" id="check-one" value="1" checked >
                    <?php } ?> 
                    <label for="check-one">
                        <span class="check"></span>
                        <span class="box"></span>
                        Publish
                    </label>
                </div>
                <div style="clear:both;"></div>
                <div class="row">
                    <label for="BaseProduct_status" class="required">Images <span class="required"></span></label>
                    <?php
                    // print_R($images);
                    $this->widget('CMultiFileUpload', array(
                        'name' => 'images',
                        'model' => $model,
                        'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
                        'duplicate' => 'Duplicate file!', // useful, i think
                        'denied' => 'Invalid file type', // useful, i think
                        'options' => array(
                            'afterFileSelect' => 'function(e ,v ,m){
	                	var fileSize = e.files[0].size;
			            if(fileSize>1024*1024*2){
			            	alert("Exceeds file upload limit 2MB");
			                $("div.MultiFile-list div:last-child a.MultiFile-remove").click();
			            }                     
			            return true;
	                }',
                        ),
                        'max' => 5, //max 5 files allowed
                    ));
                    ?>
                    <p class="fileupload_note" >Allow image types : jpeg, jpg, png</p>
                    <p class="fileupload_note" >Maximum 2 images upload</p>
                </div>

                <?php
                $media = array();
                $media = Media::model()->getMediaByBaseProductId($model->base_product_id);
                if (isset($media)) {
                    ?>
                    <label>&nbsp;</label>
                    <table id="media_gallery" class="table table-striped table-hover table-bordered">
                        <thead >
                            <tr>
                                <th style="font-weight:normal;">Image</th>
                                <th style="font-weight:normal;" >Is Default</th>
                                <th style="font-weight:normal;" >Remove</th>
                            </tr>
                        </thead>

                        <tbody id="media_gallery_body">
                            <?php
                            $i = 1;
                            foreach ($media as $_media) {
                                ?>
                                <tr style=" margin-top:5px;">					
                                    <td><img style="width: 100px;" src="<?php echo $_media->thumb_url; ?>"></td>
                                    <td style="text-align:center;"><input type="radio" name="media_is_default" value="<?php echo $_media->media_id; ?>" <?php if ($_media->is_default) echo 'checked'; ?>></td>
                                    <td style="text-align:center;"><input type="checkbox" name="media_remove[]" value="<?php echo $_media->media_id; ?>"></td>
                                </tr>
                                <?php
                                if ($i++ == 2)
                                    break;
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <div style="clear:both;"></div>
                <div class="errorSummary price1" style="color: red"  id="errchk"></div>
                <div style="clear:both;"></div>
                <div class="buttons">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('id' => 'buttonid')); ?>

                </div>

            </div>

        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->

    <SCRIPT lang="javascript">

        function addMore() {
            $("#product").append("<div style='clear:both;'></div><div class='product' >\n\
                                <input type='text' name='kye_field[]'  />\n\
                                <input type='text' name='kye_value[]'  />\n\
                                <span class='cross_btn' onClick='deleteRow(this);'><i class='fa fa-times'></i></span>\n\
                        </div>")
        }

        function deleteRow(variable_click) {
            $(variable_click).parent('div').remove();
        }




        $(document).ready(function () {

            $('a[href=#top]').click(function () {
                $('html, body').animate({scrollTop: 0}, 'slow');
                return false;
            });
            $('#buttonid').click(function () {

                var favorite = [];
                var flage = true;
                var BASE_PRICE_ERROR = [];
                var title = $('#BaseProduct_title').val();
                var pack_size = $('#BaseProduct_pack_size').val();
                var pack_unit = $('#BaseProduct_pack_unit').val();
                var mrp = $('#MRP').val();
                var wsp = $('#WSP').val();
                var weight = $('#Weight').val();
                var length = $('#Length').val();
                if (weight == '') {
                    var weight = '0';
                }
                if (length == '') {
                    var length = '0';
                }

                $.each($("input[name='aiotree[category_id][]']:checked"), function () {
                    favorite.push($(this).val());
                });

                if (favorite.length < 1) {
                    BASE_PRICE_ERROR.push("<li>Please select at least one category.</li>");
                    flage = false;
                }

                if (title == '') {
                    BASE_PRICE_ERROR.push("<li>Title cannot be blank.</li>");
                    flage = false;
                }
                if (pack_size == '') {
                    BASE_PRICE_ERROR.push("<li>Pack Size cannot be blank.</li>");
                    flage = false;
                }
                else if (!$.isNumeric(pack_size))
                {
                    BASE_PRICE_ERROR.push("<li>Pack Size always numeric</li>");
                    flage = false;
                }
                if (pack_unit == '') {
                    BASE_PRICE_ERROR.push("<li>Pack Unit cannot be blank.</li>");
                    flage = false;
                }
                if (mrp == '') {
                    BASE_PRICE_ERROR.push("<li>Store Price cannot be blank.</li>");
                    flage = false;
                }
                else if(mrp==0){
                BASE_PRICE_ERROR.push("<li>Store Price always greater than zero</li>");
                flage = false;
            }
                else if (!$.isNumeric(mrp))
                {
                    BASE_PRICE_ERROR.push("<li>Store Price always numeric</li>");
                    flage = false;
                } else
                if (wsp == '') {
                    BASE_PRICE_ERROR.push("<li>Store Offer Price cannot be blank.</li>");
                    flage = false;
                }
                else if(wsp==0){
                BASE_PRICE_ERROR.push("<li>Store Offer Price always greater than zero</li>");
                flage = false;
            }
                else if (!$.isNumeric(wsp))
                {
                    BASE_PRICE_ERROR.push("<li>Store Offer Price always numeric</li>");
                    flage = false;
                }
                if (parseInt(mrp) < parseInt(wsp)) {
                    BASE_PRICE_ERROR.push("<li>Store price must be greater than Store offer price</li>");
                    flage = false;
                }
                if (!$.isNumeric(weight))
                {
                    BASE_PRICE_ERROR.push("<li>Indicated Weight always numeric</li>");
                    flage = false;
                }
                if (!$.isNumeric(length))
                {
                    BASE_PRICE_ERROR.push("<li>Indicated Length always numeric</li>");
                    flage = false;
                }
                if (flage == false) {
                    $("#errchk").empty();
                    $("#errchk").removeClass('price1');
                    $("#errchk").addClass('currentTab');
                    $("#errchk").append(BASE_PRICE_ERROR);
                    return false;
                }

            });

        });


        //........Start Color picker...........||
        function change_color(colorid) {
            var get_color_code = document.getElementById(colorid).style.backgroundColor;
            var color_name = colorid.slice(0, -1);
            document.getElementById('color_code').style.backgroundColor = get_color_code;
            //        document.getElementById('color_name').innerHTML = color_name;
            document.getElementById('color_mainids').value = get_color_code;
        }
        //........End Color picker...........||
    </SCRIPT>
    <style type="text/css">
        .miniColors-trigger { display: none;} 
        .portlet-content .form form input[type="radio"] { width: 30px !important;}
        .portlet-content .form form input[type="checkbox"] { width: 30px !important;}
    </style>
    <style type="text/css">

        .price1 {
            display: none;
        }
        .currentTab {
            display: block !important;
        }


    </style>