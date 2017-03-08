<?php
/* @var $this VendorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vendors',
);

$this->menu=array(
	array('label'=>'Create Vendor', 'url'=>array('create')),
	array('label'=>'Manage Vendor', 'url'=>array('admin')),
);
?>

<?php if (Yii::app()->user->hasFlash('premission_info')): ?>
	<span class="Csv" style="color:red">
        <?php echo Yii::app()->user->getFlash('premission_info'); ?>
    </span>
<?php endif; ?>

<h1>Vendors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
