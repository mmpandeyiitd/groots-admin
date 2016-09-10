<?php
/* @var $this RetailerController */
/* @var $model Retailer */

$this->breadcrumbs = array(
    'Buyers' => array('admin'),
    'Manage',
);
if (array_key_exists('retailers', Yii::app()->session['premission_info']['module_info'])) {
    if (strstr(Yii::app()->session['premission_info']['module_info']['retailers'], 'C')) {
        $visible_dropdownmenu = strstr(Yii::app()->session['premission_info']['module_info']['retailers'], 'C');
    }
}

#......Menu & Action Visibility.....#
$visible_dropdownmenu = FALSE;
$visible_action_edit = FALSE;
$visible_action_delete = FALSE;
if (array_key_exists('retailers', Yii::app()->session['premission_info']['module_info'])) {
    if (strstr(Yii::app()->session['premission_info']['module_info']['retailers'], 'C')) {
        $visible_dropdownmenu = strstr(Yii::app()->session['premission_info']['module_info']['retailers'], 'C');
    } else {
        $visible_dropdownmenu = FALSE;
    }
    if (strstr(Yii::app()->session['premission_info']['module_info']['retailers'], 'D')) {
        $visible_action_delete = strstr(Yii::app()->session['premission_info']['module_info']['retailers'], 'D');
    } else {
        $visible_action_delete = FALSE;
    }
    if (strstr(Yii::app()->session['premission_info']['module_info']['retailers'], 'U')) {
        $visible_action_edit = strstr(Yii::app()->session['premission_info']['module_info']['retailers'], 'U');
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
	$('#retailer-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<div class="search-form" style="display:none">

</div><!-- search-form -->
<?php if (Yii::app()->user->hasFlash('permissio_error')): ?><div class="flash-error" style="color: red;"><?php echo Yii::app()->user->getFlash('permissio_error'); ?></div><?php endif; ?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'itemsCssClass' => 'table table-striped table-bordered table-hover',
    'id' => 'retailer1-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'name',
        'email',
        'city',
        'total_payable_amount',
        //'status',
        'link' => array(
            'header' => 'Action',
            'type' => 'raw',
            'value' => 'CHtml::button("Edit",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("retailer/update",array("id"=>$data->id))."\'"))',
            'visible' => $visible_action_edit,
            'headerHtmlOptions' => array('style' => 'color:#1d2e7b;'),
            'htmlOptions' => array('style' => 'text-align: center;'),
        ),
        /*
          'link1' => array(
          'header' => '',
          'type' => 'raw',
          'value' => 'CHtml::button("Delete",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("retailer/delete",array("id"=>$data->id))."\'"))',
          ), */
        'link1' => array(
            'header' => 'Special Price',
            'type' => 'raw',
            'value' => 'CHtml::button("special price mapping",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("SubscribedProduct/admin",array("id"=>$data->id))."\'",))',
            'headerHtmlOptions' => array('style' => 'color:#1d2e7b;'),
            'htmlOptions' => array('style' => 'text-align: center;'),
        ),
    /* 'link2' => array(
      'header' => '',
      'type' => 'raw',
      'value' => 'CHtml::button("Mapped",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("retailerProductQuotation/admin",array("id"=>$data->id))."\'"))',
      ), */
    ),
));
?>
