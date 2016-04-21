<?php
/* @var $this OrderHeaderController */
/* @var $model OrderHeader */
ob_clean();
$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 0) {

    if (empty(Yii::app()->session['brand_admin_id']) && empty(Yii::app()->session['brand_id'])) {

        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong.');
        $this->redirect(array('DashboardPage/index'));
    }
    $store_id = Yii::app()->session['brand_admin_id'];
    if (empty($store_id)) {
        $store_id = Yii::app()->session['brand_id'];
    }
    //$store_id = $_GET['store_id'];
    $store_name = Store::model()->getstore_nameByid($store_id);

    if ((Yii::app()->session['brand_admin_id'] != $store_id) && (Yii::app()->session['brand_id'] != $store_id)) {
        //echo Yii::app()->session['brand_admin_id'];die;
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong.');
        $this->redirect(array('DashboardPage/index'));
    }

    $this->breadcrumbs = array(
        'Brand' => array('store/admin'),
        $store_name => array('store/update', "id" => $store_id),
        'Orders' => array('orderHeader/admin',),
        'Manage',
    );
} else {
    $store_id = Yii::app()->session['brand_id'];
    $this->breadcrumbs = array(
        'Orders' => array('admin',),
        'Manage',
    );
}

?>
<script>
function confirmation_function() {
    confirm("Do you want to cancel");
}
</script>

<div class="search-form" style="display:none">
 
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<form method="post" action="">
       
     <?php if (Yii::app()->user->hasFlash('premission_info')): ?><div class="errorSummary"><?php echo Yii::app()->user->getFlash('premission_info'); ?></div><?php endif; ?>
<input name="cancelbutton" class="activebutton" value="Cancel Order" type="submit" 
       onclick='return confirm("Do you want to cancel");'/>
<input  type="submit" name="downloadbutton" class="activebutton" value="Download CSV File" />
<?php
//$pageSize = Yii::app()->user->getState( 'pageSize', Yii::app()->params[ 'defaultPageSize' ] );
$pageSize = 10;
$pageSizeDropDown = CHtml::dropDownList(
                'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100), array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('order-header-grid',{data:{pageSize:$(this).val()}});",
                )
);
?>
<?php
$count = count($model);
if (!empty($model)) {
    ?>
    <div class="page-size-wrap">
        <span>Show : </span><?= $pageSizeDropDown; ?>
    </div>
<?php } ?>
<?php
Yii::app()->clientScript->registerCss('initPageSizeCSS', '.page-size-wrap{text-align: left;}');

$this->widget('zii.widgets.grid.CGridView', array(
    'itemsCssClass' => 'table table-striped table-bordered table-hover',
    'id' => 'order-header-grid',
    'dataProvider' => $model->search('created_date DESC'),
    'filter' => $model,
    //  'summaryText'  => '{Start} - {End} / {count}',
    'columns' => array(
        
         array(
            'header' => 'check',
            'name' => 'selectedIds[]',
            'id' => 'selectedIds',
            'value' => '$data->order_id',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => '100',
        ),
        
        array(
            'header' => 'S.N.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        'order_number',
         array(
                'header' => 'Billing name',
                'name' => 'billing_name',
                'type' => 'raw',
            ),
        //'billing_name',
        'shipping_city',
        'shipping_state',
        'payment_status',
        array(
            'header' => 'Amount',
            'name' => 'total',
            'type' => 'raw',
           // 'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
//        array(
//            'name' => 'status',
//            'type' => 'raw',
//             'filter' => array('' => 'all', '1' => 'Enable', '0' => 'Disable'),
//             'value' => '($data->status == "1")?"Enable":"Disable"',
//            'htmlOptions' => array('width' => 90),
//        ),
        'created_date',
        'link' => array(
            'header' => 'Action',
            'type' => 'raw',
            'value' => 'CHtml::button("View",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("OrderHeader/update",array("id"=>$data->order_id))."\'"))',
        ),
        'link1' => array(
            'header' => 'Dispatch',
            'type' => 'raw',
            'value' => 'CHtml::button("Dispatch",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("OrderHeader/dispatch",array("id"=>$data->order_id))."\'"))',
        )
    ),
));

?>

</form>