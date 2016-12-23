
<h1 style = "color:#003300;">Vendor Ledger</h1>
<br>
<h4>
	Name : <?php echo $vendor->name; ?></br>
	Id: <?php echo $vendor->id; ?>
</h4>
<?php

$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'ledger-grid',   
		'itemsCssClass' => 'table table-striped table-bordered table-hover',
		'dataProvider'=> $dataProvider,
		'columns' => array(
			 'id',
			'date',
			'paid_amount',
			'order_quantity',
			'order_amount',
			'outstanding',
				),
		));
?>
