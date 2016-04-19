<?php
/* @var $this YmpdmUserController */
/* @var $model YmpdmUser */
/* @var $form CActiveForm */
;
?>

<div class="form" class="form" >

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'ympdm-user-form',
        'focus' => '.error:first',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>
    <?php if (Yii::app()->user->hasFlash('error')): ?><div class="errorSummary" ><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>

    <?php if (Yii::app()->user->hasFlash('error11')): ?><div class="flash-error label label-success" ><?php echo Yii::app()->user->getFlash('error11'); ?></div><?php endif; ?>
    <?php if (Yii::app()->user->hasFlash('permissio_error')): ?><div class="flash-error label label-important" ><?php echo Yii::app()->user->getFlash('permissio_error'); ?></div><?php endif; ?>
    <div class="">
        <div class="row">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'email'); ?>
            <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>

        <!--        <div class="row">
        <?php echo $form->labelEx($model, 'user_name'); ?>
        <?php echo $form->textField($model, 'user_name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'user_name'); ?>
                </div>-->

        <div class="row">
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
        <?php if ($model->isNewRecord) { ?>
            <div class="row">
                <?php echo $form->labelEx($model, 'Confirm password'); ?>
                <input type="password" name="confirm_password" value="<?php
                if (!$model->isNewRecord) {
                    echo $model->password;
                } else {
                    echo $confirm_password;
                }
                ?>"/>
            </div>
        <?php } ?>
    </div>  
    <div class="">  
        <div class="row">
            <?php echo $form->labelEx($model, 'user_type'); ?>
            <?php
            echo $form->dropDownList(
                    $model, 'user_type', array(
                "Select",
                "SuperAdmin" => "SuperAdmin",
                "BrandAdmin" => "BrandAdmin",
                    ), array(
                'onChange' => 'javascript:addCatFilter()',
                'id' => 'user_type',
                    )
            );
            ?>  
            <?php echo $form->error($model, 'user_type'); ?>
        </div>

        <div class="row"  id="brand_id" <?php
        if ($model->user_type == 'BrandAdmin') {
            echo 'style="display: inline"';
        } else {
            echo 'style="display: none"';
        }
        ?>>
                 <?php echo $form->labelEx($model, 'brand '); ?>
                 <?php
                 $opts = CHtml::listData(Store::model()->findAll(), 'store_id', 'store_name');
                 echo $form->dropDownList($model, 'brand_id', $opts, array('empty' => 'select brand'), array('options' => array($model->brand_id => array('selected' => true))));
                 ?>  
                 <?php echo $form->error($model, 'brand_id'); ?>
        </div>



        <?php
        $json = json_decode($model['permission_info']);


        $Users = @$json->module_info->Users;
        $retailers = @$json->module_info->retailers;
        $brand = @$json->module_info->brand;
        $linesheet = @$json->module_info->linesheet;
        $baseproduct = @$json->module_info->baseproduct;
        $pressrelease = @$json->module_info->pressrelease;
        //  $retailers = @$json->module_info->retailers;
        $photogallery = @$json->module_info->photogallery;
        $retailerProductQuotation = @$json->module_info->retailerProductQuotation;
        $orderinfo = @$json->module_info->orderinfo;
        $lookbook = @$json->module_info->lookbook;
        $category = @$json->module_info->category;
        $retailerrequest = @$json->module_info->retailerrequest;
        $subscribedProduct = @$json->module_info->subscribedProduct;

        $users_menu_info = @$json->menu_info->users_menu_info;
        $brand_menu_info = @$json->menu_info->brand_menu_info;
        $baseproduct_menu_info = @$json->menu_info->baseproduct_menu_info;
        $linesheet_menu_info = @$json->menu_info->linesheet_menu_info;
        $pressrelease_menu_info = @$json->menu_info->pressrelease_menu_info;
        $photogallery_menu_info = @$json->menu_info->photogallery_menu_info;
        $orderinfo_menu_info = @$json->menu_info->orderinfo_menu_info;
        $retailers_menu_info = @$json->menu_info->retailers_menu_info;
        $lookbook_menu_info = @$json->menu_info->lookbook_menu_info;
        $category_menu_info = @$json->menu_info->category_menu_info;
        $retailerrequest_menu_info = @$json->menu_info->retailerrequest_menu_info;
        $retailerProductQuotation_menu_info = @$json->menu_info->retailerProductQuotation_menu_info;
        $subscribedProduct_menu_info = @$json->menu_info->subscribedProduct_menu_info;
        ?>
    </div> 
    <div style="clear:both;"></div>
    <div class="permission_infotitle"><span style="color:#002a80;">Permission Info</span></div>

    <div class="formradio_checks">
        <div class="row">
            <label ><span style="color:#002a80;">Users</span></label>
            <table>
                <tr>
                    <td>
                        <input type="radio" name="users_menu_info"  value="S"  <?php
                        if (strstr($users_menu_info, "S")) {
                            echo "checked='checked'";
                        }
                        ?>>

                        <label >Show</label>
                    </td>
                    <td>
                        <input type="radio" name="users_menu_info" value="H" <?php
                        if (strstr($users_menu_info, "H")) {
                            echo "checked='checked'";
                        }
                        ?>>
                        <label>Hide</label>
                    </td>
                </tr>
            </table>

        </div>  
        <div class="row" >
            <label style="margin-left: "><span style="color:#C3329B">Permission</span></label>

            <div class="check_permsnbox">

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="Users[]" id="check-1" value="R"  <?php
                    if (strstr($Users, "R")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-1">
                        <span class="check"></span>
                        <span class="box"></span>
                        Read
                    </label>
                </div>



                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="Users[]" id="check-2" value="C" <?php
                    if (strstr($Users, "C")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-2">
                        <span class="check"></span>
                        <span class="box"></span>
                        Create
                    </label>
                </div>

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="Users[]" id="check-3" value="U"  <?php
                    if (strstr($Users, "U")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-3">
                        <span class="check"></span>
                        <span class="box"></span>
                        Update
                    </label>
                </div>

                <!-- <div class="check-awesome" style="float: left;">  
                              <input type="checkbox" name="Users[]" id="check-4" value="D"  <?php
//                            if (strstr($Users, "D")) {
//                                echo "checked='checked'";
//                            }
                ?>>
                              <label for="check-4">
                                <span class="check"></span>
                                <span class="box"></span>
                              Delete
                              </label>
                       </div>-->
            </div>
        </div>
        <hr style="color:#C00;"/>  
        <div class="row">
            <label ><span style="color:#002a80;">Retailers</span></label>
            <table>
                <tr>
                    <td>
                        <input type="radio" name="retailers_menu_info" value="S"  <?php
                        if (strstr($retailers_menu_info, "S")) {
                            echo "checked='checked'";
                        }
                        ?>>

                        <label>Show</label>
                    </td>
                    <td>
                        <input type="radio" name="retailers_menu_info" value="H" <?php
                        if (strstr($retailers_menu_info, "H")) {
                            echo "checked='checked'";
                        }
                        ?>>
                        <label>Hide</label>
                    </td>
                </tr>
            </table>

        </div>

        <div class="row" >
            <label ><span style="color:#C3329B">Permission</span></label>
            <div class="check_permsnbox">

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="retailers[]" id="check-5" value="R"  <?php
                    if (strstr($retailers, "R")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-5">
                        <span class="check"></span>
                        <span class="box"></span>
                        Read
                    </label>
                </div>



                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="retailers[]" id="check-6" value="C" <?php
                    if (strstr($retailers, "C")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-6">
                        <span class="check"></span>
                        <span class="box"></span>
                        Create
                    </label>
                </div>

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="retailers[]" id="check-7" value="U"  <?php
                    if (strstr($retailers, "U")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-7">
                        <span class="check"></span>
                        <span class="box"></span>
                        Update
                    </label>
                </div>

                <!-- <div class="check-awesome" style="float: left;">  
                              <input type="checkbox" name="retailers[]" id="check-8" value="D"  <?php
//                            if (strstr($retailers, "D")) {
//                                echo "checked='checked'";
//                            }
                ?>>
                              <label for="check-8">
                                <span class="check"></span>
                                <span class="box"></span>
                              Delete
                              </label>
                       </div>-->
            </div>
        </div>


        <hr/>  
        <div class="row">
            <label ><span style="color:#002a80;">Retailer Product Quotation</span></label>
            <table>
                <tr>
                    <td>
                        <input type="radio" name="retailerProductQuotation_menu_info" value="S"  <?php
                        if (strstr($retailerProductQuotation_menu_info, "S")) {
                            echo "checked='checked'";
                        }
                        ?>>

                        <label>Show</label>
                    </td>
                    <td>
                        <input type="radio" name="retailerProductQuotation_menu_info" value="H" <?php
                        if (strstr($retailerProductQuotation_menu_info, "H")) {
                            echo "checked='checked'";
                        }
                        ?>>
                        <label>Hide</label>
                    </td>
                </tr>
            </table>

        </div>

        <div class="row" >
            <label ><span style="color:#C3329B">Permission</span></label>
            <div class="check_permsnbox">

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="retailerProductQuotation[]" id="check-05" value="R"  <?php
                    if (strstr($retailerProductQuotation, "R")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-05">
                        <span class="check"></span>
                        <span class="box"></span>
                        Read
                    </label>
                </div>



                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="retailerProductQuotation[]" id="check-06" value="C" <?php
                    if (strstr($retailerProductQuotation, "C")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-06">
                        <span class="check"></span>
                        <span class="box"></span>
                        Create
                    </label>
                </div>

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="retailerProductQuotation[]" id="check-07" value="U"  <?php
                    if (strstr($retailerProductQuotation, "U")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-07">
                        <span class="check"></span>
                        <span class="box"></span>
                        Update
                    </label>
                </div>

                <!-- <div class="check-awesome" style="float: left;">  
                              <input type="checkbox" name="retailers[]" id="check-8" value="D"  <?php
//                            if (strstr($retailers, "D")) {
//                                echo "checked='checked'";
//                            }
                ?>>
                              <label for="check-8">
                                <span class="check"></span>
                                <span class="box"></span>
                              Delete
                              </label>subscribedProduct_menu_info
                       </div>-->
            </div>
        </div>


        <hr/>  
         <div class="row">
            <label ><span style="color:#002a80;">Subscribed Product</span></label>
            <table>
                <tr>
                    <td>
                        <input type="radio" name="subscribedProduct_menu_info" value="S"  <?php
                        if (strstr($subscribedProduct_menu_info, "S")) {
                            echo "checked='checked'";
                        }
                        ?>>

                        <label>Show</label>
                    </td>
                    <td>
                        <input type="radio" name="subscribedProduct_menu_info" value="H" <?php
                        if (strstr($subscribedProduct_menu_info, "H")) {
                            echo "checked='checked'";
                        }
                        ?>>
                        <label>Hide</label>
                    </td>
                </tr>
            </table>

        </div>

        <div class="row" >
            <label ><span style="color:#C3329B">Permission</span></label>
            <div class="check_permsnbox">

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="subscribedProduct[]" id="check-005" value="R"  <?php
                    if (strstr($subscribedProduct, "R")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-005">
                        <span class="check"></span>
                        <span class="box"></span>
                        Read
                    </label>
                </div>



                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="subscribedProduct[]" id="check-006" value="C" <?php
                    if (strstr($subscribedProduct, "C")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-006">
                        <span class="check"></span>
                        <span class="box"></span>
                        Create
                    </label>
                </div>

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="subscribedProduct[]" id="check-007" value="U"  <?php
                    if (strstr($subscribedProduct, "U")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-007">
                        <span class="check"></span>
                        <span class="box"></span>
                        Update
                    </label>
                </div>

                <!-- <div class="check-awesome" style="float: left;">  
                              <input type="checkbox" name="retailers[]" id="check-8" value="D"  <?php
//                            if (strstr($retailers, "D")) {
//                                echo "checked='checked'";
//                            }
                ?>>
                              <label for="check-8">
                                <span class="check"></span>
                                <span class="box"></span>
                              Delete
                              </label>subscribedProduct_menu_info
                       </div>-->
            </div>
        </div>


        <hr/>  

        <div class="row">
            <label><span style="color:#002a80;">Category</span></label>
            <table>
                <tr>
                    <td>
                        <input type="radio" name="category_menu_info" value="S" <?php
                        if (strstr($category_menu_info, "S")) {
                            echo "checked='checked'";
                        }
                        ?>>

                        <label>Show</label>
                    </td>
                    <td>
                        <input type="radio" name="category_menu_info" value="H" <?php
                        if (strstr($category_menu_info, "H")) {
                            echo "checked='checked'";
                        }
                        ?>>
                        <label>Hide</label>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row" >
            <label ><span style="color:#C3329B">Permission</span></label>
            <div class="check_permsnbox">

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="category[]" id="check-13" value="R"  <?php
                    if (strstr($category, "R")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-13">
                        <span class="check"></span>
                        <span class="box"></span>
                        Read
                    </label>
                </div>



                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="category[]"  id="check-14" value="C" <?php
                    if (strstr($category, "C")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-14">
                        <span class="check"></span>
                        <span class="box"></span>
                        Create
                    </label>
                </div>

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="category[]" id="check-15" value="U"  <?php
                    if (strstr($category, "U")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-15">
                        <span class="check"></span>
                        <span class="box"></span>
                        Update
                    </label>
                </div>

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="category[]" id="check-16" value="D"  <?php
                    if (strstr($category, "D")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-16">
                        <span class="check"></span>
                        <span class="box"></span>
                        Delete
                    </label>
                </div>
            </div>
        </div>
        <hr/> 
        <div class="row">
            <label><span style="color:#002a80;">Store</span></label>
            <table>
                <tr>
                    <td>
                        <input type="radio" name="brand_menu_info" value="S"  <?php
                        if (strstr($brand_menu_info, "S")) {
                            echo "checked='checked'";
                        }
                        ?>>

                        <label>Show</label>
                    </td>
                    <td>
                        <input type="radio" name="brand_menu_info" value="H" <?php
                        if (strstr($brand_menu_info, "H")) {
                            echo "checked='checked'";
                        }
                        ?>>
                        <label>Hide</label>
                    </td>
                </tr>
            </table>
        </div>

        <div class="row" >
            <label ><span style="color:#C3329B">Permission</span></label>
            <div class="check_permsnbox">

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="brand[]"  id="check-17" value="R"  <?php
                    if (strstr($brand, "R")) {
                        echo "checked='checked'";
                    }
                    ?>>

                    <label for="check-17">
                        <span class="check"></span>
                        <span class="box"></span>
                        Read
                    </label>
                </div>



                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="brand[]" id="check-18" value="C" <?php
                    if (strstr($brand, "C")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-18">
                        <span class="check"></span>
                        <span class="box"></span>
                        Create
                    </label>
                </div>

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="brand[]" id="check-19" value="U"  <?php
                    if (strstr($brand, "U")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-19">
                        <span class="check"></span>
                        <span class="box"></span>
                        Update
                    </label>
                </div>

                <!-- <div class="check-awesome" style="float: left;">  
                              <input type="checkbox" name="brand[]" value="D" id="check-20" <?php
//                            if (strstr($brand, "D")) {
//                                echo "checked='checked'";
//                            }
                ?>>
                              <label for="check-20">
                                <span class="check"></span>
                                <span class="box"></span>
                              Delete
                              </label>
                       </div>-->
            </div>
        </div>

        <hr/>  
        <div class="row">
            <label><span style="color:#002a80;">Product</span></label>
            <table>
                <tr>
                    <td>
                        <input type="radio" name="baseproduct_menu_info" value="S"  <?php
                        if (strstr($baseproduct_menu_info, "S")) {
                            echo "checked='checked'";
                        }
                        ?>>

                        <label>Show</label>
                    </td>
                    <td>
                        <input type="radio" name="baseproduct_menu_info" value="H" <?php
                        if (strstr($baseproduct_menu_info, "H")) {
                            echo "checked='checked'";
                        }
                        ?>>
                        <label>Hide</label>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row" >
            <label ><span style="color:#C3329B">Permission</span></label>
            <div class="check_permsnbox">

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="baseproduct[]"  id="check-21" value="R" <?php
                    if (strstr($baseproduct, "R")) {
                        echo "checked='checked'";
                    }
                    ?>>

                    <label for="check-21">
                        <span class="check"></span>
                        <span class="box"></span>
                        Read
                    </label>
                </div>



                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="baseproduct[]" id="check-22" value="C" <?php
                    if (strstr($baseproduct, "C")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-22">
                        <span class="check"></span>
                        <span class="box"></span>
                        Create
                    </label>
                </div>

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="baseproduct[]" id="check-23" value="U"  <?php
                    if (strstr($baseproduct, "U")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-23">
                        <span class="check"></span>
                        <span class="box"></span>
                        Update
                    </label>
                </div>

                <!-- <div class="check-awesome" style="float: left;">  
                              <input type="checkbox" name="baseproduct[]" id="check-24" value="D"  <?php
//                            if (strstr($baseproduct, "D")) {
//                                echo "checked='checked'";
//                            }
                ?>>
                              <label for="check-24">
                                <span class="check"></span>
                                <span class="box"></span>
                              Delete
                              </label>
                       </div>-->
            </div>
        </div>


        <hr/>    

        <div class="row">
            <label><span style="color:#002a80;">Orders</span></label>
            <table>
                <tr>
                    <td>
                        <input type="radio" name="orderinfo_menu_info" value="S"  <?php
                        if (strstr($orderinfo_menu_info, "S")) {
                            echo "checked='checked'";
                        }
                        ?>>
                        <!--  checked="checked" onclick="this.checked=!this.checked;"-->
                        <label>Show</label>
                    </td>
                    <td>
                        <input type="radio" name="orderinfo_menu_info" value="H" <?php
                        if (strstr($orderinfo_menu_info, "H")) {
                            echo "checked='checked'";
                        }
                        ?>>
                        <label>Hide</label>
                    </td>
                </tr>
            </table>
        </div> 
        <div class="row" >
            <label ><span style="color:#C3329B">Permission</span></label>
            <div class="check_permsnbox">

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="orderinfo[]" id="check-37" value="R" <?php
                    if (strstr($orderinfo, "R")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-37">
                        <span class="check"></span>
                        <span class="box"></span>
                        Read
                    </label>
                </div>



                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="orderinfo[]" id="check-38" value="C" <?php
                    if (strstr($orderinfo, "C")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-38">
                        <span class="check"></span>
                        <span class="box"></span>
                        Create
                    </label>
                </div>

                <div class="check-awesome" style="float: left;">  
                    <input type="checkbox" name="orderinfo[]"  for="check-39" value="U"  <?php
                    if (strstr($orderinfo, "U")) {
                        echo "checked='checked'";
                    }
                    ?>>
                    <label for="check-39">
                        <span class="check"></span>
                        <span class="box"></span>
                        Update
                    </label>
                </div>

                <!-- <div class="check-awesome" style="float: left;">  
                               <input type="checkbox" name="orderinfo[]" id="check-40" value="D"  <?php
//                            if (strstr($orderinfo, "D")) {
//                                echo "checked='checked'";
//                            }
                ?>>
                              <label for="check-40">
                                <span class="check"></span>
                                <span class="box"></span>
                              Delete
                              </label>
                       </div>-->
            </div>
        </div>


        <hr/>
        <div class="row">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo $form->dropDownList($model, 'status', array('0' => 'Disable', '1' => 'Enable')); ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    <script type="text/javascript">
        var url = '<?php echo Yii::app()->controller->createUrl("users/create"); ?>';
        function addCatFilter() {
            if (arguments.length === 0) {
                catId = 0;
            }
            var admin = $("#user_type option:selected").val();
            //Relaod with new category id
            if (admin == 'BrandAdmin') {
                document.getElementById("brand_id").style.display = "inline";
                return true;
            } else {
                document.getElementById("brand_id").style.display = "none";
                return true;
            }
        }
    </script>

</div><!-- form -->


