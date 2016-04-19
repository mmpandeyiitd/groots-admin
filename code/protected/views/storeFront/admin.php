<?php
/* @var $this CategoryController */
/* @var $model Category */
$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 1) {
    if (!(isset($_GET['store_id'])) || (empty($_GET['store_id']))) {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong.');
        $this->redirect(array('DashboardPage/index'));
    }
    $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_admin_id'] != $store_id) {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong.');
        $this->redirect(array('DashboardPage/index'));
    }
    $store_name = Store::model()->getstore_nameByid($store_id);
    $this->breadcrumbs = array(
        'Brand' => array('store/admin'),
        $store_name => array('store/update', "id" => $store_id),
        'Linesheet' => array('admin', 'store_id' => $store_id),
        'Manage',
    );
} else {
    $store_id = Yii::app()->session['brand_id'];
    $this->breadcrumbs = array(
        'Linesheet' => array('admin', 'store_id' => $store_id),
        'Manage',
    );
}



#......Menu & Action Visibility.....#
$visible_dropdownmenu = FALSE;
$visible_action_edit = FALSE;
$visible_action_delete = FALSE;
if (array_key_exists('linesheet', Yii::app()->session['premission_info']['module_info'])) {
    if (strstr(Yii::app()->session['premission_info']['module_info']['linesheet'], 'C')) {
        $visible_dropdownmenu = strstr(Yii::app()->session['premission_info']['module_info']['linesheet'], 'C');
    } else {
        $visible_dropdownmenu = FALSE;
    }
    if (strstr(Yii::app()->session['premission_info']['module_info']['linesheet'], 'D')) {
        $visible_action_delete = strstr(Yii::app()->session['premission_info']['module_info']['linesheet'], 'D');
    } else {
        $visible_action_delete = FALSE;
    }
    if (strstr(Yii::app()->session['premission_info']['module_info']['linesheet'], 'U')) {
        $visible_action_edit = strstr(Yii::app()->session['premission_info']['module_info']['linesheet'], 'U');
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
    $('#category-grid').yiiGridView('update', {
    data: $(this).serialize()
    });
    return false;
    });
    ");
?>

<div class="form" style="overflow:hidden;">
    <?php if (Yii::app()->user->hasFlash('premission_info')): ?><div class="errorSummary"><?php echo Yii::app()->user->getFlash('premission_info'); ?></div><?php endif; ?>
    <?php if (Yii::app()->user->hasFlash('Delete')): ?><div class="delete"><?php echo Yii::app()->user->getFlash('Delete'); ?></div><?php endif; ?>

    <?php
    $form = $this->beginWidget(
            'CActiveForm', array(
        'id' => 'upload-form',
        'focus' => '.error:first',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
            )
    );
    ?>
    <input name="inactivebutton" class="activebutton" value="Inactive" type="submit">
    <input name="activebutton" class="activebutton" value="Active" type="submit">
    <input name="downloadbutton" class="activebutton" value="Download CSV File" type="submit">

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'itemsCssClass' => 'table table-striped table-bordered table-hover',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
            array(
                'header' => 'check',
                'name' => 'selectedIds[]',
                'id' => 'selectedIds',
                'value' => '$data->store_front_id',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => '100',
            ),

            array(
                'name' => 'store_front_name',
                'type' => 'raw',
            ),
            array(
                'name' => 'season',
                'type' => 'raw',
                'value' => '($data->season == "")?"N/A":$data->season'
            ),
            array(
                'name' => 'start_date',
                'type' => 'raw',
                'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array('model' => $model,
                    'attribute' => 'start_date',
                    'htmlOptions' => array('id' => 'start_date'), 'options' => array('dateFormat' => 'dd/mm/yy')), true)
            ),
            array(
                'name' => 'end_date',
                'type' => 'raw',
                'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array('model' => $model,
                    'attribute' => 'end_date',
                    'htmlOptions' => array('id' => 'end_date'), 'options' => array('dateFormat' => 'dd/mm/yy')), true)
            ),
            array(
                'name' => 'status',
                'type' => 'raw',
                'filter' => array('' => 'Select', '1' => 'Enable', '0' => 'Disable'),
                'value' => '($data->status == "1")?"Enable":"Disable"',
                'htmlOptions' => array('width' => 90),
            ),
            'link' => array(
                'header' => 'Edit',
                'type' => 'raw',
                'value' => function ($data)use ($store_id) {
                    return CHtml::button("Edit", array("onclick" => "document.location.href='" . Yii::app()->controller->createUrl("storeFront/update", array("id" => $data->store_front_id, 'store_id' => $store_id)) . "'"));
                },
                        'visible' => $visible_action_edit
                    ),
                    'link1' => array(
                        'header' => 'Delete',
                        'type' => 'raw',
                        'value' => function ($data)use ($store_id) {
                            return CHtml::button("Delete", array("onclick" => "document.location.href='" . Yii::app()->controller->createUrl("storeFront/delete", array("id" => $data->store_front_id, 'store_id' => $store_id)) . "'", 'confirm' => 'Are you sure you wish to Delete this message?', 'title' => 'Delete'));
                        },
                                'visible' => $visible_action_delete,
                                'htmlOptions' => array(
                                    'confirm' => 'Are you sure you want to Delete?',
                                )
                            ),
                            'link2' => array(
                                'header' => 'Added Styles',
                                'type' => 'raw',
                                'value' => function ($data)use ($store_id) {
                                    return CHtml::button("Configure", array("onclick" => "document.location.href='" . Yii::app()->controller->createUrl("storeFront/addedStyleInLinesheet", array("id" => $data->store_front_id, 'store_id' => $store_id)) . "'"));
                                },
                                        'visible' => $visible_action_edit
                                    ),
                                    'link3' => array(
                                        'header' => 'Download Styles',
                                        'type' => 'raw',
                                        'value' => function ($data)use ($store_id) {
                                            return CHtml::button("Download", array("onclick" => "document.location.href='" . Yii::app()->controller->createUrl("storeFront/export", array("id" => $data->store_front_id,)) . "'"));
                                        },
                                                'visible' => $visible_action_edit
                                            ),
                                        ),
                                    ));

                                    $this->endWidget();
                                    ?>

    <style>
        .delete{
            color: #fff;
            padding: 10px;
            margin: 10px 20px;
            background-color: #468847;
            border-radius: 4px;
        }
    </style>