<?php
/* @var $this RetailerRequestController */
/* @var $model RetailerRequest */


$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 1) {
    // $store_id = $_GET['store_id'];
} else {
    $store_id = Yii::app()->session['brand_id'];
}
$retailer_id = '';
$retailer_name = '';
if (isset($_GET['retailer_id'])) {
    $retailer_id = $_GET['retailer_id'];
    $retailer_name = Retailer::getRetailerNameByID($retailer_id);
}


#......Menu & Action Visibility.....#
$visible_dropdownmenu = FALSE;
$visible_action_edit = FALSE;
$visible_action_delete = FALSE;
if (array_key_exists('retailerrequest', Yii::app()->session['premission_info']['module_info'])) {
    if (strstr(Yii::app()->session['premission_info']['module_info']['retailerrequest'], 'C')) {
        $visible_dropdownmenu = strstr(Yii::app()->session['premission_info']['module_info']['retailerrequest'], 'C');
    } else {
        $visible_dropdownmenu = FALSE;
    }


    if (strstr(Yii::app()->session['premission_info']['module_info']['retailerrequest'], 'D')) {
        $visible_action_delete = strstr(Yii::app()->session['premission_info']['module_info']['retailerrequest'], 'D');
    } else {
        $visible_action_delete = FALSE;
    }

    if (strstr(Yii::app()->session['premission_info']['module_info']['retailerrequest'], 'U')) {
        $visible_action_edit = strstr(Yii::app()->session['premission_info']['module_info']['retailerrequest'], 'U');
    } else {
        $visible_action_edit = FALSE;
    }
}
#.........End Visibility.....#

$this->breadcrumbs = array(
    'Retailers' => array('retailer/admin'), //$store_name => array('store/update', "id" => $store_id),
    $retailer_name => array('admin', "retailer_id" => $retailer_id),
    'Retailer Request',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#retailer-request-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php //echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$counter = 0;
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'retailer-request-grid',
    'itemsCssClass' => 'table table-striped table-bordered table-hover',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'header' => 'S.N.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        array(
            'name' => 'store_name',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->Store->store_name;
            },
        ),
        array(
            'name' => 'comment',
            'type' => 'raw',
        ),
        array(
            'name' => 'status',
            'type' => 'raw',
            //  'filter' => array('' => 'Select', '0' => 'Pending', '2' => 'Approved', '1' => 'Rejected'),
            'value' => '($data->status == "0")?"Pending":($data->status == 1?"Rejected":"Approved")',
        ),
        'link11' => array(
            'header' => 'Action',
            'type' => 'raw',
            'value' => function ($data) use($retailer_id) {
                if ($data->status == 0) {
                    return CHtml::button("Reject", array("onclick" => "document.location.href='" . Yii::app()->controller->createUrl("retailerRequest/deactivate", array("request_id" => $data->id, 'retailer_id' => $retailer_id)) . "'"));
                } else if ($data->status == 1) {
                    return CHtml::button("Approve", array("onclick" => "document.location.href='" . Yii::app()->controller->createUrl("retailerRequest/activate", array("request_id" => $data->id, 'retailer_id' => $retailer_id,)) . "'"));
                } else {
                    return CHtml::button("Reject", array("onclick" => "document.location.href='" . Yii::app()->controller->createUrl("retailerRequest/deactivate", array("request_id" => $data->id, 'retailer_id' => $retailer_id)) . "'"));
                }
            },
                    'headerHtmlOptions' => array('colspan' => '2', 'style' => ' text-align:center'),
                ),
                'link111' => array(
                    'type' => 'raw',
                    'value' => function ($data)use($retailer_id) {
                        if ($data->status == 0) {
                            return CHtml::button("Approve", array("onclick" => "document.location.href='" . Yii::app()->controller->createUrl("retailerRequest/activate", array("request_id" => $data->id, 'retailer_id' => $retailer_id)) . "'"));
                        }
                    },
                            'visible' => function ($data) {
                        if ($data->status == 1 || $data->status == 2) {
                            return FALSE;
                        } else {
                            return true;
                        }
                    },
                            'headerHtmlOptions' => array('style' => 'display:none;', 'colspan' => '0'),
                        ),
                    ),
                ));
                ?>
