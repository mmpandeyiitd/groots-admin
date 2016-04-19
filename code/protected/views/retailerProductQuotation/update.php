<?php
/* @var $this RetailerProductQuotationController */
/* @var $model RetailerProductQuotation */

$this->breadcrumbs=array(
	'Retailer Product Quotations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RetailerProductQuotation', 'url'=>array('index')),
	array('label'=>'Create RetailerProductQuotation', 'url'=>array('create')),
	array('label'=>'View RetailerProductQuotation', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RetailerProductQuotation', 'url'=>array('admin')),
);
?>

<h1>Update RetailerProductQuotation <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>