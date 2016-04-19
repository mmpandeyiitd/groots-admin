<?php
/* @var $this PressReleaseController */
/* @var $model PressRelease */
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
        'Press Releases' => array('admin', "store_id" => $store_id),
        'Manage',
    );
} else {
    $store_id = Yii::app()->session['brand_id'];
    $this->breadcrumbs = array(
        'Press Releases' => array('admin', "store_id" => $store_id),
        'Manage',
    );
}


#......Menu & Action Visibility.....#
$visible_dropdownmenu = FALSE;
$visible_action_edit = FALSE;
$visible_action_delete = FALSE;
if (array_key_exists('pressrelease', Yii::app()->session['premission_info']['module_info'])) {
    if (strstr(Yii::app()->session['premission_info']['module_info']['pressrelease'], 'C')) {
        $visible_dropdownmenu = strstr(Yii::app()->session['premission_info']['module_info']['pressrelease'], 'C');
    } else {
        $visible_dropdownmenu = FALSE;
    }
    if (strstr(Yii::app()->session['premission_info']['module_info']['pressrelease'], 'D')) {
        $visible_action_delete = strstr(Yii::app()->session['premission_info']['module_info']['pressrelease'], 'D');
    } else {
        $visible_action_delete = FALSE;
    }
    if (strstr(Yii::app()->session['premission_info']['module_info']['pressrelease'], 'U')) {
        $visible_action_edit = strstr(Yii::app()->session['premission_info']['module_info']['pressrelease'], 'U');
    } else {
        $visible_action_edit = FALSE;
    }
}
#.........End Visibility.....#

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#press-release-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php if (Yii::app()->user->hasFlash('Delete')): ?><div class="delete"><?php echo Yii::app()->user->getFlash('Delete'); ?></div><?php endif; ?>
<?php if (Yii::app()->user->hasFlash('permission_error')): ?><div class="delete"><?php echo Yii::app()->user->getFlash('permission_error'); ?></div><?php endif; ?>
<?php
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

$dataprovider = PressRelease::model()->findAllByAttributes(array('brand_id' => $store_id), array('order' => 'id DESC'));
$maxrecord = count($dataprovider);
?>
 <div class="grid_contain">
<?php if (Yii::app()->user->hasFlash('success')): ?><div style="color: green;"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php
endif;
if ($visible_dropdownmenu) {
    ?>
    <div class="add_new">
        <a href="index.php?r=pressRelease/create&store_id=<?php echo $store_id; ?>" title="Add New" type="button" class="imagehover"data-placement='bottom'>
            <i class="fa fa-plus"></i>
            <h5>Add New</h5>
        </a>
    </div>
    <?php
}
for ($i = 0; $i < $maxrecord; $i++) {?>
    <div class="look_grid">
        <a title="<?php echo $dataprovider[$i]['description']; ?>" type="button" class="imagehover" data-placement='bottom' <?php if ($visible_action_edit) { ?>href="index.php?r=pressRelease/update&id=<?php echo $dataprovider[$i]['id'] . '&store_id=' . $store_id;
    } ?>"> 
            <div class="imagehover-wrap">
                <img src="<?php if (file_exists($dataprovider[$i]['image_thumb_url']))
        echo str_replace("thumbnails", "main", $dataprovider[$i]['image_thumb_url']);
    else
        echo 'themes/abound/img/default.jpg';
    ?>"  >
            </div>
            <h5><?php echo $dataprovider[$i]['title']; ?></h5>
        </a>
    </div>
<?php } ?>
 </div>
<script type="text/javascript">
    $(function () {
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

