<?php
$store_id = 1;
$store_name = Yii::app()->session['store_name'];
$this->breadcrumbs = array(
    'Product' => array('listallproduct', 'store_id' => $store_id),);

#......Menu & Action Visibility.....#
$visible_dropdownmenu = FALSE;
$visible_action_edit = FALSE;
$visible_action_delete = FALSE;
if (array_key_exists('baseproduct', Yii::app()->session['premission_info']['module_info'])) {
    if (strstr(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C')) {
        $visible_dropdownmenu = strstr(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C');
    } else {
        $visible_dropdownmenu = FALSE;
    }
    if (strstr(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'U')) {
        //echo "hello";die;
        $visible_action_edit = strstr(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'U');
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
    <?php if (Yii::app()->user->hasFlash('premission_info')): ?><div class="errorSummary" style="color: green;"><?php echo Yii::app()->user->getFlash('premission_info'); ?></div><?php endif; ?>
    <?php if (Yii::app()->user->hasFlash('Delete')): ?><div class="delete"><?php echo Yii::app()->user->getFlash('Delete'); ?></div><?php endif; ?>
    <?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-error" style="color: green;"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>
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

    <input name="downloadbutton" class="activebutton" value="Download CSV File" type="submit">
    <!--<input name="inactivebutton" class="activebutton" value="Download ALL Product" type="submit">-->
    <?php
    $store_id = 1;
//print_r($model_grid);die;
    $this->widget('zii.widgets.grid.CGridView', array(
        'itemsCssClass' => 'table table-striped table-bordered table-hover',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
            array(
                'header' => 'check',
                'name' => 'selectedIds[]',
                'id' => 'selectedIds',
                'value' => '$data->base_product_id',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => '100',
            ),
//        array(
//            'name' => 'store_front_id',
//            'type' => 'raw',
//        ),
            array(
                // 'header'=>'Title',
                'name' => 'title',
                'type' => 'raw',
                'value' => '$data->BaseProduct->title',
                'headerHtmlOptions' => array('style' => 'color:#1d2e7b;'),
            ),
            array(
                'header' => 'Store price',
                'name' => 'store_price',
                'type' => 'raw',
            ),
            array(
                'header' => 'Offer price',
                'name' => 'store_offer_price',
                'type' => 'raw',
            ),
            array(
                'header' => 'Status',
                'name' => 'status',
                'filter' => array('1' => 'Enable', '0' => 'Disable'),
                // 'filter' => CHtml::activeTextField($model, 'status'),
                //'type' => 'raw',
                'value' => '($data->status == "1")?"Enable":"Disable"',
            ),
            /*  array(
              'name'=>'status',
              'type'=>'raw',
              'value' => '($data->status == "1")?"Enable":"Disable"',
              ), */
            'link' => array(
                'header' => 'Edit',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'color:#1d2e7b;'),
                'htmlOptions' => array('style' => 'text-align: center;'),
                'value' => function ($data)use ($store_id) {
                    return CHtml::button("Edit", array("onclick" => "document.location.href='" . Yii::app()->controller->createUrl("baseProduct/Update", array("id" => $data->base_product_id, 'store_id' => $store_id)) . "'"));
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
