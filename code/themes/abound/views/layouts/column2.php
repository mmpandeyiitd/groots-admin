<?php /* @var $this Controller */
$store_id = Yii::app()->session['brand_admin_id'];
$userAuthItemArr = Utility::getUserAuthItemsArrFromSession();
$meunAuthItemMap = array(
    'report'=>array('SuperAdmin'),
    //'collection' => array('SuperAdmin'),
    'collection' => array('OrderViewer', 'InventoryViewer', 'TransferViewer', 'PurchaseViewer', 'ProcurementViewer'),
    'buyer' => array('SuperAdmin'),
    'category' => array('SuperAdmin'),
    'product' => array('SuperAdmin'),
    'order' => array('SuperAdmin'),
    'dashboard' => array('SuperAdmin'),
    'vendors' => array('SuperAdmin'),
    'warehouse' => array('OrderViewer', 'InventoryViewer', 'TransferViewer', 'PurchaseViewer', 'ProcurementViewer'),
    'warehouseOrder' => array('OrderViewer'),
    'warehouseInventory' => array('InventoryViewer'),
    'warehouseTransfer' => array('TransferViewer'),
    'warehousePurchase' => array('PurchaseViewer'),
    'warehouseProcurement' => array('ProcurementViewer'),
);
$isReportVisible = isMenuVisible($meunAuthItemMap['report']);
//$isCollectionVisible = isMenuVisible($meunAuthItemMap['collection']);
$isBuyerVisible = isMenuVisible($meunAuthItemMap['buyer']);
$isCategoryVisible = isMenuVisible($meunAuthItemMap['category']);
$isProductVisible = isMenuVisible($meunAuthItemMap['product']);
$isOrderVisible = isMenuVisible($meunAuthItemMap['order']);
$isDashboardVisible = isMenuVisible($meunAuthItemMap['dashboard']);
$isVendorVisible = isMenuVisible($meunAuthItemMap['vendors']);
//$isWarehouseVisible = isMenuVisible($meunAuthItemMap['warehouse'], array('warehouse_id'=>1));
//$isReportVisible = true;
//var_dump($this->context);die("here");
//die("123");
function isMenuVisible($authItemArr, $data=null){
    foreach ($authItemArr as $item){
        $access = Yii::app()->user->checkAccess($item, $data, false);
        //echo $access; die;
        if($access){
            return true;
        }
    }
    return false;
}

$logoutArr = array('label' => '<i class="fa fa-sign-out"></i> Logout', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest,'linkOptions'=>array('confirm'=>'Are you sure want to logout ?'));
$loginArr = array('label' => '<i class="fa fa-sign-in"></i> Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array("data-description" => ""));
$reportArr = array('label' => '<i class="fa fa-list"></i> Reports', 'url' => array('/GrootsLedger/report'), 'visible' => $isReportVisible);
//$collectionArr = array('label' => '<i class="fa fa-list"></i> Collection management', 'url' => array('/Grootsledger/admin'), 'visible' => $isCollectionVisible);
$buyerArr = array('label' => '<i class="fa fa-list"></i> Buyers', 'url' => array('/retailer/admin'), 'visible' =>$isBuyerVisible);
$categoryArr = array('label' => '<i class="fa fa-sitemap"></i> Category', 'url' => array('/category/index'), 'visible' => $isCategoryVisible);
$productArr = array('label' => '<i class="fa fa-modx"></i>product', 'url' => array('/SubscribedProduct/listallproduct', 'store_id' => Yii::app()->session['is_super_admin']), 'visible' => $isProductVisible);
$regOffArray = array('label' => '<i class="fa fa-bullhorn"></i> Reg Office', 'url' => array('/store/update&id=1'), 'visible' => false);
$orderArr = array('label' => '<i class="fa fa-shopping-bag"></i> Orders ', 'url' => array('/orderHeader/admin'), 'visible' => $isOrderVisible);
$dashboardArr = array('label' => '<i class="fa fa-dashboard"></i> Dashboard', 'url' => array('/DashboardPage/index'), 'visible' => $isDashboardVisible);
$vendorArr = array('label' => '<i class="fa fa-list"></i> Vendors', 'url' => array('/vendor/index'), 'visible' =>$isVendorVisible);

function generateOrderMenu($id, $meunAuthItemMap){
    if(isMenuVisible($meunAuthItemMap['warehouseOrder'], array('warehouse_id'=>$id))){
        return array('label' => '<i ></i> Order', 'url' => array('/orderHeader/admin&w_id='.$id), 'visible' => true);
    }
    else{
        return array();
    }
}

function generateInventoryMenu($id, $meunAuthItemMap){
    if(isMenuVisible($meunAuthItemMap['warehouseInventory'], array('warehouse_id'=>$id))){
        return array('label' => '<i ></i> Inventory', 'url' => array('/inventory/create&w_id='.$id), 'visible' => true);
    }
    else{
        return array();
    }
}

function generatePurchaseMenu($id, $meunAuthItemMap){
    if(isMenuVisible($meunAuthItemMap['warehousePurchase'], array('warehouse_id'=>$id))){
        return  array('label' => '<i ></i> Purchase', 'url' => array('/purchaseHeader/admin&w_id='.$id), 'visible' => true);
    }
    else{
        return array();
    }
}

function generateTransferMenu($id, $meunAuthItemMap){
    if(isMenuVisible($meunAuthItemMap['warehouseTransfer'], array('warehouse_id'=>$id))){
        return array('label' => '<i ></i> Transfer', 'url' => array('/transferHeader/admin&w_id='.$id), 'visible' => true);
    }
    else{
        return array();
    }
}

function generateProcurementMenu($id, $meunAuthItemMap){
    if(isMenuVisible($meunAuthItemMap['warehouseProcurement'], array('warehouse_id'=>$id))){
        return  array('label' => '<i ></i> Procurement', 'url' => array('/purchaseHeader/admin&w_id='.$id), 'visible' => true);
    }
    else{
        return array();
    }
}


function generateWarehouseItems($w_id, $meunAuthItemMap){
    $warehouseItems = array();
    $orderItem = generateOrderMenu($w_id, $meunAuthItemMap);
    if(sizeof($orderItem) > 0){
        array_push($warehouseItems, $orderItem);
    }
    $invItem = generateInventoryMenu($w_id, $meunAuthItemMap);
    if(sizeof($invItem) > 0){
        array_push($warehouseItems, $invItem);
    }
    $purchaseItem = generatePurchaseMenu($w_id, $meunAuthItemMap);
    if(sizeof($purchaseItem) > 0){
        array_push($warehouseItems, $purchaseItem);
    }
    $transferItem = generateTransferMenu($w_id, $meunAuthItemMap);
    if(sizeof($transferItem) > 0){
        array_push($warehouseItems, $transferItem);
    }
    $procurementItem = generateProcurementMenu($w_id, $meunAuthItemMap);
    if(sizeof($procurementItem) > 0){
        array_push($warehouseItems, $procurementItem);
    }
    return $warehouseItems;
}

$access0 = Yii::app()->user->checkAccess('SuperAdmin', false);
$access1 = Yii::app()->user->checkAccess('WarehouseEditor', array('warehouse_id'=>1), false);
$access2 = Yii::app()->user->checkAccess('WarehouseEditor', array('warehouse_id'=>2), false);
$collectionUrl = '';
if($access0){
    $collectionUrl = array('/Grootsledger/admin&w_id=3');
}
elseif($access1){
    $collectionUrl = array('/Grootsledger/admin&w_id=1');
}
elseif($access2){
    $collectionUrl = array('/Grootsledger/admin&w_id=2');
}


$warehouses = generateWarehouses($meunAuthItemMap);
$isWarehouseVisible = sizeof($warehouses)>0 ? true : false;
$collectionArr = array('label' => '<i class="fa fa-list"></i> Collection management', 'url' => $collectionUrl, 'visible' => $isWarehouseVisible);
$warehouseArr = array('label' => '<i ></i> Warehouse +', 'url' =>'#', 'visible' => $isWarehouseVisible,
    'items'=> $warehouses,
    'itemCssClass' => 'ex1',
    //'htmlOptions' => array('class' => 'dropdown-submenu'),
    //'submenuHtmlOptions' => array('class' => 'dropdown-submenu'),

);

function generateWarehouses($meunAuthItemMap){
    $warehouses = Warehouse::model()->findAllByAttributes(array('status'=>1), array('select'=> 'id, name'));
    $warehouseMenuArr = array();
    foreach ($warehouses as $warehouse){
        $id = $warehouse->id;
        $warehouseItems = generateWarehouseItems($id, $meunAuthItemMap);
        $isThisWarehouseVisible = sizeof($warehouseItems)>0 ? true : false;
        if($isThisWarehouseVisible){
            $m = array('label' => '<i ></i> '.$warehouse->name, 'url' => '#', 'visible' => $isThisWarehouseVisible, 'items'=> $warehouseItems,
                //'htmlOptions' => array('class' => 'dropdown-submenu'),
            );
            array_push($warehouseMenuArr, $m);
        }

    }
    return $warehouseMenuArr;
}


?>
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
            <nav class="vertical">
            <?php
            $this->widget('zii.widgets.CMenu', array(
                //'htmlOptions' => array('class' => 'nav navbar-nav'),
                //'submenuHtmlOptions' => array('class' => 'dropdown-submenu'),
                'itemCssClass' => 'ex1',
                'encodeLabel' => false,
                'items' => array(
                    $dashboardArr,
                    $orderArr,
                    $warehouseArr,
                    //$regOffArray,
                    $productArr,
                    $categoryArr,
                    $buyerArr,
                    $vendorArr,
                    $collectionArr,
                    $reportArr,
                    $loginArr,
                    $logoutArr,

                ),
            ));

            ?>
            </nav>
            <?php

            /*if ((Yii::app()->session['is_super_admin'] == 1) && (!isset(Yii::app()->session['brand_admin_id']))&& (isset(Yii::app()->session['is_super_admin'])) && ($_REQUEST['r'] != 'retailer/update') && ($_REQUEST['r'] != 'SubscribedProduct/admin') && ($_REQUEST['r'] != 'subscribedProduct/mappedProduct') && ($_REQUEST['r'] != 'retailerProductQuotation/admin')) {
                $store_id = Yii::app()->session['brand_admin_id'];
                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array('class' => 'nav'),
                    'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
                    'itemCssClass' => 'item-test',
                    'encodeLabel' => false,
                    'items' => array(
                        $dashboardArr,
                        $orderArr,
                        $warehouseArr,
                        $regOffArray,
                        $productArr,
                        $categoryArr,
                        $buyerArr,
                        $collectionArr,
                        $reportArr,
                        $loginArr,
                        $logoutArr,

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
                        $dashboardArr,
                        $orderArr,
                        $warehouseArr,
                        $regOffArray,
                        $productArr,
                        $categoryArr,
                        $buyerArr,
                        $collectionArr,
                        $reportArr,
                        $loginArr,
                        $logoutArr,
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
                        $orderArr,
                        $warehouseArr,
                        $regOffArray,

                        $productArr,
                        $categoryArr,
                        $buyerArr,
                        $collectionArr,
                        $reportArr,
                        $loginArr,
                        $logoutArr,
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
                        $dashboardArr,
                        $orderArr,
                        $warehouseArr,
                        $regOffArray,

                        $productArr,
                        $categoryArr,
                        $buyerArr,
                        $collectionArr,
                        $reportArr,
                        $loginArr,
                        $logoutArr,
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
                        $dashboardArr,
                        $orderArr,
                        $warehouseArr,
                        $regOffArray,

                        $productArr,
                        $categoryArr,
                        $buyerArr,
                        $collectionArr,
                        $reportArr,
                        $loginArr,
                        $logoutArr,
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
                        $dashboardArr,
                        $orderArr,
                        $warehouseArr,
                        $regOffArray,

                        $productArr,
                        $categoryArr,
                        $buyerArr,
                        $collectionArr,
                        $reportArr,
                        $loginArr,
                        $logoutArr,
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
                        $dashboardArr,
                        $orderArr,
                        $warehouseArr,
                        $regOffArray,
                        $productArr,
                        $categoryArr,
                        $buyerArr,
                        $collectionArr,
                        $reportArr,
                        $loginArr,
                        $logoutArr,
                      ),
                ));
            } else {


                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array('class' => 'nav'),
                    'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
                    'itemCssClass' => 'item-test',
                    'encodeLabel' => false,
                    'items' => array(
                        $dashboardArr,
                        $orderArr,
                        $warehouseArr,

                        $regOffArray,
                        $productArr,
                        $categoryArr,
                        $buyerArr,
                        $collectionArr,
                        $reportArr,
                        $loginArr,
                        $logoutArr,
                     ),
                ));
            }*/
            ?>

        </div>
        <div class="sidebar-nav">



<?php


/*
$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => false,
    'items' => array(
       
        array('label' => 'OPERATIONS', 'items' => $this->menu),
    ),
));*/
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
    <div class="span9 right_section" style="z-index: 1;">
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