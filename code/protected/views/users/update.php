<?php
/* @var $this YmpdmUserController */
/* @var $model YmpdmUser */
$this->breadcrumbs=array(
	'Admin Users'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);
  /*if (!(strstr(Yii::app()->session['premission_info']['module_info']['Users'], 'U'))|| (Yii::app()->session['premission_info']['menu_info']['users_menu_info'] != "S")) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }*/

?>

<?php if(Yii::app()->user->hasFlash('error')): ?><div class="flash-error" style="color: red;"><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>
<?php if(Yii::app()->user->hasFlash('permissio_error')): ?><div class="flash-error" style="color: red;"><?php echo Yii::app()->user->getFlash('permissio_error'); ?></div><?php endif; ?>


<div class="" id="yw0">
<!--<ul class="tab_list">
    
   <?php //if(substr_count(Yii::app()->session['premission_info']['module_info']['Users'], 'R')>0) {?> <li><a href="index.php?r=users/admin">User List</a></li><?php //}?>
     <?php //if (substr_count(Yii::app()->session['premission_info']['module_info']['Users'], 'C')>0) {?><li><a href="index.php?r=users/create">Create User</a></li><?php //}?>
</ul>-->
<div class="portlet-content" style="padding:20px;">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
  
	</div>
</div>


