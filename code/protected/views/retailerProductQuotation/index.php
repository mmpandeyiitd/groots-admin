<?php
/* @var $this RetailerProductQuotationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Retailer Product Quotations',
);

$this->menu=array(
	array('label'=>'Create RetailerProductQuotation', 'url'=>array('create')),
	array('label'=>'Manage RetailerProductQuotation', 'url'=>array('admin')),
);
?>

<h1>Retailer Product Quotations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
