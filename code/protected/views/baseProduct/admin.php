<?php
/* @var $this CategoryController */
/* @var $model Category */

//$issuperadmin = Yii::app()->session['is_super_admin'];
/*if ($issuperadmin == 1) {
    if (!(isset($_GET['store_id'])) || (empty($_GET['store_id']))) {
       // $this->redirect(array('site/logout'));
    }
    $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_admin_id'] != $store_id) {
        $this->redirect(array('site/logout'));
    }
    $store_name = Yii::app()->session['store_name'];
    $this->breadcrumbs = array(
        'Brand' => array('store/admin'),
        $store_name => array('store/update', "id" => $store_id),
        'Product' => array('admin', 'store_id' => $store_id),);
} else {
    $store_id = Yii::app()->session['brand_id'];

    if (Yii::app()->session['brand_id'] == '') {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }

    if (Yii::app()->session['brand_id'] != $store_id) {
        $this->redirect(array('site/logout'));
    }
    $this->breadcrumbs = array(
        'Linesheet' => array('admin', 'store_id' => $store_id),
        'Manage',);
}
*/

$store_id=1;
$store_name = Yii::app()->session['store_name'];
    $this->breadcrumbs = array(
      'Product' => array('admin', 'store_id' => $store_id),);

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
<!--    <input name="inactivebutton" class="activebutton" value="Inactive" type="submit">-->
    <!--<input name="pdfbutton" class="activebutton" value="Download PDF" type="submit">-->
  <!--  <a href="index.php?r=BaseProduct/report" class="button_new" target="_blank"  >Download PDF</a>-->

    <input name="downloadbutton" class="activebutton" value="Download CSV File" type="submit">

    <?php
   //print_r($model_grid);die;
    $this->widget('zii.widgets.grid.CGridView', array(
        'itemsCssClass' => 'table table-striped table-bordered table-hover',
        'dataProvider' => $model_grid->search(),
        'filter' => $model_grid,
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
                'name' => 'title',
                'type' => 'raw',
            ),
            
           array(
                'name' => 'quantity',
                'type' => 'raw',
            ),
            array(
                'header' => 'store price',
                'name' => 'store_price',
                'type' => 'raw',
            ),
            
            array(
                'header' => 'offer price',
                'name' => 'store_offer_price',
                'type' => 'raw',
            ),
            
            array(
                'name' => 'status',
                'type' => 'raw',
                 ),
             array(
                'name' => 'store',
                'type' => 'raw',
            ),
           
            'link' => array(
                'header' => 'Edit',
                'type' => 'raw',
                'value' => function ($data)use ($store_id) {
                    return CHtml::button("Edit", array("onclick" => "document.location.href='" . Yii::app()->controller->createUrl("baseProduct/update", array("id" => $data->base_product_id, 'store_id' => $store_id)) . "'"));
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
