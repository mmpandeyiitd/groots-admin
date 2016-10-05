<form name="myform" method="post" action="<?php echo Yii::app()->getBaseUrl().'/index.php?r=Grootsledger/dailyCollection';?>">
<h1> Daily Collection </h1>
<?php 
$base_url = Yii::app()->getBaseUrl(true);

 // echo CHtml::link("Download", array('onclick' => 'document.location.href="index.php?r=Grootsledger/dailyCollection&download=true"'),
 // 	array('target' => '_blank'));
?>
 <div>
 <a href=<?php echo $base_url;?>?r=Grootsledger/dailyCollection&download=true>Download Daily Report</a>
 <br>
 <br>
 <a href=<?php echo $base_url;?>?r=Grootsledger/dailyCollection&downloadPending=true>Download Back Date Reports</a>

</div>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'id',
		'dataProvider'=> $data,
		'columns' => array(
			'id',
			'name',
			'payable_amount',
			'todays_order_amount',
			'warehouse',
			
      			array(
        		'value'=> function($data){
        			return CHtml::link('<u>Create Payment</u>', array('Grootsledger/CreatePayment', 
									'retailerId' => $data['id']),array('target'=>'_blank'));
        		},
        		'header' => 'Payment Link',
        		'type' => 'raw',
        		'htmlOptions'=>array('width'=>'120px','target'=>"_blank"),
        	),
			
		),
	)
);

//var_dump($data); die();
?>
<h1> Pending Collection </h1>

<?php
  //var_dump($data2);die();
  $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'prevDayPaymentUnfulfilled',
    'dataProvider'=> $data2,
    'columns' => array(
      'id',
      'retailer_name',
      'payable_amount',
      'todays_order',
      'last_due_date',
      'last_paid_on',
       'last_paid_amount',
      'warehouse',
    ),
  )
);

?>
</form>