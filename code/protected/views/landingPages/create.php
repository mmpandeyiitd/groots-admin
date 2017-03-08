<?php
/* @var $this LandingPagesController */
/* @var $model LandingPages */

$this->breadcrumbs=array(
	'Landing Pages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LandingPages', 'url'=>array('index')),
	array('label'=>'Manage LandingPages', 'url'=>array('admin')),
);
?>

<h1>Create LandingPages</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>