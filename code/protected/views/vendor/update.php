<?php
/* @var $this VendorController */
/* @var $model Vendor */

$this->breadcrumbs=array(
	'Vendors'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Vendor', 'url'=>array('index')),
	array('label'=>'Create Vendor', 'url'=>array('create')),
	array('label'=>'View Vendor', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Vendor', 'url'=>array('admin')),
);
?>

<h1>Update Vendor <?php echo $model->id; ?></h1>

<?php if (Yii::app()->user->hasFlash('premission_info')): ?>
	<span class="Csv" style="color:red">
        <?php echo Yii::app()->user->getFlash('premission_info'); ?>
    </span>
<?php endif; ?>


<?php $this->renderPartial('_form', array('model'=>$model, 'update'=>true)); ?>