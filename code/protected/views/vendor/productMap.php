<?php

$vendor_id = $_GET['vendor_id'];

?>

<div>
<h1>VENDOR PRODUCT MAPPING </h1>
<?php echo 'Vendor ID =    '.$vendor_id.'<br>';?>
<?php echo 'Name =         '.$model->name.'<br>';?>
<?php echo 'Bussiness Name '.$model->bussiness_name.'<br>'; ?>
<?php echo 'Mobile Number  '.$model->mobile.'<br>'; ?>
</div>

<?php
    $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'id',
		'dataProvider'=> $dataProvider,
		'columns' => array(
            	'base_product_id',
            	'title',
            	'parent_id',
            	'grade',
            	'popularity',
            	'priority',
            	'base_title',
            ),
        )
    );
?>

