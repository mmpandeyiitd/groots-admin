<?php
/* @var $this BaseProductController */
/* @var $model BaseProduct */
/*$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 1) {
    
    if (!(isset($_GET['store_id']))||(empty($_GET['store_id']))) {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
    $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_admin_id'] != $store_id) {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
    $store_name = Store::model()->getstore_nameByid($store_id);
    $this->breadcrumbs = array(
        'Brand' => array('store/admin'),
        $store_name => array('store/update', "id" => $store_id),
        'Product' => array('admin', "store_id" => $store_id),
        $model->title => array('update', 'id' => $model->base_product_id, "store_id" => $store_id),
        'Update',
    );
} else {
    if (!(isset($_GET['store_id']))||(empty($_GET['store_id']))) {
         Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
    $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_id'] != $store_id) {
         Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
    $this->breadcrumbs = array(
        'Styles' => array('admin', "store_id" => $store_id),
        $model->title => array('update', 'id' => $model->base_product_id, "store_id" => $store_id),
        'Update',
    );
}*/
$store_id=1;


$this->menu = array(//    array('label' => 'Manage Styles', 'url' => array('admin', "store_id" => $store_id)),
);
?>


<?php if (Yii::app()->user->hasFlash('error')): ?><div class="flash-error" style="color: red;"><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>


<div class="" id="yw0">
<!--  <ul class="tab_list" >
    <li><a href="index.php?r=baseProduct/admin&store_id=<?php echo $store_id;?>" >Style List</a></li>
    <li><a href="index.php?r=baseProduct/bulkupload&store_id=<?php echo $store_id;?>">Bulk Upload Style</a></li>
    <li><a href="index.php?r=baseProduct/media&store_id=<?php echo $store_id;?>">Bulk Upload Media</a></li>
    <li><a href="index.php?r=baseProduct/configurablegrid&store_id=<?php echo $store_id;?>">Add Recommended</a></li>
</ul>-->
<div class="portlet-content">
  <?php $this->renderPartial('form', array('model' => $model, 'record' => $record, 'imageinfo' => $imageinfo,'a'=>$a,'new_data'=>$new_data,'qunt'=>$qunt,'Weight' => $Weight,'WeightUnit' => $WeightUnit,'Length' => $Length,'LengthUnit' => $LengthUnit,)); ?>
    </div>
</div>



