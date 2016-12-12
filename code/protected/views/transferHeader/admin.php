<?php
/* @var $this TransferHeaderController */
/* @var $model TransferHeader */

$this->breadcrumbs=array(
	'Warehouse'=>array(''),
	'Transfer'=>array(''),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List TransferHeader', 'url'=>array('index')),
	array('label'=>'Create Transfer Order', 'url'=>array('create&w_id='.$w_id)),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#transfer-header-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Transfer Orders</h1>
<br>
	<h4>Auto Generate Transfer Order</h4>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transIn-date',
	'action'=>Yii::app()->createUrl('//transferHeader/dailyTransfer',array("w_id"=>$w_id)),
	'enableAjaxValidation'=>false,
)); ?>
<div align = 'right'>
<?php
echo CHtml::button('Download Report', array('submit' => array('transferHeader/downloadTransferReport')))
?>
</div>
<?php echo $form->errorSummary($model->errors); ?>
	<!--<div class="row">
		<?php /*echo $form->labelEx($model, 'delivery_date'); */?>
		<?php /*$this->widget('zii.widgets.jui.CJuiDatePicker',array(
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
		)); */?>
		<?php /*echo $form->error($model,'date'); */?>
		<?php
/*
		echo CHtml::submitButton('submit', array('name'=>'inventory-date'));

		*/?>
	</div>-->
<?php $this->endWidget();?>


<h4>Transfer In</h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'transferIn-grid',
	'itemsCssClass' => 'table table-striped table-bordered table-hover',
	'dataProvider'=>$transferInDataProvider,
	'filter'=>$transferIn,
	'columns'=>array(
		'id',
		//'source_warehouse_id',
		array(
			'header' => 'source warehouse',
			//'headerHtmlOptions' => array('style' => 'width:40%;'),
			//'htmlOptions' => array('style' => 'width:40%;'),
			'value' => function ($data) {
				return CHtml::label($data->SourceWarehouse->name, $data->SourceWarehouse->name,array('class'=>'title'));
			},
			'type' => 'raw',
		),
		array(
			'header' => 'dest warehouse',

			'value' => function ($data) {
				return CHtml::label($data->DestWarehouse->name, $data->DestWarehouse->name,array('class'=>'title'));
			},
			'type' => 'raw',
		),
		array(
			'name' => 'transfer_type',
			'value' => '$data->transfer_type',
			'type' => 'raw',
			'filter'=>CHtml::textField("TransferOut[status]", $transferOut->transfer_type),
		),
		array(
			'name' => 'transfer_category',
			'value' => '$data->transfer_category',
			'type' => 'raw',
			'filter'=>CHtml::textField("TransferOut[status]", $transferOut->transfer_category),
		),

		array(
			'name' => 'status',
			'value' => '$data->status',
			'type' => 'raw',
			'filter'=>CHtml::textField("TransferIn[status]", $transferIn->status),
		),
		array(
			'name' => 'delivery_date',
			'type' => 'raw',
			'value' => '$data->delivery_date',
			'filter'=>CHtml::textField("TransferIn[delivery_date]", $transferIn->delivery_date),
		),
		array(
			'name' => 'comment',
			'value' => '$data->comment',
			'type' => 'raw',
			'filter'=>CHtml::textField("TransferIn[comment]", $transferIn->comment),
		),
		'link' => array(
			'header' => 'Update',
			'headerHtmlOptions' => array('style' => 'color:#1d2e7b;'),
			'type' => 'raw',
			'value' => function ($data) use ($w_id) {
				$text = "Update";
				/*if($data->delivery_date < date('Y-m-d')){
					$text = "View";
				}*/
				return CHtml::button($text,array("onclick"=>"document.location.href='".Yii::app()->controller->createUrl("transferHeader/update",array("w_id"=>$w_id, "id"=>$data->id))."'"));
			},

		),
	),
)); ?>

<h4>Transfer Out</h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'transferOut-grid',
	'itemsCssClass' => 'table table-striped table-bordered table-hover',
	'dataProvider'=>$transferOutDataProvider,
	'filter'=>$transferOut,
	'columns'=>array(
		'id',
		//'source_warehouse_id',
		array(
			'header' => 'source warehouse',
			//'headerHtmlOptions' => array('style' => 'width:40%;'),
			//'htmlOptions' => array('style' => 'width:40%;'),
			'value' => function ($data) {
				return CHtml::label($data->SourceWarehouse->name, $data->SourceWarehouse->name,array('class'=>'title'));
			},
			'type' => 'raw',
		),
		array(
			'header' => 'dest warehouse',
			//'headerHtmlOptions' => array('style' => 'width:40%;'),
			//'htmlOptions' => array('style' => 'width:40%;'),
			'value' => function ($data) {
				return CHtml::label($data->DestWarehouse->name, $data->DestWarehouse->name,array('class'=>'title'));
			},
			'type' => 'raw',
		),

		array(
			'name' => 'transfer_type',
			'value' => '$data->transfer_type',
			'type' => 'raw',
			'filter'=>CHtml::textField("TransferOut[status]", $transferOut->transfer_type),
		),
		array(
			'name' => 'transfer_category',
			'value' => '$data->transfer_category',
			'type' => 'raw',
			'filter'=>CHtml::textField("TransferOut[status]", $transferOut->transfer_category),
		),
		array(
			'name' => 'status',
			'value' => '$data->status',
			'type' => 'raw',
			'filter'=>CHtml::textField("TransferOut[status]", $transferOut->status),
		),
		//'delivery_date',
		array(
			'name' => 'delivery_date',
			'type' => 'raw',
			'value' => '$data->delivery_date',
			'filter'=>CHtml::textField("TransferOut[delivery_date]", $transferOut->delivery_date ),
		),
		//'comment',
		array(
			'name' => 'comment',
			'value' => '$data->comment',
			'type' => 'raw',
			'filter'=>CHtml::textField("TransferOut[comment]", $transferOut->comment),
		),
		/*
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
			'value' => function ($data) use ($w_id) {
				$text = "Update";
				/*if($data->delivery_date < date('Y-m-d')){
					$text = "View";
				}*/
				return CHtml::button($text,array("onclick"=>"document.location.href='".Yii::app()->controller->createUrl("transferHeader/update",array("w_id"=>$w_id, "id"=>$data->id))."'"));
			},

		),
	),
)); ?>