<?php
    /* @var $this OrderHeaderController */
    /* @var $dataProvider CActiveDataProvider */

    $this->breadcrumbs=array(

    'Order Headers'=>array('admin'),
    );

    $this->menu=array(
    array('label'=>'Create OrderHeader', 'url'=>array('create')),
    array('label'=>'Manage OrderHeader', 'url'=>array('admin')),
    );
?>

<h1>Order Headers</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    )); ?>
