<?php
/* @var $this BaseProductController */
/* @var $model BaseProduct */

$this->breadcrumbs=array(
	'Styles'=>array('admin'),
	'Subscribe New product',
);
$this->menu=array(
	array('label'=>'Edit Subscribed product', 'url'=>array('subscribedProduct/admin&store_id='.$store_id.'')),
	array('label'=>'Bulk Upload Subscribed product', 'url'=>array('subscribedProduct/bulkupload')),
      
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#base-product-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Subscribe New Styles</h1>




<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 



$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'base-product-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'base_product_id',
		'title',
		'color',
		'size',
                'model_name',
		'modified_date',
                
                'link'=>array(
                        'header'=>'Action',
                        'type'=>'raw',
                        'value'=> 'CHtml::button("Subscribe",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl("subscribedProduct/create",array("base_product_id"=>$data->base_product_id,"store_id"=>'.$store_id.'))."\'"))',
                ),   
		
	),
)); ?>
