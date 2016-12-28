<?php
$this->breadcrumbs=array(
    'Groots Ledger'=>array('admin&w_id='.$w_id),
  'Daily Collection',
);
echo "Total Payable Amount = ".$amount_to_be_collected;
echo "<br>";
echo "Total Amount Paid Yesterday = ".$total_paid_yesterday;
echo "<br>";
echo "Total Due Payable Amount = ".$total_due_amount.'<br>';
echo "Total Due Payable Amount Yesterday = ".$due_payable_amount_yesterday;
?>

<!--<form name="myform" method="post" action="<?php /*echo Yii::app()->getBaseUrl().'/index.php?r=Grootsledger/dailyCollection';*/?>">-->
<form name="myform" method="post" action="<?php echo Yii::app()->getBaseUrl().'/index.php?r=Grootsledger/dailyCollection&w_id='.$w_id;?>">
<h1> Daily Collection </h1>
<?php 
$base_url = Yii::app()->getBaseUrl(true);
//echo $base_url;
//die;
?>

 <div align = "right"><?php echo CHtml::submitButton('UPDATE', array('name'=>'update')); ?> </div>
 <div>
<!-- <a href=<?php /*echo $base_url;*/?>?r=Grootsledger/dailyCollection&download=true>Download Daily Report</a>-->
     <a href=<?php echo $base_url."?r=Grootsledger/dailyCollection&download=true&w_id=".$w_id; ?>> Download Daily Report</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<!-- <a href=<?php /*echo $base_url;*/?>?r=Grootsledger/dailyCollection&downloadPending=true>Download Non Daily Reports</a>-->
     <a href=<?php echo $base_url."?r=Grootsledger/dailyCollection&downloadPending=true&w_id=".$w_id; ?>> Download Non Daily Reports</a>
</div>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'id',
		'dataProvider'=> $data,
		'columns' => array(
			'id',
			'name',
      'collection_frequency',
      'collection_agent',
      'collection_center',
			'total_payable_amount',
			'todays_order_amount', 
      'yesterday_payment_received', 
			//'warehouse',
          array(
            'value' => function($data){
              return CHtml::textField('collected_amount[]', '' , array('class' => 'inputs','style' => 'width:100px;'));
            },
            'header' => 'collection',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'width: 5%'),
            ),
			
      			array(
        		'value'=> function($data) use ($w_id) {
        			return CHtml::link('<u>Create Payment</u>', array('Grootsledger/CreatePayment',
                        'retailerId' => $data['id'], 'w_id'=>$w_id),array('target'=>'_blank'));
        		},
        		'header' => 'Payment Link',
        		'type' => 'raw',
        		'htmlOptions'=>array('width'=>'120px','target'=>"_blank"),
        	),
           array(
            'value' => function($data){
              return CHtml::hiddenField("retailer_id[]",$data['id']);
            },
            'type' => 'raw',
            'htmlOptions' => array('width'=>'0px'),
            ),
			
		),
	)
);
?>


<script type="text/javascript">
$(document).ready(function() {
 $('.inputs').keydown(function (e) {
            if (e.which === 13) {
                var index = $('.inputs').index(this);
                if(e.shiftKey){
                    $('.inputs').eq(index-1).focus();
                }
                else{
                    $('.inputs').eq(index+1).focus();
                }
                return false;
            }
        });

 $('.readOnlyInput').keydown(function (e) {
            if (e.which === 13) {
                return false;
            }
        });
});
</script>
<br><br>
<h1> Non Daily Collection </h1>

<div align = "right"><?php echo CHtml::submitButton('UPDATE NON DAILY', array('name'=>'update2')); ?> </div>
<?php
  $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'prevDayPaymentUnfulfilled',
    'dataProvider'=> $data2,
    'columns' => array(
      'id',
      'name',
      'collection_frequency',
      'collection_agent',
      'collection_center',
      'total_payable_amount',
      'due_payable_amount',
      //'todays_order_amount',
      'last_due_date',
       'last_paid_amount',
       'last_paid_on',
       array(
            'value' => function($data2){
              return CHtml::textField('pending_collection[]', '' , array('class' => 'inputs','style' => 'width:100px;'));
            },
            'header' => 'collection',
            'type' => 'raw',
            'htmlOptions' => array('width' => '5%'),
            ),
      'warehouse',
      array(
            'value'=> function($data2) use ($w_id) {
              return CHtml::link('<u>Create Payment</u>', array('Grootsledger/CreatePayment',
                  'retailerId' => $data2['id'], 'w_id'=>$w_id),array('target'=>'_blank'));
            },
            'header' => 'Payment Link',
            'type' => 'raw',
            'htmlOptions'=>array('width'=>'120px','target'=>"_blank"),
          ),
      array(
            'value' => function($data2){
              return CHtml::hiddenField("pending_retailer_id[]",$data2['id']);
            },
            'type' => 'raw',
            'htmlOptions' => array('width'=>'0px'),
            ),
    ),
  )
);


?>

<div>
<?php echo "<br>" ?>
<!--<a href="index.php?r=Grootsledger/admin" class="button_new" style="width: auto;" target="_blank"  >Back</a>-->
    <a href="index.php?r=Grootsledger/admin&w_id=<?php echo $w_id;?>" class="button_new" style="width: auto;" target="_blank"  >Back</a>
</div>


</form>