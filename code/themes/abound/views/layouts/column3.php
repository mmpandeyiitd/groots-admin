<?php 
#   ......show action ......#
//print_r($_REQUEST);die;
if(Yii::app()->controller->id=="store"){
    
    if(Yii::app()->controller->action->id=="create"){
        echo "create Store";
    }elseif(Yii::app()->controller->action->id=="update"){
        if(Yii::app()->session['is_super_admin']==1){
        echo "REGISTERED OFFICE";
        }else{
            // echo "Edit Profile";
        }
    }
    elseif(Yii::app()->controller->action->id=="admin"){
        
        echo "REGISTERED OFFICE";
    } elseif(Yii::app()->controller->action->id=="brandprofile"){
        
        echo "My Profle";
    }    
    
}else if(Yii::app()->controller->id=="baseProduct"){
     if(Yii::app()->controller->action->id=="create"){
        echo "create product";
    }elseif(Yii::app()->controller->action->id=="Update"){
        
        echo "Edit product"; 
    }
    elseif(Yii::app()->controller->action->id=="update"){
        
        echo "Edit product"; 
    }
    elseif(Yii::app()->controller->action->id=="admin"){
        
       echo "product List"; 
    }elseif(Yii::app()->controller->action->id=="bulkupload"){
        
       echo "Bulkupload  product";
    }  elseif(Yii::app()->controller->action->id=="media"){
        
       echo "Upload product Images";
    }  elseif(Yii::app()->controller->action->id=="configurablegrid"){
        
       echo "Recommended  product";
    }  elseif(Yii::app()->controller->action->id=="addedstyle"){
        
       echo "Added product In Recommended";
    } elseif(Yii::app()->controller->action->id=="configurable_group"){
        
       echo "Add product In Recommended";
    }    
     
}else if($_REQUEST['r']=='SubscribedProduct/listallproduct'){
    
    if(Yii::app()->controller->action->id=="listallproduct"){
        
       echo "product List"; 
    }    
     
}else if($_REQUEST['r']=='subscribedProduct/mappedProduct'){
    
    if(Yii::app()->controller->action->id=="mappedProduct"){
        
       echo "MAP PRODUCTS"; 
    }    
     
}
else if($_REQUEST['r']=='SubscribedProduct/admin'){
    
    if(Yii::app()->controller->action->id=="admin"){
        
       echo "MAP PRODUCTS"; 
    }    
     
}
else if(Yii::app()->controller->id=="storeFront"){
     if(Yii::app()->controller->action->id=="create"){
        echo "Creat Line Sheet";
    }elseif(Yii::app()->controller->action->id=="update"){
        
        echo "Edit Line Sheet"; 
    }
    elseif(Yii::app()->controller->action->id=="admin"){        
       echo "Line Sheet List"; 
    }
    elseif(Yii::app()->controller->action->id=="addedStyleInLinesheet"){        
       echo "Added Styles In Linesheet"; 
    } elseif(Yii::app()->controller->action->id=="StyleAddInLinesheet"){        
       echo "Add Styles In Linesheet"; 
    }
}else if(Yii::app()->controller->id=="retailerProductQuotation"){
     if(Yii::app()->controller->action->id=="create"){
        echo "Creat Buyers Product";
    }elseif(Yii::app()->controller->action->id=="update"){
        
        echo "Edit Buyers Product"; 
    }
    elseif(Yii::app()->controller->action->id=="admin"){        
       echo "Line Buyers Product"; 
    }
   
}else if(Yii::app()->controller->id=="pressRelease"){
    if(Yii::app()->controller->action->id=="create"){
        echo "Creat Press Release";
    }elseif(Yii::app()->controller->action->id=="update"){
        
        echo "Edit Press Release"; 
    }
    elseif(Yii::app()->controller->action->id=="admin"){        
       echo "Press Release List"; 
    }
}else if(Yii::app()->controller->id=="dashboardPage"){
      echo "Dashboard Page";
}else if(Yii::app()->controller->id=="lookbook"){
     if(Yii::app()->controller->action->id=="create"){
        echo "Creat Lookbook";
    }elseif(Yii::app()->controller->action->id=="update"){
        
        echo "Edit Lookbook"; 
    }
    elseif(Yii::app()->controller->action->id=="admin"){        
       echo "Lookbook List"; 
    }elseif(Yii::app()->controller->action->id=="Adminphoto"){        
       echo "Photo Gallery List"; 
    }elseif(Yii::app()->controller->action->id=="photogallarycreate"){        
       echo "Create Photo Gallery"; 
    }elseif(Yii::app()->controller->action->id=="Photogallaryupdate"){        
       echo "Edit Photo Gallery"; 
    }
    
}elseif(Yii::app()->controller->id=="orderHeader"){

    if(Yii::app()->controller->action->id=="admin"){
        echo "Order List";
    } elseif(Yii::app()->controller->action->id=="update"){
        echo "Order Detail";
    }
}elseif(Yii::app()->controller->id=="category"){

    if(Yii::app()->controller->action->id=="index"){
        echo "Category List";
    } elseif(Yii::app()->controller->action->id=="create"){
        echo "Create Category";
    }else{
        echo Yii::app()->controller->action->id." ".Yii::app()->controller->id;
    }
    
}elseif(Yii::app()->controller->id=="retailer"){
  if(Yii::app()->controller->action->id=="admin"){
        echo "Buyers List";
    }elseif(Yii::app()->controller->action->id=="create"){
        echo "create Buyer";
    }
    elseif(Yii::app()->controller->action->id=="update"){
        echo "Edit Buyers";
    }else{
        echo Yii::app()->controller->action->id." ".Yii::app()->controller->id;
    }
}elseif(Yii::app()->controller->id=="retailerRequest"){
    if(Yii::app()->controller->action->id=="admin"){
        echo "Buyers Request List";
    }else{
        echo Yii::app()->controller->action->id." ".Yii::app()->controller->id;
    }
}elseif(Yii::app()->controller->id=="users"){
    if(Yii::app()->controller->action->id=="admin"){
        echo "Admin User List";
    }elseif(Yii::app()->controller->action->id=="update"){
        echo "Edit Admin User";
    }
}
elseif(Yii::app()->controller->id=="grootsledger")
{
    echo "GROOTS LEDGER";
}
else{

    
    echo Yii::app()->controller->action->id." ".Yii::app()->controller->id;
}

//if(Yii::app()->controller->action->id=="Photogallaryupdate"){ 
//    echo 'Update ';
//}else if(Yii::app()->controller->action->id=="photogallarycreate"){
//    echo 'Create ';
//}else if((Yii::app()->controller->action->id=="admin")||(Yii::app()->controller->action->id)=="Adminphoto"||(Yii::app()->controller->action->id=="index")){
//  //  echo 'Create ';
//} else if(Yii::app()->controller->action->id=="StyleAddInLinesheet"){
//    echo 'Add Styles In ';
//}  elseif(Yii::app()->controller->action->id=="addedStyleInLinesheet"){
//    echo 'Added Styles In ';
//}elseif(Yii::app()->controller->action->id=="configurable_group"){
//      echo 'Add Recommended';  
//}elseif(Yii::app()->controller->action->id=="configurablegrid"){
//      echo 'Add Recommended';  
//}else{
//     echo Yii::app()->controller->action->id.' ';  
//}
//
//#.... show controller....# 
//
//if(((Yii::app()->controller->action->id)=="Adminphoto")||(Yii::app()->controller->action->id=="photogallarycreate")||(Yii::app()->controller->action->id=="Photogallaryupdate")){
//echo 'Photo gallery List';
//}else if(Yii::app()->controller->id=="store"){
//    if(Yii::app()->session['is_super_admin'] != 1){
//       echo 'Brand Profile( ' . Yii::app()->session['brand_id'].' )';
//    }else{
//         echo 'Brand List '; 
//    }
//}else if(Yii::app()->controller->id=="baseProduct"){
//    echo 'Style List';
//}else if(Yii::app()->controller->id=="storeFront"){
//    echo 'Line Sheet List';
//}else if(Yii::app()->controller->id=="dashboardPage"){
//    echo 'Dashboard Page';
//  
//}else if(Yii::app()->controller->id=="pressRelease"){
//    echo 'Press Release List';
//  
//}else{
//     echo Yii::app()->controller->id.'  List';
//}
?>