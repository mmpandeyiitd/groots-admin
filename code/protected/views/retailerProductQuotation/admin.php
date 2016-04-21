<?php
$this->breadcrumbs = array(
    //'retailerProductQuotation' => array('admin'),
    'Manage',
);

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
<?php
$model_retailers = new Retailer();
$rdetils = $model_retailers->data_retailers($_REQUEST['id']);
//echo '<pre>';
//print_r($rdetils);die;
?>
<h5>
    <?php
    echo "Name : " . $rdetils['0']['name'];
    echo '</br>';
    echo "Email : " . $rdetils['0']['email'];
    echo '</br>';
    echo "Mobile :" . $rdetils['0']['mobile'];
    ?></h5>


<!--<h1 class="item_title">Manage Brands</h1>-->
<!--<h2>Manage Retailer Product Quotations</h2>-->
<div class="search-form" style="display:none">
     <?php
    $this->renderPartial('_search', array(
       // 'model' => $model,
         'model_grid' => $model_grid,
    ));
    ?>

</div><!-- search-form -->
<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="flash-error label label-success" style="margin-left: 15px;">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')): ?>
    <div class="flash-error label label-important" style="margin-left: 15px;"  >
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<?php
$retailer_id=$_REQUEST['id'];
$this->widget('zii.widgets.grid.CGridView', array(
    'itemsCssClass' => 'table table-striped table-bordered table-hover',
    'id' => 'ympdm-store-grid',
    'dataProvider' => $model_grid->search(),
    'filter' => $model_grid,
    'columns' => array(
        array(
            'name' => 'title',
            'type' => 'raw',
        ),
        'effective_price',
        'discount_per',
    
          'link' => array(
                'header' => 'Edit',
                'type' => 'raw',
                'value' => function ($data)use ($retailer_id) {
                    return CHtml::button("Edit", array("onclick" => "document.location.href='" . Yii::app()->controller->createUrl("retailerProductQuotation/update", array("id" =>$data->subscribed_product_id, 'retailer_id' =>$retailer_id)) . "'"));
                },
                        'visible' => $visible_action_edit
                    ),
                        'link1' => array(
                'header' => 'Delete',
                'type' => 'raw',
                'value' => function ($data)use ($retailer_id) {
                    return CHtml::button("Delete", array("onclick" => "document.location.href='" . Yii::app()->controller->createUrl("retailerProductQuotation/View", array("id" =>$data->subscribed_product_id, 'retailer_id' =>$retailer_id)) . "'"));
                },
                        'visible' => $visible_action_edit
                    ),
        
       /*  'link1' => array(
         'header' => 'Action',
           'type' => 'raw',
           'value' => 'CHtml::button("Delete",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("retailerProductQuotation/delete",array("id"=>$data->retailer_id))."\'"))',
        ),*/
    ),
       
   
));

?>
