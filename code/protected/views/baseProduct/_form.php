
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
            <div class="row">
                <?php echo $form->labelEx($model, 'Title  *'); ?>
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
                <label for="">Color:</label>
                <div class="colorPicker_dd" id="PickClr">
                    <?php if ($model->isNewRecord) { ?>
                        <span id="color_code" class="colorView" style="background-color:#ff0000;" >&nbsp;</span>
                        <h6 id="color_name">Red</h6>
                    <?php } else { ?>
                        <span id="color_code" class="colorView" style="background-color:<?php echo $model->color; ?>;" >&nbsp;</span>

                    <?php } ?>
                    <div class="colorPop">
                        <h3>Colors</h3>
                        <input type="hidden" id="color_mainids" name="color" value="#ff0000~~Red"/>

                        <ul class="colorRow">
                            <li><a id="Bluea" href="javascript:void(0);" style="background-color:#080e62;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a id="Blueb" href="javascript:void(0);" style="background-color:#1023ad;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a id="Bluec" href="javascript:void(0);" style="background-color:#2732ee;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a id="Blued" href="javascript:void(0);" style="background-color:#725af6;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a id="Bluee" href="javascript:void(0);" style="background-color:#c0b6fd;" onclick="change_color(this.id)">&nbsp;</a></li>
                        </ul>
                        <ul class="colorRow">
                            <li><a id="Violeta"  href="javascript:void(0);" style="background-color:#510a36;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a id="Violetb" href="javascript:void(0);" style="background-color:#8f1761;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a  id="Violetc"href="javascript:void(0);" style="background-color:#c22f8a;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a id="Violetd" href="javascript:void(0);" style="background-color:#d27bb0;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a id="Violete" href="javascript:void(0);" style="background-color:#e9c3dc;" onclick="change_color(this.id)">&nbsp;</a></li>
                        </ul>
                        <ul class="colorRow">
                            <li><a id="Browna" href="javascript:void(0);" style="background-color:#681503;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a id="Brownb" href="javascript:void(0);" style="background-color:#af2a01;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a id="Brownc" href="javascript:void(0);" style="background-color:#db5120;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a id="Brownd" href="javascript:void(0);" style="background-color:#e39179;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a  id="Browne" href="javascript:void(0);" style="background-color:#f4d3ca;" onclick="change_color(this.id)">&nbsp;</a></li>
                        </ul>
                        <ul class="colorRow">
                            <li><a  id="Reda" href="javascript:void(0);" style="background-color:#B40404;"onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a  id="Redd" href="javascript:void(0);" style="background-color:#FF0000;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a   id="Redc"href="javascript:void(0);" style="background-color:#DF0101;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a  id="Redb"href="javascript:void(0);" style="background-color:#FA5858;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a  id="Rede"href="javascript:void(0);" style="background-color:#F78181;" onclick="change_color(this.id)">&nbsp;</a></li>
                        </ul>
                        <ul class="colorRow">
                            <li><a   id="Yellowa" href="javascript:void(0);" style="background-color:#736c01;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a  id="Yellowb" href="javascript:void(0);" style="background-color:#bdb401;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a  id="Yellowc" href="javascript:void(0);" style="background-color:#e4db00;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a  id="Yellowd" href="javascript:void(0);" style="background-color:#eae67a;" onclick="change_color(this.id)">&nbsp;</a></li>
                            <li><a  id="Yellowe" href="javascript:void(0);" style="background-color:#ffffcc;" onclick="change_color(this.id)">&nbsp;</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>        
            </div>
            <script type="text/javascript">
                $("#PickClr").click(function () {
                    $(".colorPop").toggle();
                });
            </script>


            <div class="row">
                <label for="grade"><?php echo 'grade ' ?></label>
                <input type="text" name="grade" value="<?php echo $grade; ?>"/>
            </div>
            <div class="row">
                <label for="diameter"><?php echo 'diameter ' ?></label>
                <input type="text" name="diameter" value="<?php echo $diameter; ?>"/>
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

                <input type="text" name="MRP"  value="<?php echo $mrp; ?>" />
            </div>

            <div class="row">
                <label for="BaseProduct_size"><?php echo 'store offer price *' ?></label>
                <input type="text" name="WSP" value="<?php echo $wsp; ?>"/>
            </div>
             <div class="row">
                <label for="BaseProduct_size"><?php echo 'Indicated Weight ' ?></label>
                <input type="text" name="Weight" value="<?php echo $Weight; ?>"/>
            </div>
             <div class="row">
                <label for="BaseProduct_size"><?php echo 'Indicated Weight Unit' ?></label>
                <input type="text" name="WeightUnit" value="<?php echo $WeightUnit; ?>"/>
            </div>
             <div class="row">
                <label for="BaseProduct_size"><?php echo 'Indicated Length' ?></label>
                <input type="text" name="Length" value="<?php echo $Length; ?>"/>
            </div>
             <div class="row">
                <label for="BaseProduct_size"><?php echo 'Indicated Length Unit' ?></label>
                <input type="text" name="LengthUnit" value="<?php echo $LengthUnit; ?>"/>
            </div>
        </div>
        <div class="">

            <?php
            echo $form->hiddenField($model, 'quantity', array('value' => '1'));
            ?>
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
                        <?php foreach ($media as $_media) { ?>
                            <tr style=" margin-top:5px;">					
                                <td><img style="width: 100px;" src="<?php echo $_media->thumb_url; ?>"></td>
                                <td style="text-align:center;"><input type="radio" name="media_is_default" value="<?php echo $_media->media_id; ?>" <?php if ($_media->is_default) echo 'checked'; ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="media_remove[]" value="<?php echo $_media->media_id; ?>"></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div style="clear:both;"></div>

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

        });


        //........Start Color picker...........||
        function change_color(colorid) {
            var get_color_code = document.getElementById(colorid).style.backgroundColor;
            var color_name = colorid.slice(0, -1);
            document.getElementById('color_code').style.backgroundColor = get_color_code;
            document.getElementById('color_name').innerHTML = color_name;
            document.getElementById('color_mainids').value = get_color_code + '~~' + color_name;
        }
        //........End Color picker...........||
    </SCRIPT>
    <style type="text/css">
        .miniColors-trigger { display: none;} 
        .portlet-content .form form input[type="radio"] { width: 30px !important;}
        .portlet-content .form form input[type="checkbox"] { width: 30px !important;}
    </style>
