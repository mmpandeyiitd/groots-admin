<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="row-fluid">
    <div class="span2 background_grey" id="leftside_bar">
        <div class="logo_contain">
            <a  href="index.php?r=site/index" class="logo_side"> </a>
        </div>

        <div class="left_sidemenu" >
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
                       //array('label' => '<i class="fa fa-bullhorn"></i> Stores', 'url' => array('store/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] == "S" ? true : false)),
                       array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/SubscribedProduct/listallproduct', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
                        array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['category_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Buyers ', 'url' => array('/retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        //array('label' => '<i class="fa fa-list"></i> Retailer Product ', 'url' => array('/RetailerProductQuotation/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailerProductQuotation_menu_info'] == "S" ? true : false)),
                        //  array('label' => '<i class="fa fa-list"></i> Product ', 'url' => array('/baseProduct/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)),
                       // array('label' => '<i class="fa fa-user"></i>Admin Users', 'url' => array('/users/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['users_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
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
                        array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/SubscribedProduct/listallproduct', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
                        array('label' => '<i class="fa fa-shopping-bag"></i> Orders', 'url' => array('orderHeader/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['orderinfo_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['category_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Buyers', 'url' => array('/retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        // array('label' => '<i class="fa fa-list"></i> Retailer Request ', 'url' => array('/retailerRequest/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailerrequest_menu_info'] == "S" ? true : false)),
                        //array('label' => '<i class="fa fa-user"></i> Admin Users', 'url' => array('/users/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['users_menu_info'] == "S" ? true : false)),
                        //  array('label' => '<span class="staticItem">' . Yii::app()->session['store_name'] . ' </span>',),
                       // array('label' => '<i class="fa fa-bullhorn"></i>  Stores ', 'url' => array('store/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] == "S" ? true : false)),
                        //array('label' => '<span class="staticItem">' . Yii::app()->session['store_name'] . ' </span>',),
                       // array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/baseProduct/admin', 'store_id' => Yii::app()->session['brand_admin_id']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
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
                        // array('label' => '<i class="fa fa-shopping-bag"></i> Orders', 'url' => array('orderHeader/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['orderinfo_menu_info'] == "S" ? true : false)),
                       // array('label' => '<i class="fa fa-user"></i> Admin Users', 'url' => array('/users/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['users_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['category_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/SubscribedProduct/listallproduct', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
// array('label' => '<span class="staticItem">' . Yii::app()->session['store_name'] . ' </span>',),
                       // array('label' => '<i class="fa fa-bullhorn"></i>  Stores ', 'url' => array('store/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] == "S" ? true : false)),
                        //array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/baseProduct/admin', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
                        array('label' => '<i class="fa fa-bullhorn"></i>  Buyers ', 'url' => array('retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                       // array('label' => '<span class="staticItem">' . Yii::app()->session['name'] . ' </span>',),
                        //array('label' => '<i class="fa fa-modx"></i>retailer Product', 'url' => array('/retailerProductQuotation/admin', 'id' => $_REQUEST['id']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailerProductQuotation_menu_info'] == "S" ? true : false)),
                      //  array('label' => '<i class="fa fa-modx"></i>All Product', 'url' => array('/SubscribedProduct/admin', 'id' => $_REQUEST['id']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['subscribedProduct_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
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
                         array('label' => '<i class="fa fa-shopping-bag"></i> Orders', 'url' => array('orderHeader/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['orderinfo_menu_info'] == "S" ? true : false)),
                         //array('label' => '<i class="fa fa-user"></i> Admin Users', 'url' => array('/users/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['users_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/SubscribedProduct/listallproduct', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
                        array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['category_menu_info'] == "S" ? true : false)),
                       // array('label' => '<span class="staticItem">' . Yii::app()->session['store_name'] . ' </span>',),
                       // array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/baseProduct/admin', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
                        //array('label' => '<i class="fa fa-user"></i> Admin Users', 'url' => array('/users/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['users_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-bullhorn"></i>  Buyers ', 'url' => array('retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        //array('label' => '<span class="staticItem">' . Yii::app()->session['name'] . ' </span>',),
                        //array('label' => '<i class="fa fa-modx"></i>retailer Product', 'url' => array('/retailerProductQuotation/admin', 'id' => $_REQUEST['id']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailerProductQuotation_menu_info'] == "S" ? true : false)),
                        //array('label' => '<i class="fa fa-modx"></i>All Product', 'url' => array('/SubscribedProduct/admin', 'id' => $_REQUEST['id']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['subscribedProduct_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
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
                        // array('label' => '<i class="fa fa-shopping-bag"></i> Orders', 'url' => array('orderHeader/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['orderinfo_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['category_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-user"></i> Admin Users', 'url' => array('/users/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['users_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/baseProduct/admin', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
                        // array('label' => '<span class="staticItem">' . Yii::app()->session['store_name'] . ' </span>',),
                       //array('label' => '<i class="fa fa-bullhorn"></i>  Stores ', 'url' => array('store/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-bullhorn"></i>  Buyers ', 'url' => array('retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
//                        array('label' => '<span class="staticItem">' . Yii::app()->session['name'] . ' </span>',),
//                        array('label' => '<i class="fa fa-modx"></i>retailer Product', 'url' => array('/retailerProductQuotation/admin', 'id' => $_REQUEST['id']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailerProductQuotation_menu_info'] == "S" ? true : false)),
//                        array('label' => '<i class="fa fa-modx"></i>All Product', 'url' => array('/SubscribedProduct/admin', 'id' => $_REQUEST['id']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['subscribedProduct_menu_info'] == "S" ? true : false)),
//                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
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
                         array('label' => '<i class="fa fa-shopping-bag"></i> Orders', 'url' => array('orderHeader/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['orderinfo_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['category_menu_info'] == "S" ? true : false)),
                        //array('label' => '<i class="fa fa-user"></i> Admin Users', 'url' => array('/users/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['users_menu_info'] == "S" ? true : false)),
                         array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/baseProduct/admin', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)), 
                        // array('label' => '<span class="staticItem">' . Yii::app()->session['store_name'] . ' </span>',),
                        //array('label' => '<i class="fa fa-bullhorn"></i>  Stores ', 'url' => array('store/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-bullhorn"></i>  Buyers ', 'url' => array('retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
//                        array('label' => '<span class="staticItem">' . Yii::app()->session['name'] . ' </span>',),
//                        array('label' => '<i class="fa fa-modx"></i>retailer Product', 'url' => array('/retailerProductQuotation/admin', 'id' => $_REQUEST['id']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailerProductQuotation_menu_info'] == "S" ? true : false)),
//                        array('label' => '<i class="fa fa-modx"></i>All Product', 'url' => array('/SubscribedProduct/admin', 'id' => $_REQUEST['id']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['subscribedProduct_menu_info'] == "S" ? true : false)),
//                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
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
                        // array('label' => '<i class="fa fa-shopping-bag"></i> Orders', 'url' => array('orderHeader/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['orderinfo_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['category_menu_info'] == "S" ? true : false)),
                       // array('label' => '<i class="fa fa-user"></i> Admin Users', 'url' => array('/users/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['users_menu_info'] == "S" ? true : false)),
                        // array('label' => '<span class="staticItem">' . Yii::app()->session['store_name'] . ' </span>',),
                       // array('label' => '<i class="fa fa-bullhorn"></i>  Stores ', 'url' => array('store/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-bullhorn"></i>  Buyers ', 'url' => array('retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
//                        array('label' => '<span class="staticItem">' . Yii::app()->session['name'] . ' </span>',),
//                        array('label' => '<i class="fa fa-modx"></i>retailer Product', 'url' => array('/retailerProductQuotation/admin', 'id' => $_REQUEST['id']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailerProductQuotation_menu_info'] == "S" ? true : false)),
//                        // array('label' => '<i class="fa fa-modx"></i>All Product', 'url' => array('/SubscribedProduct/admin', 'id' => $_REQUEST['id']), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['subscribedProduct_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
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
                        array('label' => '<i class="fa fa-shopping-bag"></i> Orders', 'url' => array('orderHeader/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['orderinfo_menu_info'] == "S" ? true : false)),
                        array('label' => '<i class="fa fa-list"></i> Buyers', 'url' => array('/retailer/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] == "S" ? true : false)),
                        //array('label' => '<i class="fa fa-list"></i> Retailer Request ', 'url' => array('/retailerRequest/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['retailerrequest_menu_info'] == "S" ? true : false)),
                      //  array('label' => '<i class="fa fa-bullhorn"></i>My Profile', 'url' => array('store/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] == "S" ? true : false)),
                      //  array('label' => '<i class="fa fa-modx"></i> Styles', 'url' => array('/baseProduct/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] == "S" ? true : false)),
//                        array('label' => '<i class="fa fa-wrench"></i> LineSheets', 'url' => array('/storeFront/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['linesheet_menu_info'] == "S" ? true : false)),
//                        array('label' => '<i class="fa fa-newspaper-o"></i> Press Release', 'url' => array('pressRelease/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['pressrelease_menu_info'] == "S" ? true : false)),
//                        array('label' => '<i class="fa fa-picture-o"></i> Photo Gallery', 'url' => array('/lookbook/Adminphoto'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['photogallery_menu_info'] == "S" ? true : false)),
//                        array('label' => '<i class="fa fa-search-plus"></i> LookBooks', 'url' => array('/lookbook/admin'), 'visible' => (@Yii::app()->session['premission_info']['menu_info']['lookbook_menu_info'] == "S" ? true : false)),
//                        array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
                        array('label' => '<i class="fa fa-sign-out"></i> Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => "")),
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
        //array('label'=>'<i class="icon icon-home"></i>  Dashboard <span class="label label-info pull-right">BETA</span>', 'url'=>'#','itemOptions'=>array('class'=>'')),
        //array('label'=>'<i class="icon icon-search"></i> About this theme <span class="label label-important pull-right">HOT</span>', 'url'=>'#'),
        //array('label'=>'<i class="icon icon-envelope"></i> Messages <span class="badge badge-success pull-right">12</span>', 'url'=>'#'),
        // Include the operations menu
        array('label' => 'OPERATIONS', 'items' => $this->menu),
    ),
));
?>
        </div>
        <br>
       <!-- <table class="table table-striped table-bordered">
          <tbody>
            <tr>
              <td width="50%">Bandwith Usage</td>
              <td>
                <div class="progress progress-danger">
                  <div class="bar" style="width: 80%"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td>Disk Spage</td>
              <td>
                <div class="progress progress-warning">
                  <div class="bar" style="width: 60%"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td>Conversion Rate</td>
              <td>
                <div class="progress progress-success">
                  <div class="bar" style="width: 40%"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td>Closed Sales</td>
              <td>
                <div class="progress progress-info">
                  <div class="bar" style="width: 20%"></div>
                </div>
              </td>
            </tr>
          </tbody>
        </table> 
                <div class="well">
        
            <dl class="dl-horizontal">
              <dt>Account status</dt>
              <dd>$1,234,002</dd>
              <dt>Open Invoices</dt>
              <dd>$245,000</dd>
              <dt>Overdue Invoices</dt>
              <dd>$20,023</dd>
              <dt>Converted Quotes</dt>
              <dd>$560,000</dd>
              
            </dl>
      </div>-->

    </div><!--/span-->
    <div class="header_top">
        <span class="title"><?php include("column3.php"); ?></span>
        <ul class="tab_list">
<?php include("column4.php"); ?>  
        </ul>
        <!--        <div class="message_box">
        
                    <div style="clear:both;"></div>
                    <h4><a href="#"><i class="fa fa-envelope-o"></i> <span>10</span></a></h4>
                </div>-->
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