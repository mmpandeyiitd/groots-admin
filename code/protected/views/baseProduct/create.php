<?php
/* @var $this BaseProductController */
/* @var $model BaseProduct */
$issuperadmin = Yii::app()->session['is_super_admin'];
/*if ($issuperadmin == 1) {
    
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
    'Create',
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
    'Style' => array('admin', "store_id" => $store_id),
    'Create');
}
*/
?>

<div class="" >
  
<div class="portlet-content">
    <?php if(!empty($mrp)){    }else{  $mrp='';}
    if(!empty($wsp)){    }else{  $wsp=''; }
     if(!empty($cat_all)){    }else{  $cat_all=''; }
      if(!empty($specific_keyfield)){    }else{  $specific_keyfield=''; }
    
    $this->renderPartial('_form', array('model' => $model,'mrp'=>$mrp,'wsp'=>$wsp, 'cat_all' => $cat_all, 'specific_keyfield' => $specific_keyfield,'grade' => $grade,'diameter' => $diameter,'qunt' => $qunt,)); ?>
</div>
</div>








