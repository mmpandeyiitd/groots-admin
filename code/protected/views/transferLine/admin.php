<?php
/* @var $this TransferLineController */
/* @var $model TransferLine */

$this->breadcrumbs=array(
	'Transfer Lines'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TransferLine', 'url'=>array('index')),
	array('label'=>'Create TransferLine', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#transfer-line-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Transfer Lines</h1>

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
	'id'=>'transfer-line-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'transfer_id',
		'base_product_id',
		'colour',
		'size',
		'grade',
		/*
		'diameter',
		'pack_size',
		'pack_unit',
		'weight',
		'weight_unit',
		'length',
		'length_unit',
		'order_qty',
		'delivered_qty',
		'received_qty',
		'unit_price',
		'price',
		'status',
		'created_at',
		'updated_at',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
