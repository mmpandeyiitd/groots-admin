<?php
$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'vendor-credit-grid',   
		'itemsCssClass' => 'table table-striped table-bordered table-hover',
		'dataProvider'=> $dataProvider->searchcredit(),
		'filter' => $model,
		'columns' => array(
			'id',
			'name',
			'vendor_type',
			array(
				'header' => 'Sku Served',
				'type' => 'raw',
				'value' => function($data) use ($skuMap){
				return CHtml::dropDownList( 'sku' , '',(empty($skuMap[$data->id]) ? array() : $skuMap[$data->id]), array('empty' => "SKU's Served", 'style' => 'width:220.5px;' ));
				}),
			'total_pending_amount',
			array(
				'header' => 'Credit Repaid',
				'type' => 'raw',
				'value' => function(){
					return CHtml::textField('creditPaid', '', array('style' => 'width:110.5px;'));
				}),
			)
		)
);

?>