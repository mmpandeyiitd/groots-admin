<?php
/* @var $this LookbookController */
/* @var $model Lookbook */
$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 1) {
    
    if (!(isset($_GET['store_id'])) || (empty($_GET['store_id']))) {
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
         'Photo Gallery' => array('Adminphoto', "store_id" => $store_id),
          $model->headline => array('photogallaryupdate', 'id' => $model->id, "store_id" => $store_id), 'Update',
    );
     
} else {
    if (!(isset($_GET['store_id']))||(empty($_GET['store_id']))) {
         Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
     $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_id'] != $store_id) {
        $this->redirect(array('site/logout'));
    }
  $this->breadcrumbs = array(
        'Photo Gallery' => array('Adminphoto', "store_id" => $store_id),
        $model->headline => array('photogallaryupdate', 'id' => $model->id, "store_id" => $store_id), 'Update',);

}

$this->menu = array(
//    array('label' => 'add photo gallery', 'url' => array('photogallarycreate', "store_id" => $store_id)),
//    array('label' => 'Manage photo gallery', 'url' => array('Adminphoto', "store_id" => $store_id)),
);
?>
<div class="" >

<div class="portlet-content" style="padding-left:25px;">
  <?php $this->renderPartial('photogupdate', array('model' => $model)); ?>
</div>
</div>



