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

<!--<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>


<?php /*echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); */?>
<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */?>
</div>--><!-- search-form -->
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
			//'headerHtmlOptions' => array('style' => 'width:40%;'),
			//'htmlOptions' => array('style' => 'width:40%;'),
			'value' => function ($data) {
				return CHtml::label($data->DestWarehouse->name, $data->DestWarehouse->name,array('class'=>'title'));
			},
			'type' => 'raw',
		),
		//'dest_warehouse_id',
		//'status',
		array(
			'name' => 'status',
			'value' => '$data->status',
			'type' => 'raw',
			'filter'=>CHtml::textField("TransferIn[status]", $transferIn->status),
		),
		//'delivery_date',
		array(
			'name' => 'delivery_date',
			'type' => 'raw',
			'value' => '$data->delivery_date',
			'filter'=>CHtml::textField("TransferIn[delivery_date]", $transferIn->delivery_date),
		),
		//'comment',
		array(
			'name' => 'comment',
			'value' => '$data->comment',
			'type' => 'raw',
			'filter'=>CHtml::textField("TransferIn[comment]", $transferIn->comment),
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
				return CHtml::button("Update",array("onclick"=>"document.location.href='".Yii::app()->controller->createUrl("transferHeader/update",array("w_id"=>$w_id, "id"=>$data->id))."'"));
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
		//'dest_warehouse_id',
		//'status',
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
				return CHtml::button("Update",array("onclick"=>"document.location.href='".Yii::app()->controller->createUrl("transferHeader/update",array("w_id"=>$w_id, "id"=>$data->id))."'"));
			},

		),
	),
)); ?>