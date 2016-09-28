<?php
/* @var $this LookbookController */
/* @var $model Lookbook */
$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 1) {
   
    if (!(isset($_GET['store_id']))||(empty($_GET['store_id']))) {
         Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
    $store_id = $_GET['store_id'];
    $store_name = Store::model()->getstore_nameByid($store_id);
    
     if (Yii::app()->session['brand_admin_id']!= $store_id) {
          Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
   
    $this->breadcrumbs = array(
        'Brand' => array('store/admin'),
         $store_name => array('store/update', "id" => $store_id),
        'lookbook' => array('lookbook/admin', "store_id" => $store_id),
        'Manage',
    );

} else {
    $store_id = Yii::app()->session['brand_id'];
    $this->breadcrumbs = array(
        'Lookbooks' => array('admin', "store_id" => $store_id),
        'Manage',
    );
}

#......Menu & Action Visibility.....#
$visible_dropdownmenu = true;
$visible_action_edit = true;
$visible_action_delete = true;
/*if (array_key_exists('lookbook', Yii::app()->session['premission_info']['module_info'])) {
    
    if (strstr(Yii::app()->session['premission_info']['module_info']['photogallery'], 'C')) {
        $visible_dropdownmenu = strstr(Yii::app()->session['premission_info']['module_info']['photogallery'], 'C');
    } else {
        $visible_dropdownmenu = FALSE;
    }


    if (strstr(Yii::app()->session['premission_info']['module_info']['photogallery'], 'D')) {
        $visible_action_delete = strstr(Yii::app()->session['premission_info']['module_info']['photogallery'], 'D');
    } else {
        $visible_action_delete = FALSE;
    }

    if (strstr(Yii::app()->session['premission_info']['module_info']['photogallery'], 'U')) {
        $visible_action_edit = strstr(Yii::app()->session['premission_info']['module_info']['photogallery'], 'U');
    } else {
        $visible_action_edit = FALSE;
    }
}*/
#.........End Visibility.....#

$this->menu = array(
   // array('label' => 'Create Lookbook', 'url' => array('create', "store_id" => $store_id), 'visible' => $visible_dropdownmenu),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#lookbook-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

 <div class="grid_contain">

    <?php if (Yii::app()->user->hasFlash('Delete')): ?><div class="delete"><?php echo Yii::app()->user->getFlash('Delete'); ?></div><?php endif; ?>
<?php 
 $dataprovider =  Lookbook::model()->findAllByAttributes(array('type'=>'photo','store_id'=>$store_id),array('order'=>'id DESC')); 
 $maxrecord= count($dataprovider);
 ?>
<?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-error" style="color: green;"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif;
if($visible_dropdownmenu){?>
<div class="add_new">
 <a href="index.php?r=lookbook/photogallarycreate&store_id=<?php echo $store_id;?>" title="Add New" type="button" class="imagehover"data-placement='bottom'>
       <i class="fa fa-plus"></i>
       <h5>Add New</h5>
 </a>
</div>
<?php } for($i=0;$i<$maxrecord;$i++){
?>
<div class="look_grid">
    <a title="<?php echo $dataprovider[$i]['desciption'];?>" type="button" class="imagehover" data-placement='bottom' <?php if($visible_action_edit){?> href="index.php?r=lookbook/Photogallaryupdate&id=<?php echo $dataprovider[$i]['id'];?>&store_id=<?php echo $store_id;?>"  <?php }?> >
    <div class="imagehover-wrap">
      <img src="<?php if(file_exists($dataprovider[$i]['image_main_url']))echo  $dataprovider[$i]['image_main_url'];else echo 'themes/abound/img/default.jpg'; ?>"  >
      </div>
    <h5><?php echo $dataprovider[$i]['headline'];?></h5>
  </a>  
</div>
<?php } ?>
 </div>
<script type="text/javascript">
$(function() {
    $('.imagehover').tooltip();
});
</script>
<style>
    .delete{
        color: #fff;
        padding: 10px;
        margin: 10px 20px;
        background-color: #468847;
        border-radius: 4px;
    }
</style>
