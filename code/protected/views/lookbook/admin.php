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
$visible_dropdownmenu = FALSE;
$visible_action_edit = FALSE;
$visible_action_delete = FALSE;
if (array_key_exists('lookbook', Yii::app()->session['premission_info']['module_info'])) {
    
    if (strstr(Yii::app()->session['premission_info']['module_info']['lookbook'], 'C')) {
        $visible_dropdownmenu = strstr(Yii::app()->session['premission_info']['module_info']['lookbook'], 'C');
    } else {
        $visible_dropdownmenu = FALSE;
    }


    if (strstr(Yii::app()->session['premission_info']['module_info']['lookbook'], 'D')) {
        $visible_action_delete = strstr(Yii::app()->session['premission_info']['module_info']['lookbook'], 'D');
    } else {
        $visible_action_delete = FALSE;
    }

    if (strstr(Yii::app()->session['premission_info']['module_info']['lookbook'], 'U')) {
        $visible_action_edit = strstr(Yii::app()->session['premission_info']['module_info']['lookbook'], 'U');
    } else {
        $visible_action_edit = FALSE;
    }
}
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
<?php if (Yii::app()->user->hasFlash('Delete')): ?><div class="delete"><?php echo Yii::app()->user->getFlash('Delete'); ?></div><?php endif; ?>
<form method="post" class="grid_form">
  <div class="top_searcstrip">
    <div class="top_searchbox">
    <input type="text" name="searchtext" placeholder="Search Here" value=""/>
    <input type="submit" name="searchsubmit" value="Search"/>
   </div> 
   </div>
    <div class="grid_contain">
<?php 
if($search<>''){
     $dataprovider =  Lookbook::model()->getSearchByTitle($search,$store_id); 
 $maxrecord= count($dataprovider);
 }else{
 $dataprovider =  Lookbook::model()->findAllByAttributes(array('type'=>'lookbook','store_id'=>$store_id),array('order'=>'id DESC')); 
 $maxrecord= count($dataprovider);
 }
 if($visible_dropdownmenu){?>
<div class="add_new">
 <a href="index.php?r=lookbook/create&store_id=<?php echo $store_id;?>" title="Add New" type="button" class="imagehover"data-placement='bottom'>
       <i class="fa fa-plus"></i>
       <h5>Add New<h5>
 </a>
</div>
 <?php }
 
 for($i=0;$i<$maxrecord;$i++){?>
<div class="look_grid" style="cursor: initial;">
   <a  title="<?php echo $dataprovider[$i]['desciption'];?>" class="imagehover" data-placement='bottom' <?php if($dataprovider[$i]['pdf_url']){ echo 'download'.' '.'href="'.$dataprovider[$i]['pdf_url'].'"';}?>> 
     <?php if($visible_action_edit){?> 
       <a href="index.php?r=lookbook/update&id=<?php echo $dataprovider[$i]['id'];?>&store_id=<?php echo $store_id;?>" >
     <?php }?>
          <div class="imagehover-wrap">
         <img src="<?php if(file_exists($dataprovider[$i]['image_main_url']))echo  $dataprovider[$i]['image_main_url'];else echo 'themes/abound/img/default.jpg'; ?>"  >
          </div>
     <?php if($visible_action_edit){ echo '</a>';}?>
    <h5 style="cursor: initial;"><?php echo $dataprovider[$i]['headline'];?></h5>
   </a>
</div>
   
<?php } ?>
         </div>
</form>
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
