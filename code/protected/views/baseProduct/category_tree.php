<?php
$data=array();
$criteria = new CDbCriteria();
$criteria->condition = "is_deleted = 0 AND level >= 2";
$allCategoryData = Category::model()->findAll($criteria);
$pdtCategories = array();
$cat_all = array();
$pdtCategories11 = array();
if (isset($_POST['aiotree']['category_id'])) {
    $category = $_POST['aiotree']['category_id'];
    foreach ($category as $categores_key => $cat_val) {
        $a = explode('---', $cat_val);
        $cat_all[] = $a[1];
    }
}
if ($model->base_product_id) {
    $pdtCategories = Category::model()->getCategoryMappingByProduId($model->base_product_id);
} else {
    $pdtCategories = $cat_all;
}
 /*  if(count($pdtCategories)==0){
   $category_obl=new Category();
   $category_id = $category_obl->getDefaultCategoryId();
   if(!empty($category_id))
   array_push($pdtCategories, $category_id);
}*/

foreach ($allCategoryData as $_categoryData) {
    if ($_categoryData->level == 2) {
        $data["1---$_categoryData->category_id"] = array(
            'parentid' => '',
            'text' => $_categoryData->category_name,
            'checked' => in_array($_categoryData->category_id, $pdtCategories),
        );
    } else {
      $data[($_categoryData->level - 1) . "---$_categoryData->category_id"] = array(
            'parentid' => ($_categoryData->level - 2) . "---$_categoryData->parent_category_id",
            'text' => $_categoryData->category_name,
            'checked' => in_array($_categoryData->category_id, $pdtCategories),
        );
    }

}

Yii::import("application.extensions.AIOTree.*");
$this->Widget('AIOTree', array(
    //'model'=>$model,
    'attribute' => 'category_id',
    'data' => $data,
    'type' => 'radio',
    'header' => 'Map Product To Category',
    'parentTag' => 'div',
    'parentId' => 'aiotree_id',
    'selectParent' => true,
    'parentShow' => false,
    'controlShow' => true,
    'controlTag' => 'div',
    //'controlClass'=>'CC',
    //'controlId'=>'CId',
    'controlStyle' => 'color:red',
    'controlDivider' => ' | ',
    'controlLabel' => array('collapse' => ' collapse ', 'expand' => ' expand '),
    'controlHtmlOptions' => array(
        'id' => 'control_id',
        'class' => 'control_class',
        'style' => 'color:blue',
        'style' => 'text-decoration:none',
    ),
    'liHtmlOptions' => array(
    //    'class'=>'link-class',  
    //'onclick'=>'alert(this.value);',                          
    ),
));
?>