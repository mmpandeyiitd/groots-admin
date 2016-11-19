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
		'id'=>'vendor-product-grid',   
		'itemsCssClass' => 'table table-striped table-bordered table-hover',
		'dataProvider'=> $dataProvider,
		'filter' => $products,
		'columns' => array(
				array(
					'header' => 'select',
					'value' => function($data){
						echo CHtml::checkBox('base_product_id', false, array());
					},
					'type' => 'raw',

					),
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

