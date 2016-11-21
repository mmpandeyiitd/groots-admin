<?php

$vendor_id = $_GET['vendor_id'];

?>
<form name="myform" method="post" action="<?php echo $this->createUrl('vendor/productMap', array('vendor_id' => $vendor_id));?>">
<div>
<h1>VENDOR PRODUCT MAPPING </h1>
<?php echo 'Vendor ID =      '.$vendor_id.'<br>';?>
<?php echo 'Name =           '.$model->name.'<br>';?>
<?php echo 'Bussiness Name = '.$model->bussiness_name.'<br>'; ?>
<?php echo 'Mobile Number =  '.$model->mobile.'<br>'; ?>
</div>

<?php
    $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'vendor-product-grid',   
		'itemsCssClass' => 'table table-striped table-bordered table-hover',
		'dataProvider'=> $dataProvider->searchNew(),
		'filter' => $dataProvider,
		'columns' => array(
				array(
					'header' => 'select',
					'value' => function($data) use ($products) {
						$checked = in_array($data->base_product_id, $products);
						echo CHtml::checkBox('checkbox[]', $checked, array());
					},
					'type' => 'raw',

					),
            	'base_product_id',
            	'parent_id',
            	'grade',
            	'title',
            	'popularity',
            	'priority',
            	'base_title',
            	array(
            		'value' => function($data){
            			echo CHtml::hiddenField('checked_ids[]', $data->base_product_id);
            		},
            		'type' => 'raw',
            		),
            ),
        )
    );   

?>

<div class="row buttons">
	<?php echo CHtml::submitButton('Save'); ?>
</div>
</form>



