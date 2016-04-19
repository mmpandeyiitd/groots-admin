<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->category_id=>array('view','id'=>$model->category_id),
	'Manage',
);

$this->menu=array(
	
	array('label'=>'Create Category', 'url'=>array('create')),
	
);
?>
<div class="portlet" id="yw0">
<div class="portlet-decoration">
<div class="portlet-title"><i class="fa fa-sitemap"></i> Manage Category <?php echo $model->category_id; ?></div>
</div>
<div class="portlet-content">
  
<?php //$this->renderPartial('category_tree', array('category_id'=>'')); ?>
<?php $this->renderPartial('form', array('model'=>$model, 'category_id' => $category_id,)); ?>
</div>
</div>