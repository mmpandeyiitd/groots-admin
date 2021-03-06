<?php
/* @var $this PurchaseHeaderController */
/* @var $model PurchaseHeader */

$this->breadcrumbs=array(
	'Warehouse'=>array(''),
	'Purchase'=>array(''),
	'Manage',
);

if($showCreate){
	$this->menu=array(
		array('label'=>'Create Purchase', 'url'=>array('create&w_id='.$w_id)),
		array('label' => 'Bulk Upload', 'url' => array('bulkUploadPurchase&w_id='.$w_id))
	);
}

if($w_id==SOURCE_WH_ID && ($this->checkAccess('SuperAdmin') || $this->checkAccessByData('ProcurementEditor', array('warehouse_id'=>$w_id) ) )){
	$procurementAccess = true;
}
else{
	$procurementAccess = false;
}

/*if($this->checkAccess('ProcurementEditor', array('warehouse_id'=>$w_id))){
	$this->menu=array(
		//array('label'=>'List Purchase', 'url'=>array('index')),
		array('label'=>'Create Purchase', 'url'=>array('create&w_id='.$w_id)),
	);
}*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#purchase-header-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php if(Yii::app()->user->hasFlash('error')):?>
        <div class="Csv" style="color:red;">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php endif; ?>

<h1>Manage Purchases</h1>

<div class="row">
       
    <?php
    echo '<br>';
    echo 'Select Date    ';
    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
    'name'=>'date',
    // additional javascript options for the date picker plugin
    'options'=>array(
    	'dateFormat' => 'yy-mm-dd',
        'showAnim'=>'fold',
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
)); ?>
         
</div>


<!--<div class = "row" style="float:right">
    <?php /*
    $url = Yii::app()->controller->createUrl("PurchaseHeader/downloadReconciliationReport",array('w_id' => $w_id));
    echo CHtml::button('Reconciliation Report', array('onclick' => "onClickDownloadProcurementReport('".$url."')")); 
    */?>
</div>-->

<div class = "row" style="float:right">
    <?php 
    $url = Yii::app()->controller->createUrl("PurchaseHeader/downloadProcurementReport",array('w_id' => $w_id));
    echo CHtml::button('Procurement Report', array('onclick' => "onClickDownloadProcurementReport('".$url."')")); 
    ?>
</div>

<?php if($procurementAccess){
	?>

	<br>
	<h4>Auto Generate Procurement Order</h4>

	<?php
		$form=$this->beginWidget('CActiveForm', array(
		'id'=>'procurement-date',
		'action'=>Yii::app()->createUrl('//purchaseHeader/dailyProcurement',array("w_id"=>$w_id)),
		'enableAjaxValidation'=>false,
	));
		echo $form->errorSummary($model->errors);
	?>
	<div class="row">
		<?php echo $form->labelEx($model, 'delivery_date');
		 $this->widget('zii.widgets.jui.CJuiDatePicker',array(
			//'model'=>$model,
			'name'=>'delivery_date',
			'value'=>$model->delivery_date,

			'id'=>'date',
			//'value'=> date('Y-m-d'),
			'options'=>array(
				'dateFormat' => 'yy-mm-dd',
				'showAnim'=>'fold',
			),
			'htmlOptions'=>array(
				'style'=>'height:20px;'
			),
		));
		echo $form->error($model,'date');

		echo CHtml::submitButton('submit', array('name'=>'inventory-date'));

		?>
	</div>
	<?php $this->endWidget();?>
<?php } ?>

<?php /*echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); */?><!--
<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */?>
</div>--><!-- search-form -->
<h4> Purchase Report</h4>
<form method = "post" action="<?php echo Yii::app()->getBaseUrl().'/index.php?r=purchaseHeader/intervalPurchaseReport&w_id='.$w_id;?>"
<div class="dashboard-table">
        <h4 style="width:20%">Purchase</h4>
        <div class="right_date" style="width:80%">
            <label for = "purchase_from">From</label>
            <?php

            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                // 'model' => $model,
                'name' => 'purchase_from',
                'attribute' => 'purchase_from',
                //'value' => $model->created_at,
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                    'showAnim' => 'fold',
                    'debug' => true,
                    //'mcollection_fromaxDate' => "60",
                ), //DateTimePicker options
                'htmlOptions' => array('readonly' => 'true'),
            ));
            //echo $form->error($model, 'created_at');
            ?>


            <label for = "purchase_to">To</label>
            <?php

            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                //'model' => $model,
                'name' => 'purchase_to',
                'attribute' => 'purchase_to',
                //'value' => $model->inv_created_at,
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                    'debug' => true,
                    //'maxDate' => "60",
                ), //DateTimePicker options
                'htmlOptions' => array('readonly' => 'true'),
            ));
            $url = "document.location.href='".Yii::app()->controller->createUrl("purchaseHeader/intervalPurchaseReport",array('w_id'=>$_GET['w_id']));
            ?>


            <?php
            echo CHtml::submitButton('Download', array('onclick' => 'onIntervalReportDownload(event)'));
            ?>

        </div>
</div>
</form>

<br>
<br>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'purchase-header-grid',
	'itemsCssClass' => 'table table-striped table-bordered table-hover',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		//'warehouse_id',
		/*array(
			'header' => 'vendor',
			//'headerHtmlOptions' => array('style' => 'width:40%;'),
			//'htmlOptions' => array('style' => 'width:40%;'),
			'value' => function ($data) {
				return CHtml::label($data->Vendor->name, $data->Vendor->name,array('class'=>'title'));
			},
			'type' => 'raw',
		),*/
		'delivery_date',
		/*'payment_method',
		'payment_status',*/
		array(
			'name' => 'purchase_type',
			'value' => '$data->purchase_type',
			'type' => 'raw',
			//'filter'=>CHtml::textField("TransferOut[status]", $transferOut->transfer_type),
		),
		array(
			'name' => 'comment',
			'value' => '$data->comment',
			'type' => 'raw',
			//'filter'=>CHtml::textField("TransferIn[comment]", $transferIn->comment),
		),
		'status',
		/*
		'delivery_date',
		'total_payable_amount',
		'comment',
		'invoice_number',
		'created_at',
		'updated_at',
		*/
		/*array(
			'class'=>'CButtonColumn',
		),*/
		'link' => array(
			'header' => 'Update',
			'headerHtmlOptions' => array('style' => 'color:#1d2e7b;'),
			'type' => 'raw',
			'value' => function($data){
				$text1 = "Update";
				$text2 = "Add";
				/*if($data->delivery_date < date('Y-m-d')){
					$text = "View";
				}*/
				return CHtml::button($text1,array("onclick"=>"document.location.href='".Yii::app()->controller->createUrl("purchaseHeader/update",array("w_id"=>$data->warehouse_id, "id"=>$data->id, "type"=>"update"))."'")) . CHtml::button($text2,array("onclick"=>"document.location.href='".Yii::app()->controller->createUrl("purchaseHeader/update",array("w_id"=>$data->warehouse_id, "id"=>$data->id, "type"=>"add"))."'"));
			},
		),
		array(
			'header' => 'Report',
			'type' => 'raw',
			'value' => function($data){
				return CHtml::button('report', array("onclick"=>"document.location.href='".Yii::app()->controller->createUrl("purchaseHeader/downloadReportById",array('id'=>$data->id, 'w_id' => $_GET['w_id']))."'"));
			},
			),
        array(
            'header' => 'Zip Invoices',
            'type' => 'raw',
            'value' => function($data){
                if($data->status == "received"){
                    return CHtml::button('Zip Invoices', array('onclick' => "document.location.href='".Yii::app()->controller->createUrl("vendor/zipInvoicesByVendor",array('id'=>$data->id))."'"));
                }
                else return '';
            }
        )
	),
)); ?>

<script type="text/javascript">

	function onClickDownloadProcurementReport(url){
        //document.location.href
        var date = $("#date").val().trim();
        url = url + "&date="+date;
        //window.location.assign(url);
        console.log(url);
        window.open(url, '_blank');
    }

    function onIntervalReportDownload(event) {

        var fromDate = $('#purchase_from').val();
        var toDate = $('#purchase_to').val();
        if(!fromDate){
            alert('Please Select From Date');
            event.preventDefault();
        }
        else if(!toDate){
            alert('Please Select to Date');
            event.preventDefault();
        }
    }


</script>
