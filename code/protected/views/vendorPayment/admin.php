<?php
/* @var $this VendorPaymentController */
/* @var $model VendorPayment */

$this->breadcrumbs=array(
	'Vendor Payments'=>array('index'),
	'Manage',
);

// $this->menu=array(
// 	array('label'=>'List VendorPayment', 'url'=>array('index')),
// 	array('label'=>'Create VendorPayment', 'url'=>array('create')),
// );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#vendor-payment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Vendor Payments</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vendor-payment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'vendor_id',
		'paid_amount',
		'date',
		'payment_type',
		'cheque_no',
		'debit_no',
		'cheque_cleared',
		'comment',
		//'created_at',
		//'updated_at',
		'status',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
