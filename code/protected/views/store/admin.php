<?php
$this->breadcrumbs = array(
    'Store' => array('admin'),
    'Manage',
);

#......Menu & Action Visibility.....#
$visible_dropdownmenu = true;
$visible_action_edit = true;
/*if (array_key_exists('brand', Yii::app()->session['premission_info']['module_info'])) {
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
}*/
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
<?php if (Yii::app()->user->hasFlash('error')): ?><div class="flash-error" style="color: red;"><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>
<!--<h1 class="item_title">Manage Brands</h1>-->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'itemsCssClass' => 'table table-striped table-bordered table-hover',
    'id' => 'ympdm-store-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'header' => 'Store Logo',
            'type' => 'image',
            'value' => function ($data) {
                return $data->store_logo_url;
            }
        ),
      //  'store_name',
         array(
                'header' => 'Store Name',
                'name' => 'store_name',
                'type' => 'raw',
            ),       
        'email',
        'mobile_numbers',
        array(
            'name' => 'business_address',
            'value' => '($data->business_address == "")?"N/A":$data->business_address'
            ),
                array(
            'name' => 'business_address_city',
            'value' => '($data->business_address_city == "")?"N/A":$data->business_address_city'
            ),
                array(
            'name' => 'business_address_pincode',
            'value' => '($data->business_address_pincode == "")?"N/A":$data->business_address_pincode'
        ),
        
        array(
            'header' => 'Total Product',
            'type' => 'raw',
            'value' => function ($data) {
                $style = BaseProduct::model()->getTotalproductofBrand($data->store_id);
                return $style;
            },
        ),
        'link' => array(
            'header' => 'Action',
            'type' => 'raw',
            'value' => 'CHtml::button("Edit",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("store/update",array("id"=>$data->store_id))."\'"))',
            'visible' => $visible_action_edit
        ),
    /* 'link1' => array(
      'header' => 'Configure Retailers',
      'type' => 'raw',
      'value' => 'CHtml::button("Configure",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("store/mapretailer",array("id"=>$data->store_id))."\'"))',
      ), */
    ),
));
?>