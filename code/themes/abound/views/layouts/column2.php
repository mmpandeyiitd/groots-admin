<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="row-fluid">
    <div class="span2 background_grey" id="leftside_bar">
        <div class="logo_contain">
            <a  href="index.php?r=site/index" class="logo_side"> </a>
        </div>

        <div class="left_sidemenu" >
            <div class="menuUser">
                <span><i class="fa fa-user"></i></span>
                <h3> <?php echo Yii::app()->user->name; ?></h3>
               
            </div>
            <?php
            if ((Yii::app()->session['is_super_admin'] == 1) && (!isset(Yii::app()->session['brand_admin_id']))&& (isset(Yii::app()->session['is_super_admin'])) && ($_REQUEST['r'] != 'retailer/update') && ($_REQUEST['r'] != 'SubscribedProduct/admin') && ($_REQUEST['r'] != 'subscribedProduct/mappedProduct') && ($_REQUEST['r'] != 'retailerProductQuotation/admin')) {
                $store_id = Yii::app()->session['brand_admin_id'];
                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array('class' => 'nav'),
                    'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
                    'itemCssClass' => 'item-test',
                    'encodeLabel' => false,
                    'items' => array(
                        array('label' => '<i class="fa fa-dashboard"></i> Dashboard', 'url' => array('/DashboardPage/index'), 'visible' => true),
                        array('label' => '<i class="fa fa-shopping-bag"></i> Orders ', 'url' => array('orderHeader/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['orderinfo_menu_info'] == "S" ? true : false)),
                       array('label' => '<i class="fa fa-bullhorn"></i> Reg Office', 'url' => array('store/update&id=1'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] == "S" ? true : false)),
                       array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/SubscribedProduct/listallproduct', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
                        array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['category_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Buyers', 'url' => array('/retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Collection management', 'url' => array('/Grootsledger/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Reports', 'url' => array('/GrootsLedger/report'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                      
                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest,'linkOptions'=>array('confirm'=>'Are you sure want to logout ?')),
                    ),
                ));
            } elseif ((Yii::app()->session['is_super_admin'] == 1) && (isset(Yii::app()->session['brand_admin_id'])) && ($_REQUEST['r'] != 'retailer/update')) {
                $store_id = Yii::app()->session['brand_admin_id'];
                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array('class' => 'nav'),
                    'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
                    'itemCssClass' => 'item-test',
                    'encodeLabel' => false,
                    'items' => array(
                        array('label' => '<i class="fa fa-dashboard"></i> Dashboard', 'url' => array('/DashboardPage/index'), 'visible' => true),
                        array('label' => '<i class="fa fa-shopping-bag"></i> Orders ', 'url' => array('orderHeader/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['orderinfo_menu_info'] == "S" ? true : false)),
                      
                      array('label' => '<i class="fa fa-bullhorn"></i> Reg Office', 'url' => array('store/update&id=1'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/SubscribedProduct/listallproduct', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
                        array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['category_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Buyers', 'url' => array('/retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Collection management', 'url' => array('/Grootsledger/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                       array('label' => '<i class="fa fa-list"></i> Reports', 'url' => array('/GrootsLedger/report'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest,'linkOptions'=>array('confirm'=>'Are you sure want to logout ?')),
                    ),
                ));
            } elseif ((Yii::app()->session['is_super_admin'] == 1) && ($_REQUEST['r'] == 'retailer/update')) {
                $store_id = Yii::app()->session['brand_admin_id'];
                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array('class' => 'nav'),
                    'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
                    'itemCssClass' => 'item-test',
                    'encodeLabel' => false,
                    'items' => array(
                        array('label' => '<i class="fa fa-dashboard"></i> Dashboard', 'url' => array('/DashboardPage/index'), 'visible' => true),
                        array('label' => '<i class="fa fa-shopping-bag"></i> Orders ', 'url' => array('orderHeader/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['orderinfo_menu_info'] == "S" ? true : false)),
                      array('label' => '<i class="fa fa-bullhorn"></i> Reg Office', 'url' => array('store/update&id=1'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] == "S" ? true : false)),
                       
                       array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/SubscribedProduct/listallproduct', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
                        array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['category_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Buyers', 'url' => array('/retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                         array('label' => '<i class="fa fa-list"></i> Collection management', 'url' => array('/Grootsledger/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                         array('label' => '<i class="fa fa-list"></i> Reports', 'url' => array('/GrootsLedger/report'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        
                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest,'linkOptions'=>array('confirm'=>'Are you sure want to logout ?')),
                    ),
                ));
            } elseif ((Yii::app()->session['is_super_admin'] == 1) && ($_REQUEST['r'] == 'SubscribedProduct/admin')) {
                $store_id = Yii::app()->session['brand_admin_id'];
                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array('class' => 'nav'),
                    'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
                    'itemCssClass' => 'item-test',
                    'encodeLabel' => false,
                    'items' => array(
                        array('label' => '<i class="fa fa-dashboard"></i> Dashboard', 'url' => array('/DashboardPage/index'), 'visible' => true),
                        array('label' => '<i class="fa fa-shopping-bag"></i> Orders ', 'url' => array('orderHeader/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['orderinfo_menu_info'] == "S" ? true : false)),
                      array('label' => '<i class="fa fa-bullhorn"></i> Reg Office', 'url' => array('store/update&id=1'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] == "S" ? true : false)),
                     
                       array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/SubscribedProduct/listallproduct', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
                        array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['category_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Buyers', 'url' => array('/retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Collection management', 'url' => array('/Grootsledger/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Reports', 'url' => array('/GrootsLedger/report'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest,'linkOptions'=>array('confirm'=>'Are you sure want to logout ?')),
                    ),
                ));
            } elseif ((Yii::app()->session['is_super_admin'] == 1) && ($_REQUEST['r'] == 'subscribedProduct/mappedProduct')) {
                $store_id = Yii::app()->session['brand_admin_id'];
                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array('class' => 'nav'),
                    'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
                    'itemCssClass' => 'item-test',
                    'encodeLabel' => false,
                    'items' => array(
                        array('label' => '<i class="fa fa-dashboard"></i> Dashboard', 'url' => array('/DashboardPage/index'), 'visible' => true),
                        array('label' => '<i class="fa fa-shopping-bag"></i> Orders ', 'url' => array('orderHeader/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['orderinfo_menu_info'] == "S" ? true : false)),
                       array('label' => '<i class="fa fa-bullhorn"></i> Reg Office', 'url' => array('store/update&id=1'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] == "S" ? true : false)),
  
                       array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/SubscribedProduct/listallproduct', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
                        array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['category_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Buyers', 'url' => array('/retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                         array('label' => '<i class="fa fa-list"></i> Collection management', 'url' => array('/Grootsledger/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                         array('label' => '<i class="fa fa-list"></i> Reports', 'url' => array('/GrootsLedger/report'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        
                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest,'linkOptions'=>array('confirm'=>'Are you sure want to logout ?')),
                     ),
                ));
            } elseif ((Yii::app()->session['is_super_admin'] == 1) && ($_REQUEST['r'] == 'retailerProductQuotation/admin') && ($_REQUEST['id'] != '')) {
                $store_id = Yii::app()->session['brand_admin_id'];
                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array('class' => 'nav'),
                    'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
                    'itemCssClass' => 'item-test',
                    'encodeLabel' => false,
                    'items' => array(
                        array('label' => '<i class="fa fa-dashboard"></i> Dashboard', 'url' => array('/DashboardPage/index'), 'visible' => true),
                        array('label' => '<i class="fa fa-shopping-bag"></i> Orders ', 'url' => array('orderHeader/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['orderinfo_menu_info'] == "S" ? true : false)),
                      array('label' => '<i class="fa fa-bullhorn"></i> Reg Office', 'url' => array('store/update&id=1'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] == "S" ? true : false)),
                       
                       array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/SubscribedProduct/listallproduct', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
                        array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['category_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Buyers', 'url' => array('/retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                         array('label' => '<i class="fa fa-list"></i> Collection management', 'url' => array('/Grootsledger/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                         array('label' => '<i class="fa fa-list"></i> Reports', 'url' => array('/GrootsLedger/report'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        
                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest,'linkOptions'=>array('confirm'=>'Are you sure want to logout ?')),
                     ),
                ));
            } elseif ((Yii::app()->session['is_super_admin'] == 1) && ($_REQUEST['r'] == 'retailerProductQuotation/admin') && ($_REQUEST['id'] == '')) {
                $store_id = Yii::app()->session['brand_admin_id'];
                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array('class' => 'nav'),
                    'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
                    'itemCssClass' => 'item-test',
                    'encodeLabel' => false,
                    'items' => array(
                       array('label' => '<i class="fa fa-dashboard"></i> Dashboard', 'url' => array('/DashboardPage/index'), 'visible' => true),
                        array('label' => '<i class="fa fa-shopping-bag"></i> Orders ', 'url' => array('orderHeader/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['orderinfo_menu_info'] == "S" ? true : false)),
                      array('label' => '<i class="fa fa-bullhorn"></i> Reg Office', 'url' => array('store/update&id=1'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] == "S" ? true : false)),
                        
                       array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/SubscribedProduct/listallproduct', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
                        array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['category_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Buyers', 'url' => array('/retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                         array('label' => '<i class="fa fa-list"></i> Collection management', 'url' => array('/Grootsledger/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                         array('label' => '<i class="fa fa-list"></i> Reports', 'url' => array('/GrootsLedger/report'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest,'linkOptions'=>array('confirm'=>'Are you sure want to logout ?')),
                      ), 
                ));
            } else {


                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array('class' => 'nav'),
                    'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
                    'itemCssClass' => 'item-test',
                    'encodeLabel' => false,
                    'items' => array(
                       array('label' => '<i class="fa fa-dashboard"></i> Dashboard', 'url' => array('/DashboardPage/index'), 'visible' => true),
                        array('label' => '<i class="fa fa-shopping-bag"></i> Orders ', 'url' => array('orderHeader/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['orderinfo_menu_info'] == "S" ? true : false)),
                       array('label' => '<i class="fa fa-bullhorn"></i> Reg Office', 'url' => array('store/update&id=1'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] == "S" ? true : false)),

                       array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/SubscribedProduct/listallproduct', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
                        array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['category_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Buyers', 'url' => array('/retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                           array('label' => '<i class="fa fa-list"></i> Collection management', 'url' => array('/Grootsledger/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Reports', 'url' => array('/GrootsLedger/report'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        
                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest,'linkOptions'=>array('confirm'=>'Are you sure want to logout ?')),
                     ),
                ));
            }
            ?>
        </div>
        <div class="sidebar-nav">



<?php
$this->widget('zii.widgets.CMenu', array(
    /* 'type'=>'list', */
    'encodeLabel' => false,
    'items' => array(
       
        array('label' => 'OPERATIONS', 'items' => $this->menu),
    ),
));
?>
        </div>
        <br>
      

    </div><!--/span-->
    <div class="header_top">
        <span class="title"><?php include("column3.php"); ?></span>
        <ul class="tab_list">
<?php include("column4.php"); ?>  
        </ul>
        
<?php if (isset($this->breadcrumbs)): ?>
            <?php
            $this->widget('zii.widgets.CBreadcrumbs', array(
                'links' => $this->breadcrumbs,
                'homeLink' => CHtml::link('Dashboard', array('DashboardPage/index')),
                'htmlOptions' => array('class' => 'breadcrumb')
            ));
            ?> 
        <?php endif ?>

    </div> 
    <div class="span2 ">
        &nbsp;
    </div>
    <div class="span9 right_section">
        <div class="">




            <!-- Include content pages -->
<?php echo $content; ?>

        </div><!--/span-->
    </div><!--/row-->
</div>

<?php $this->endContent(); ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<script type="text/javascript">//<![CDATA[ 
    function resize()
    {
        var heights = window.innerHeight;
        document.getElementById("leftside_bar").style.height = heights + "px";
    }
    resize();
    window.onresize = function () {
        resize();
    };
    //]]>  

</script> 