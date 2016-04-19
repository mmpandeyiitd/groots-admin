<?php
/* @var $this BaseProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Styles',
);

$this->menu=array(
	array('label'=>'Create Styles', 'url'=>array('create',)),
	array('label'=>'Manage Styles', 'url'=>array('admin')),
);
?>

<h1>Base Products</h1>
<form method="get">
<input type="search" placeholder="search" name="q" 

value="<?=isset($_GET['q']) ? CHtml::encode($_GET['q']) : '' ; 

?>" />
<input type="submit" value="search" />
</form>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
