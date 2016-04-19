<?php
$data=array();
    $criteria = new CDbCriteria();
    $criteria->condition = "is_deleted = 0 AND level >= 2";
    $allCategoryData = Category::model()->findAll($criteria); 
    
    foreach ($allCategoryData as $_categoryData){
        if($_categoryData->level == 2){
            $data["1---$_categoryData->category_id"] = array(
                'parentid'=>'',
                'text'=>$_categoryData->category_name,
                'checked'=>($_categoryData->category_id == $category_id) ? "checked" : "" 
            );
        }else{
            $data[($_categoryData->level-1)."---$_categoryData->category_id"] = array(
                'parentid'=>($_categoryData->level-2)."---$_categoryData->parent_category_id",
                'text'=>$_categoryData->category_name,
                'checked'=>($_categoryData->category_id == $category_id) ? "checked" : ""
            );
        }
    }
    
    Yii::import("application.extensions.AIOTree.*");
    $this->Widget('AIOTree',array(
        //'model'=>$model,
        'attribute'=>'category_id',    
        'data'=>$data,
        'type'=>'radio',
        'header'=>'Category Tree', 
        'parentTag'=>'div',
        'parentId'=>'aiotree_id',
        'selectParent'=>true,
        'parentShow'=>false,
        'controlShow'=>true,       
        'controlTag'=>'div',
        //'controlClass'=>'CC',
        //'controlId'=>'CId',
        'controlStyle'=>'color:red',
        'controlDivider'=>' | ',
        'controlLabel'=>array('collapse'=>' collapse ','expand'=>' expand '),
        'controlHtmlOptions'=>array(
                            'id'=>'control_id',
                            'class'=>'control_class',
                            'style'=>'color:blue',
                            'style'=>'text-decoration:none',
                            ),
        'liHtmlOptions'=>array(
                       //    'class'=>'link-class',  
                       'onchange'=>'reloadCategory(this.value);',                          
            ), 
    ));
?>