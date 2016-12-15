<form name="myform" method="post" action="<?php echo Yii::app()->getBaseUrl().'/index.php?r=vendor/creditManagement';?>">

<?php
echo CHtml::label('Select date', 'date');
$this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$vendorPayment,
            'attribute'=>'date',

            'id'=>'date',
            'value'=> date('Y-m-d'),
            'options'=>array(
                'dateFormat' => 'yy-mm-dd',
                'showAnim'=>'fold',
            ),
            'htmlOptions'=>array(
                'style'=>'height:20px;'
            ),
        ));
echo CHtml::button('Submit', array('submit' => array('vendor/creditManagement')));

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
				return CHtml::dropDownList( 'sku' , '',(empty($skuMap[$data->id]) ? array() : $skuMap[$data->id]), array('empty' => "SKU's Served", 'style' => 'width:130px;' ));
				}),
			'total_pending_amount',
			array(
				'header' => 'Payment Due Date',
				'type' => 'raw',
				'value' => function(){
					return date('Y-m-d');}
					,
				),
			array(
				'header' => 'Amount Payable',
				'value' => '0.00',
				),
			array(
				'header' => 'Credit Repaid',
				'type' => 'raw',
				'value' => function($data){
					return CHtml::textField('creditRepaid[]','', array('style' => 'width:110.5px;'));
				}),
			array(
				'header' => 'Payment Mode',
				'id' => 'paymentMode',
				'type' => 'raw',
				'value' => function($data) use ($vendorPayment){
					return Chtml::dropDownList('paymentType[]',$vendorPayment,
								CHtml::listData(VendorPayment::vendorPaymentTypes(),'value', 'value'),
								array('empty' => '--Payment Mode--') 
								);
				}),
			array(
				'header' => 'Cheque Cleared',
				'id' => 'chequeCleared',
				'type' => 'raw',
				'value' => function($data) use ($vendorPayment){
					return CHtml::dropDownList('chequeStatus[]', $vendorPayment, CHtml::listData(VendorPayment::getChequeStatus(), 'value', 'value'),
						array('empty' => "--Status--"));
				}
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

?>

</form>