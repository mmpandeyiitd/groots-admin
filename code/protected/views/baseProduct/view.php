<?php
/* @var $this BaseProductController */
/* @var $model BaseProduct */

$this->breadcrumbs=array(
	'Style'=>array('admin'),
	$model->title,
);

$this->menu=array(
	//array('label'=>'List BaseProduct', 'url'=>array('index')),
	array('label'=>'Create Style', 'url'=>array('create')),
	array('label'=>'Update Style', 'url'=>array('update', 'id'=>$model->base_product_id)),
	array('label'=>'Delete Style', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->base_product_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Styles', 'url'=>array('admin')),
);
?>
<?php

//$connection = Yii::app()->db;
//
//$sql = "INSERT INTO product_category_mapping(base_product_id, category_id)
//VALUES(:base_product_id, :category_id)";
//$command=$connection->createCommand($sql);
//$command->bindValue(":base_product_id", $_REQUEST);
//$command->bindValue(":category_id", $_REQUEST);
//$command->execute();
?>


<h1>View Style #<?php echo $model->base_product_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'base_product_id',
		'title',
		'small_description',
		'description',
		'color',
		'size',
                'image',
		'product_weight',
		'brand',
		'model_name',
		'model_number',
		'manufacture',
		'manufacture_country',
		'manufacture_year',
		'specifications',
		'key_features',
		'meta_title',
		'meta_keyword',
		'meta_description',
		'average_rating',
		'other_website_rating',
		'is_configurable',
		'configurable_with',
		'status',
		'created_date',
		'modified_date',
		'campaign_id',
		'is_deleted',
		'is_serial_required',
		'product_content_type',
		'ISBN',
		'product_shipping_charge',
		'video_url',
	),
)); ?>
