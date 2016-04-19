<?php
/* @var $this StoreController */
/* @var $model Store */
$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 1) {
    
     if (!(isset($_GET['store_id']))||(empty($_GET['store_id'])))
      {
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
        'Linesheet' => array('admin', 'store_id' => $store_id),
        $model->store_front_name => array('update', 'id' => $model->store_front_id, "store_id" => $store_id),
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
        'Linesheet' => array('admin', "store_id" => $store_id),
        $model->store_front_name => array('update', 'id' => $model->store_front_id, "store_id" => $store_id),
        'Update',
    );
}
?>
<div class="" id="yw0">
<!--<div class="">-->
<!-- <div class="portlet-title"> Update Linesheet <?php echo $model->store_front_name;?></div>
</div> -->
<div class="portlet-content">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>


