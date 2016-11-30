<?php
/* @var $this PurchaseHeaderController */
/* @var $model PurchaseHeader */


$this->breadcrumbs=array(
	'Purchase Headers'=>array('admin&w_id='.$w_id),
	'Create',
);

$this->menu=array(
	array('label'=>'List Purchases', 'url'=>array('admin&w_id='.$w_id)),
	//array('label'=>'Manage PurchaseHeader', 'url'=>array('admin')),
);
?>

<h1>Create Purchases</h1>

<?php //$this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->renderPartial('_purchaseForm', array('model'=>$model, 'inv_header'=>$inv_header, 'dataProvider'=>$dataProvider, 'w_id'=>$w_id, 'purchaseLineMap'=>$purchaseLineMap)); ?>


