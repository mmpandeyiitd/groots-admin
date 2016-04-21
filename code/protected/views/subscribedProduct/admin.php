<?php
#......Menu & Action Visibility.....#
$visible_dropdownmenu = FALSE;
$visible_action_edit = FALSE;
if (array_key_exists('brand', Yii::app()->session['premission_info']['module_info'])) {
    if (strstr(Yii::app()->session['premission_info']['module_info']['brand'], 'C')) {
        $visible_dropdownmenu = TRUE;
    } else {
        $visible_dropdownmenu = FALSE;
    }

    if (strstr(Yii::app()->session['premission_info']['module_info']['brand'], 'U')) {
        $visible_action_edit = TRUE;
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
if (Yii::app()->session['is_super_admin'] == 1) {
//$this->menu = array(
//    array('label' => 'Add Brand', 'url' => array('store/create'),'visible' => $visible_dropdownmenu),
//    //array('label'=>'Configure Retailers', 'url'=>array('store/mapretailer')),
//);
}
?>

<!--<h1 class="item_title">Manage Brands</h1>-->
<h2>Subscribed Product List</h2>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-error label label-success" style="margin-left: 15px;"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')): ?><div class="flash-error label label-important" style="margin-left: 15px;"  ><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>
<?php $model_admin_data = new RetailerProductQuotation();
        $data1 = $model_admin_data->admin_retailer_id($_REQUEST['id']);
   //  echo '<pre>';print_r($data1);die;
        ?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'itemsCssClass' => 'table table-striped table-bordered table-hover',
    'id' => 'ympdm-store-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        //'subscribed_product_id',
        
        array(
            'header'=>'Title',
             'name' => 'subscribed_product_id',
                 'type' => 'raw',
               'value' => '$data->BaseProduct->title',
           ),
       // 'store_id',
        // 'diameter',
        'store_price',
        'store_offer_price',
       
      
        'link' => array(
            'header' => 'Action',
            'type' => 'raw',
            'value' => 'CHtml::button("Mapped",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("subscribedProduct/mappedProduct",array("id"=>$data->subscribed_product_id,"retailer_id" => $_REQUEST["id"]))."\'"))',
        ),
    ),
));
?>
