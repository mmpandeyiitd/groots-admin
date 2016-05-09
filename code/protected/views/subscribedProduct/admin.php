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
<?php
$model_retailers = new Retailer();
$rdetils = $model_retailers->data_retailers($_REQUEST['id']);
//echo '<pre>';
//print_r($rdetils);die;
?>
            
    <?php if (Yii::app()->user->hasFlash('premission_info')): ?><div class="errorSummary"><?php echo Yii::app()->user->getFlash('premission_info'); ?></div><?php endif; ?>
<?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="Csv" style="color:green;">
            <?php echo Yii::app()->user->getFlash('success'); ?>
             <?php echo Yii::app()->user->getFlash('prod'); ?>
        </div>
        <?php endif; ?>
 <?php
//$pageSize = Yii::app()->user->getState( 'pageSize', Yii::app()->params[ 'defaultPageSize' ] );
    $pageSize = 10;
    $pageSizeDropDown = CHtml::dropDownList(
                    'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100,500 => 500), array(
                'class' => 'change-pagesize',
                'onchange' => "$.fn.yiiGridView.update('order-header-grid',{data:{pageSize:$(this).val()}});",
                    )
    );
    ?>
<h5 style="float: left;">
    <?php
    echo "Name : " . $rdetils['0']['name'];
    echo '</br>';
    echo "Email : " . $rdetils['0']['email'];
    echo '</br>';
    echo "Mobile :" . $rdetils['0']['mobile'];
    ?></h5>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model_grid' => $model_grid,
    ));
    ?>
</div><!-- search-form -->
<?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-error label label-success" style="margin-left: 15px;"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')): ?><div class="flash-error label label-important" style="margin-left: 15px;"  ><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>
<?php
$model_admin_data = new RetailerProductQuotation();
// $data1 = $model_admin_data->admin_retailer_id($_REQUEST['id']);
//  echo '<pre>';print_r($data1);die;
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'enableAjaxValidation' => true,
        ));
?>
   <?php
//$pageSize = Yii::app()->user->getState( 'pageSize', Yii::app()->params[ 'defaultPageSize' ] );
    $pageSize = 10;
    $pageSizeDropDown = CHtml::dropDownList(
                    'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100,500 => 500), array(
                'class' => 'change-pagesize',
                'onchange' => "$.fn.yiiGridView.update('order-header-grid',{data:{pageSize:$(this).val()}});",
                    )
    );
    ?>
<input name="savedata" class="activebutton" value="save" type="submit">
 
    <?php
$this->widget('zii.widgets.grid.CGridView', array(
    'itemsCssClass' => 'table table-striped table-bordered table-hover',
    'id' => 'ympdm-store-grid',
    'dataProvider' => $model_grid->search('created_date DESC'),
    'filter' => $model_grid,
    'columns' => array(
        array(
            'header' => 'check',
            'name' => 'selectedIds[]',
            'id' => 'selectedIds',
            'value' => '$data->subscribed_product_id',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => '100',
        ),
        'title',
        'store_price',
        'store_offer_price',
        array(
            //'header' => 'check',
            'name' => 'effective_price',
            'type' => 'raw',
            'value' => 'CHtml::textField("effective_price[$data->subscribed_product_id]",$data->effective_price,array("style"=>"width:50px;"))',
            'htmlOptions' => array("width" => "50px"),
        ),
        array(
            //'header' => 'check',
            'name' => 'discount_price',
            'type' => 'raw',
            'value' => 'CHtml::textField("discount_price[$data->subscribed_product_id]",$data->discount_price,array("style"=>"width:50px;"))',
            'htmlOptions' => array("width" => "50px"),
        ),
       
    ),
));
?>
<?php $this->endWidget(); ?>