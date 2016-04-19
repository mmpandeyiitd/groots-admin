<?php
/* @var $this StoreController */
/* @var $model Store */
if(Yii::app()->session['is_super_admin']){
Yii::app()->session['brand_admin_id'] = $model->store_id;
if(isset(Yii::app()->session['brand_admin_id'])) {
    $store_name = Store::model()->getstore_nameByid(Yii::app()->session['brand_admin_id']);
   Yii::app()->session['store_name']= $store_name;
}
}else{
     $store_name = Store::model()->getstore_nameByid(Yii::app()->session['brand_id']);
   Yii::app()->session['store_name']= $store_name;
}
$this->breadcrumbs = array(
    'Store' => array('admin'),
    $model->store_name => array('update', 'id' => $model->store_id),
    'Update',
);
?>
<div class="" id="yw0">

    <div class="brand_new">
        <?php $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>

