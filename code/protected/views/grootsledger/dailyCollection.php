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

<!-- <?php  
	echo "<br>";
	echo "<br>";
	echo CHtml::submitButton('update',array('name' => 'update')); 

?>	 -->

<!-- <script type="text/javascript">
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
</script> -->

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
			
			// array(
   //      		'header'=>'payment_link',
   //      		'class' => 'CLinkColumn',
   //      		'label' => 'create_payment',
   //      		'urlExpression' => 'http://admin.groots.localhost.com/index.php?r=Grootsledger/CreatePayment&retailerId=".$data["id"]',
   //      	),
			array(
        		'value'=> function($data){
        			return CHtml::link('<u>Create Payment</u>', array('Grootsledger/CreatePayment', 
									'retailerId' => $data['id']),array('target'=>'_blank'));
        		},
        		'header' => 'Payment Link',
        		'type' => 'raw',
        		'htmlOptions'=>array('width'=>'120px','target'=>"_blank"),
        	),
			
			// array(
   //      		'value'=> function($data){
   //      			return CHTML::hiddenField("retailer_id[]",$data['id']);
   //      		},
        		
   //      		'type'=>'raw',
   //      		'htmlOptions'=>array('width'=>'25px'),
   //      	),
		),
	)
);
//var_dump($data); die();
?>
</form>