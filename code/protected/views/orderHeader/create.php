<?php
/* @var $this OrderHeaderController */
/* @var $model OrderHeader */

$this->breadcrumbs=array(
	'Order Headers'=>array('index'),
	'Create',
);

?>

<h1>Create OrderHeader</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>