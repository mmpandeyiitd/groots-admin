<?php
/* @var $this LandingPagesController */
/* @var $model LandingPages */

$this->breadcrumbs=array(
	'Landing Pages'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LandingPages', 'url'=>array('index')),
	array('label'=>'Create LandingPages', 'url'=>array('create')),
	array('label'=>'View LandingPages', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LandingPages', 'url'=>array('admin')),
);
?>

<h1>Update LandingPages <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>