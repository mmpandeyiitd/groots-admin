<?php 
#   ......show action ......#

if(Yii::app()->controller->id=="store"){
    
    if(Yii::app()->controller->action->id=="create"){
        echo "Creat Store";
    }elseif(Yii::app()->controller->action->id=="update"){
        if(Yii::app()->session['is_super_admin']==1){
        echo "Edit Store";
        }else{
             echo "Edit Profile";
        }
    }
    elseif(Yii::app()->controller->action->id=="admin"){
        
        echo "Store List";
    } elseif(Yii::app()->controller->action->id=="brandprofile"){
        
        echo "My Profle";
    }    
    
}else if(Yii::app()->controller->id=="baseProduct"){
     if(Yii::app()->controller->action->id=="create"){
        echo "Creat product";
    }elseif(Yii::app()->controller->action->id=="update"){
        
        echo "Edit  product"; 
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
     
}else if(Yii::app()->controller->id=="storeFront"){
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
        echo "Creat Retailer Product";
    }elseif(Yii::app()->controller->action->id=="update"){
        
        echo "Edit Retailer Product"; 
    }
    elseif(Yii::app()->controller->action->id=="admin"){        
       echo "Line Retailer Product"; 
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
      echo "Dasboard Page";
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
        echo "Retailer List";
    }elseif(Yii::app()->controller->action->id=="create"){
        echo "create Retailer";
    }
    elseif(Yii::app()->controller->action->id=="update"){
        echo "Edit Retailer";
    }else{
        echo Yii::app()->controller->action->id." ".Yii::app()->controller->id;
    }
}elseif(Yii::app()->controller->id=="retailerRequest"){
    if(Yii::app()->controller->action->id=="admin"){
        echo "Retailer Request List";
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