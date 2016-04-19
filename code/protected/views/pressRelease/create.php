<?php
/* @var $this PressReleaseController */
/* @var $model PressRelease */
$issuperadmin = Yii::app()->session['is_super_admin'];
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
        'Press Releases' => array('admin', "store_id" => $store_id),
        'Create',
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
        'Press Releases' => array('admin', "store_id" => $store_id),
        'Create',
    );
}


$this->menu = array(
//    array('label' => 'Manage PressRelease', 'url' => array('admin', "store_id" => $store_id)),
);
?>
<div class="" >
  
<div class="portlet-content">
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
</div>


