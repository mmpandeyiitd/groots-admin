<?php
$this->menu=array(
    array('label'=>'Manage Vendor', 'url'=>array('admin')),
    array('label' => 'Vendor Payment' , 'url' => array('vendorPayment/admin')),
);
?>

<form name="dateSelector" method="post" action="<?php echo Yii::app()->getBaseUrl().'/index.php?r=vendor/creditManagement';?>">

<?php if (Yii::app()->user->hasFlash('premission_info')): ?>
	<span class="Csv" style="color:red">
        <?php echo Yii::app()->user->getFlash('premission_info'); ?>
    </span>
<?php endif; ?>

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

echo '<br>';
echo CHtml::submitButton('Download Credit Report', array('name' => 'downloadReport' ,'style' => 'height:30px;'));
?>
</form>

<span style = "color:#F2391C;"> <b>Create Only Cash Payments Here. For Other Payment Modes Click The <u>Payment</u> link </b></span>
<form name="credit" method="post" action="<?php echo Yii::app()->getBaseUrl().'/index.php?r=vendor/creditManagement&date='.$vendorPayment->date;?>">
<?php
$totalPayable = 0;
$totalPending = 0;
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
				),
			array(
				'header' => 'Name',
				'name' => 'name',
				'value' => '$data->name',
				),
            array(
                'header' => 'Bussiness Name',
                'name' => 'bussiness_name',
                'value' => '$data->bussiness_name',
            ),
			array(
				'header' => 'Vendor Type',
				'name' => 'vendor_type',
				'value' => '$data->vendor_type',
				),
			'credit_limit',
			//'vendor_type',
			array(
				'header' => 'Sku Served',
				'type' => 'raw',
				'value' => function($data) use ($skuMap){
				return CHtml::dropDownList( 'sku[]' , '',(empty($skuMap[$data->id]) ? array() : $skuMap[$data->id]), array('empty' => "SKU's Served", 'style' => 'width:130px;' ));
				},
				),
			array(
				'header' => 'Total Pending',
				'type' => 'raw',
				'value' => function($data) use ($totalPendingMap, $initialPendingMap, &$totalPending){
					if(array_key_exists($data->id, $totalPendingMap)){
						$temp = $totalPendingMap[$data->id] + $initialPendingMap[$data->id];
					}
					else {
						$temp = $initialPendingMap[$data->id];
					}
					$totalPending += $temp;
					return $temp;
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
				),
			array(
				'header' => 'Previous Due Date',
				'type' => 'raw',
				'value' => function($data) use ($payable){
					return $payable[$data->id]['lastDueDate'];
				},
				),
			array(
				'header' => 'Amount Payable',
				'value' => function($data) use ($payable, $initialPendingMap, &$totalPayable){
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
					$temp = ($temp > 0) ? $temp : 0;
					$totalPayable += $temp;
					//$payable['total'] -= $data->credit_limit;
					return $temp;

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
		 	),
			array(
				'header' => 'Create Payment',
				'type' => 'raw',
				'value' => function($data){
					return CHtml::link('Payment', array('vendorPayment/create', 'vendor_id' => $data->id), array('target' => '_blank'));
				},
				),
			array(
				'header' => 'Ledger',
				'type' => 'raw',
				'value' => function($data){
					return CHtml::link('Ledger', array('vendor/vendorLedger', 'vendor_id' => $data->id), array('target' => '_blank'));
				},
				),
			array(
				'type'=> 'raw',
				'value' => function($data){
					return CHtml::hiddenField('vendorIds[]',$data->id);
				},
				),
			)
		)
);

echo 'Total Pending : '.$totalPending.'<br>';
echo 'Total Payable : '.$totalPayable;
?>
<div class="row buttons">
	<?php echo CHtml::submitButton('Save', array('name' => 'Payment')); ?>
</div>

</form>