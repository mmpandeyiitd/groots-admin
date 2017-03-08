<?php
if(Yii::app()->session['is_super_admin']){
    $store_id = 1;
       $id='';
}else{
    $store_id = 1;
       $id='';
}




if (Yii::app()->controller->id == "DashboardPage") {

    echo '<li><a href="index.php?r=baseProduct/bulkuploadstore_id=1">Bulk Upload subscribed product</a></li> ';
}
/*elseif (Yii::app()->controller->id == "orderHeader") {


    if (Yii::app()->controller->action->id == "admin") {

        echo '<li><a href="index.php?r=orderHeader/create&store_id=' . $store_id . '">Create Order</a></li> 
        <!--<li><a href="index.php?r=orderHeader/bulkupload&store_id=1">Bulk Upload Orders</a></li> !-->
        ';
    }
    else if (Yii::app()->controller->action->id == "create"  ) {

        echo '<li><a href="index.php?r=orderHeader/admin">order List</a></li> ';
    }  
     elseif (substr_count(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C') > 0) {
        //echo '<li><a href="index.php?r=SubscribedProduct/listallproduct&store_id=' . $store_id . '">product List</a></li> ';
    }
}*/
 else if (Yii::app()->controller->id == "users") {
    if (Yii::app()->controller->action->id == "create" ) {
        echo '<li><a href="index.php?r=users/admin">Admin User List</a></li> ';
    } else if (Yii::app()->controller->action->id == "update" ) {
        echo '<li><a href="index.php?r=users/admin">Admin User List</a></li> ';
    } else if (Yii::app()->controller->action->id == "admin" ) {
        echo '<li><a href="index.php?r=users/create">Create Admin User</a></li> ';
    }
} elseif (Yii::app()->controller->id == "category") {

    if (Yii::app()->controller->action->id == "create" ) {
        echo '<li><a href="index.php?r=category/index">Category List</a></li> ';
    } else if (Yii::app()->controller->action->id == "index" ) {
        echo '<li><a href="index.php?r=category/create">Create Category</a></li> ';
    }
} else if (Yii::app()->controller->id == "retailer") {
    if (Yii::app()->controller->action->id == "create" ) {
        echo '<li><a href="index.php?r=retailer/admin">Admin Buyers List</a></li> ';
    } else if (Yii::app()->controller->action->id == "update" ) {
        echo '<li><a href="index.php?r=retailer/admin">Admin Buyers List</a></li> ';
    } else if (Yii::app()->controller->action->id == "admin" ) {
        echo '<li><a href="index.php?r=retailer/create">Create Buyer'
        . ' </a></li> ';
    }
}  else if (Yii::app()->controller->id == "retailerProductQuotation") {
    //echo '<pre>';print_r($_REQUEST);die;
//    echo '.$_REQUEST["id"].';
    //echo '<pre>';print_r($_REQUEST);die;
   // $id== $_REQUEST['id'];
    
    if (Yii::app()->controller->action->id == "create" ) {
  //  echo '<li><a href="index.php?r=retailerProductQuotation/admin&id=adminlist">Retailer Product List</a></li> ';
    } else if (Yii::app()->controller->action->id == "update" ) {
       // echo '<li><a href="index.php?r=retailerProductQuotation/admin&id=adminlist">Retailer Product List</a></li> ';
    } else if (Yii::app()->controller->action->id == "admin" ) {
        //echo '<li><a href="index.php?r=retailerProductQuotation/create">Create Retailer Product </a></li> '
       // . '<li><a href="index.php?r=retailer/admin">Mapped Retailer </a></li>';
    }
}
elseif (Yii::app()->controller->id == "store") {

    if (Yii::app()->controller->action->id == "create" ) {

     //   echo '<li><a href="index.php?r=store/admin">Store List</a></li> ';
    } else if (Yii::app()->controller->action->id == "admin" ) {

        echo '<li><a href="index.php?r=store/create">Create Store</a></li> ';
    } else if ((Yii::app()->controller->action->id == "update") ) {

       // echo '<li><a href="index.php?r=store/admin">Store List</a></li> ';
    }
} elseif (Yii::app()->controller->id == "baseProduct") {

    if (Yii::app()->controller->action->id == "create" ) {

        echo '<li><a href="index.php?r=SubscribedProduct/listallproduct&store_id=' . $store_id . '">product List</a></li> ';
    } else if (Yii::app()->controller->action->id == "admin") {

        echo '<li><a href="index.php?r=baseProduct/create&store_id=' . $store_id . '">Create product</a></li> 
        <li><a href="index.php?r=baseProduct/bulkupload&store_id=1">Bulk Upload product</a></li> 
        ';
    }
    
   /* else if (Yii::app()->controller->action->id == "admin" && substr_count(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C') > 0) {

        echo '<li><a href="index.php?r=baseProduct/create&store_id=' . $store_id . '">Create product</a></li> 
        <li><a href="index.php?r=baseProduct/bulkupload&store_id=' . $store_id . '">Bulk Upload product</a></li>        
         <li><a href="index.php?r=baseProduct/media&store_id=' . $store_id . '">Bulk Upload Media</a></li>        
         <li><a href="index.php?r=baseProduct/configurablegrid&store_id=' . $store_id . '">Add Recommended</a></li> ';
    }*/else if (Yii::app()->controller->action->id == "update") {

        echo '<li><a href="index.php?r=SubscribedProduct/listallproduct&store_id=' . $store_id . '">product List</a></li> ';
    } elseif (substr_count(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C') > 0) {
        echo '<li><a href="index.php?r=SubscribedProduct/listallproduct&store_id=' . $store_id . '">product List</a></li> ';
    }
} elseif($_REQUEST['r']=='SubscribedProduct/listallproduct'){

    if (Yii::app()->controller->action->id == "create"  && substr_count(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'R') > 0) {

        echo '<li><a href="index.php?r=SubscribedProduct/listallproduct&store_id=' . $store_id . '">product List</a></li> ';
    } else if (Yii::app()->controller->action->id == "listallproduct") {

        echo '<li><a href="index.php?r=baseProduct/create&store_id=' . $store_id . '">Create product</a></li> 
        <li><a href="index.php?r=baseProduct/bulkupload&store_id=1">Bulk Upload product</a></li>  <li><a href="index.php?r=baseProduct/Media">Bulk Media Images</a></li>
        
         ';
    }
    
   /* else if (Yii::app()->controller->action->id == "admin" && substr_count(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C') > 0) {

        echo '<li><a href="index.php?r=baseProduct/create&store_id=' . $store_id . '">Create product</a></li> 
        <li><a href="index.php?r=baseProduct/bulkupload&store_id=' . $store_id . '">Bulk Upload product</a></li>        
         <li><a href="index.php?r=baseProduct/media&store_id=' . $store_id . '">Bulk Upload Media</a></li>        
         <li><a href="index.php?r=baseProduct/configurablegrid&store_id=' . $store_id . '">Add Recommended</a></li> ';
    }*/else if (Yii::app()->controller->action->id == "update" ) {

        echo '<li><a href="index.php?r=SubscribedProduct/listallproduct&store_id=' . $store_id . '">product List</a></li> ';
    }
}

elseif (Yii::app()->controller->id == "lookbook" && (Yii::app()->controller->action->id == "Adminphoto" || Yii::app()->controller->action->id == "photogallarycreate" || Yii::app()->controller->action->id == "Photogallaryupdate")) {
    if (Yii::app()->controller->action->id == "photogallarycreate" ) {
        echo '<li><a href="index.php?r=lookbook/Adminphoto&store_id=' . $store_id . '">Photo Gallery List</a></li> ';
    } else if (Yii::app()->controller->action->id == "Photogallaryupdate"  ) {
        echo '<li><a href="index.php?r=lookbook/Adminphoto&store_id=' . $store_id . '">Photo Gallery List</a></li> ';
    } else if (Yii::app()->controller->action->id == "Adminphoto") {
        echo '<li><a href="index.php?r=lookbook/photogallarycreate&store_id=' . $store_id . '">Create Photo Gallery</a></li> ';
    }
} elseif (Yii::app()->controller->id == "storeFront") {

    if (Yii::app()->controller->action->id == "create" ) {

        echo '<li><a href="index.php?r=storeFront/admin&store_id=' . $store_id . '">Line sheet List</a></li> ';
    } else if (Yii::app()->controller->action->id == "admin" ) {

        echo '<li><a href="index.php?r=storeFront/create&store_id=' . $store_id . '">Create Line sheet</a></li> ';
    } else if (Yii::app()->controller->action->id == "update" ) {

        echo '<li><a href="index.php?r=storeFront/admin&store_id=' . $store_id . '">Line sheet List</a></li> ';
    } else if(substr_count(Yii::app()->session['premission_info']['module_info']['photogallery'], 'R') > 0){
        echo '<li><a href="index.php?r=storeFront/admin&store_id=' . $store_id . '">Line sheet List</a></li> ';
    }
} elseif (Yii::app()->controller->id == "pressRelease") {
    if (Yii::app()->controller->action->id == "create" ) {
        echo '<li><a href="index.php?r=pressRelease/admin&store_id=' . $store_id . '">Press Release List</a></li> ';
    } else if (Yii::app()->controller->action->id == "update") {
        echo '<li><a href="index.php?r=pressRelease/admin&store_id=' . $store_id . '">Press Release List</a></li> ';
    } else if (Yii::app()->controller->action->id == "admin" ) {
        echo '<li><a href="index.php?r=pressRelease/create&store_id=' . $store_id . '">Create Press Release</a></li> ';
    }
} elseif (Yii::app()->controller->id == "lookbook") {
    if (Yii::app()->controller->action->id == "create" ) {
        echo '<li><a href="index.php?r=lookbook/admin&store_id=' . $store_id . '">Lookbook List</a></li> ';
    } else if (Yii::app()->controller->action->id == "update" ) {
        echo '<li><a href="index.php?r=lookbook/admin&store_id=' . $store_id . '">Lookbook List</a></li> ';
    } else if (Yii::app()->controller->action->id == "admin" ) {
        echo '<li><a href="index.php?r=lookbook/create&store_id=' . $store_id . '">Create Lookbook</a></li> ';
    }
}
else{
    $this->widget('zii.widgets.CMenu', array(
        /* 'type'=>'list', */
        'encodeLabel' => false,
        'items' => $this->menu,
        /*array(
            $this->menu,
            array('label' => 'OPERATIONS', 'items' => $this->menu),
        )*/
    ));
}



?>