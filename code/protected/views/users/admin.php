<?php
/* @var $this YmpdmUserController */
/* @var $model YmpdmUser */

$this->breadcrumbs = array(
    'Admin Users' => array('admin'),
    'Manage',
);

#......Menu & Action Visibility.....#
$visible_dropdownmenu = FALSE;
$visible_action_edit = FALSE;
$visible_action_delete = FALSE;
if(array_key_exists('Users',Yii::app()->session['premission_info']['module_info'])){
if (strstr(Yii::app()->session['premission_info']['module_info']['Users'], 'C')) {
    $visible_dropdownmenu = strstr(Yii::app()->session['premission_info']['module_info']['Users'], 'C');
} else {
    $visible_dropdownmenu = FALSE;
}
if (strstr(Yii::app()->session['premission_info']['module_info']['Users'], 'D')) {
    $visible_action_delete = strstr(Yii::app()->session['premission_info']['module_info']['Users'], 'D');
} else {
    $visible_action_delete = FALSE;
}
if (strstr(Yii::app()->session['premission_info']['module_info']['Users'], 'U')) {
    $visible_action_edit = strstr(Yii::app()->session['premission_info']['module_info']['Users'], 'U');
} else {
    $visible_action_edit = FALSE;
}
}
#.........End Visibility.....#
$this->menu = array(
    //array('label' => 'Create Admin User', 'url' => array('create'), 'visible' => $visible_dropdownmenu),
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
    });
    $('.search-form form').submit(function(){
    $('#ympdm-user-grid').yiiGridView('update', {
    data: $(this).serialize()
    });
    return false;
    });
    ");
?>
<?php
if (Yii::app()->user->hasFlash('error')): ?><div class="flash-error" style="color: red;"><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>
<div class="search-form" style="display:none">
    
</div>
<!-- search-form -->

<?php
//echo Yii::app()->basePath;
$this->widget('zii.widgets.grid.CGridView', array(
    'itemsCssClass' => 'table table-striped table-bordered table-hover',
    'id' => 'ympdm-user-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
       // 'id',
         array(
            'name' => 'name',
            'value' => '($data->name == "")?"N/A":$data->name'
        ),
         'email',
       // 'user_name',
        'user_type',
       
        'created_at',
        'link' => array(
            'header' => 'Action',
            'type' => 'raw',
            'value' => 'CHtml::button("Edit",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("Users/update",array("id"=>$data->id))."\'"))',
            'visible' => $visible_action_edit
        ),
//        'link1' => array(
//            'header' => '',
//            'type' => 'raw',
//            'value' => 'CHtml::button("Delete",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("Users/delete",array("id"=>$data->id))."\'"))',
//            'visible' => $visible_action_delete
//        ),
    ),
));
?>
