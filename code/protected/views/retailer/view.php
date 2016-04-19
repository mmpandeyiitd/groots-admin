<?php
/* @var $this RetailerController */
/* @var $model Retailer */

$this->breadcrumbs = array(
    'Retailers' => array('admin'),
    $model->name,
);

$this->menu = array(
    array('label' => 'Create Retailer', 'url' => array('create')),
    array('label' => 'Update Retailer', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Retailer', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Retailer', 'url' => array('admin')),
);
?>

<h1>View Retailer #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'name',
        'email',
        'mobile',
        'address',
        'city',
        'state',
        //'brand_mapped',
        'status',
        'created_date',
        'modified_date',
    ),
));
?>
