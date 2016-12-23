<form name="dateSelector" method="post" action="<?php echo Yii::app()->getBaseUrl().'/index.php?r=vendor/creditManagement';?>">

<?php
echo CHtml::label('Select date', 'date');
$this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$vendorPayment,
            'attribute'=>'date',
            'value' => $vendorPayment->date,
            'id'=>'date',
            'options'=>array(
                'dateFormat' => 'yy-mm-dd',
                'showAnim'=>'fold',
            ),
            'htmlOptions'=>array(
                'style'=>'height:20px;'
            ),
        ));
echo '   ';
echo CHtml::button('Submit', array('submit' => array('vendor/creditManagement'), 'style' => 'height:30px;'));

?>
</form>

<span style = "color:#F2391C;"> <b>Create Only Cash Payments Here. For Other Payment Modes Click The <u>Payment</u> link </b></span>
<form name="credit" method="post" action="<?php echo Yii::app()->getBaseUrl().'/index.php?r=vendor/creditManagement&date='.$vendorPayment->date;?>">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'vendor-credit-grid',   
		'itemsCssClass' => 'table table-striped table-bordered table-hover',
		'dataProvider'=> $dataProvider->searchcredit(),
		'filter' => $model,
		'columns' => array(
			array(
				'header' => 'Id',
				'name' => 'id',
				'value' => '$data->id',
				'footer' => 'Totals :',
				),
			array(
				'header' => 'Name',
				'name' => 'name',
				'value' => '$data->name',
				'footer' => '',
				),
			array(
				'header' => 'Vendor Type',
				'name' => 'vendor_type',
				'value' => '$data->vendor_type',
				'footer' => '',
				),
			'credit_limit',
			//'vendor_type',
			array(
				'header' => 'Sku Served',
				'type' => 'raw',
				'value' => function($data) use ($skuMap){
				return CHtml::dropDownList( 'sku' , '',(empty($skuMap[$data->id]) ? array() : $skuMap[$data->id]), array('empty' => "SKU's Served", 'style' => 'width:130px;' ));
				},
				'footer' => '',),
			array(
				'header' => 'Total Pending',
				'type' => 'raw',
				'value' => function($data) use ($totalPendingMap, $initialPendingMap){
					if(array_key_exists($data->id, $totalPendingMap)){
						return $totalPendingMap[$data->id] + $initialPendingMap[$data->id];
					}
					else return $initialPendingMap[$data->id];
				},
				/*'footer' => function() use ($totalPendingMap){
					echo $totalPendingMap['total'];
				},*/
				//'footer' => '',
				),
			array(
				'header' => 'Payment Due Date',
				'type' => 'raw',
				'value' => function($data) use ($payable){
					return $payable[$data->id]['dueDate'];
				},
				'footer'=>'',
				),
			array(
				'header' => 'Previous Due Date',
				'type' => 'raw',
				'value' => function($data) use ($payable){
					return $payable[$data->id]['lastDueDate'];
				},
				'footer'=>'',
				),
			array(
				'header' => 'Amount Payable',
				'value' => function($data) use ($payable, $initialPendingMap){
					// $temp  = $payable[$data->id]['amount'];
					// if(array_key_exists($data->id, $totalPendingMap)){
					// 	$total = $totalPendingMap[$data->id];
					// 	return min($temp, $total);
					// }
					// else{
					// 	return $temp;
					// }
					//return $initialPendingMap[$data->id];
					//return ($payable[$data->id]['amount']);

					$temp = $payable[$data->id]['amount'] + $initialPendingMap[$data->id] - $data->credit_limit;
					return ($temp > 0) ? $temp : 0;

				},
				// 'footer' => function($payable){
				// 	return $payable['total'];
				// }
				),
			array('header' => 'Last Paid On',
				'type' => 'raw',
				'value' => function($data) use($lastPaymentDetails){
					if(array_key_exists($data->id, $lastPaymentDetails)){
						return $lastPaymentDetails[$data->id]['date'];
					}
					else return 'NA';
				}
				),
			array(
				'header' => 'Last Paid Amount',
				'type' => 'raw',
				'value' => function($data) use ($lastPaymentDetails){
					if(array_key_exists($data->id, $lastPaymentDetails)){
						return $lastPaymentDetails[$data->id]['amount'];
					}
					else return 'NA';
				}
				),
			array(
				'header' => 'Credit Repaid',
				'type' => 'raw',
				'value' => function($data){
					return CHtml::textField('creditRepaid[]','', array('style' => 'width:110.5px;'));
				},
				'footer' => '',),
			// array(
			// 	'header' => 'Payment Mode',
			// 	'id' => 'paymentMode',
			// 	'type' => 'raw',
			// 	'value' => function($data) use ($vendorPayment){
			// 		return Chtml::dropDownList('paymentType[]',$vendorPayment,
			// 					VendorPayment::vendorPaymentTypes(),
			// 					array('empty' => '--Payment Mode--') 
			// 					);
			// 	},
			// 	'footer'=>'',),
			// array(
			// 	'header' => 'Cheque Cleared',
			// 	'id' => 'chequeCleared',
			// 	'type' => 'raw',
			// 	'value' => function($data) use ($vendorPayment){
			// 		return CHtml::dropDownList('chequeStatus[]', $vendorPayment, VendorPayment::getChequeStatus(),
			// 			array('empty' => "--Status--"));
			// 	},
			// 	'footer'=>'',
			// 	),
			array(
				'header' => 'Create Payment',
				'type' => 'raw',
				'value' => function($data){
					return CHtml::link('Payment', array('vendorPayment/create', 'vendor_id' => $data->id), array('target' => '_blank'));
				},
				'footer'=>'',
				),
			array(
				'header' => 'Ledger',
				'type' => 'raw',
				'value' => function($data){
					return CHtml::link('Ledger', array('vendor/vendorLedger', 'vendor_id' => $data->id), array('target' => '_blank'));
				},
				'footer'=>'',
				),
			array(
				'type'=> 'raw',
				'value' => function($data){
					return CHtml::hiddenField('vendorIds[]',$data->id);
				},
				'footer'=>'',
				),
			)
		)
);

?>
<div class="row buttons">
	<?php echo CHtml::submitButton('Save', array('name' => 'Payment')); ?>
</div>

</form>