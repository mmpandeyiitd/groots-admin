<?php
/* @var $this OrderLineController */
/* @var $model OrderLine */

$this->breadcrumbs=array(
	'Order Lines'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List OrderLine', 'url'=>array('index')),
	array('label'=>'Create OrderLine', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#order-line-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Order Lines</h1>

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
	'id'=>'order-line-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'order_id',
		'subscribed_product_id',
		'base_product_id',
		'store_id',
		'store_name',
		/*
		'store_email',
		'store_front_id',
		'store_front_name',
		'seller_name',
		'seller_phone',
		'seller_address',
		'seller_state',
		'seller_city',
		'colour',
		'size',
		'product_name',
		'product_qty',
		'unit_price',
		'price',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
