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
	);
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

<h1>Manage Purchases</h1>

<?php /*echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); */?><!--
<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */?>
</div>--><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'purchase-header-grid',
	'itemsCssClass' => 'table table-striped table-bordered table-hover',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		//'warehouse_id',
		array(
			'header' => 'vendor',
			//'headerHtmlOptions' => array('style' => 'width:40%;'),
			//'htmlOptions' => array('style' => 'width:40%;'),
			'value' => function ($data) {
				return CHtml::label($data->Vendor->name, $data->Vendor->name,array('class'=>'title'));
			},
			'type' => 'raw',
		),
		'payment_method',
		'payment_status',
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
			'value' => 'CHtml::button("Update",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("purchaseHeader/update",array("w_id"=>$data->warehouse_id, "id"=>$data->id))."\'"))',
		),
	),
)); ?>
