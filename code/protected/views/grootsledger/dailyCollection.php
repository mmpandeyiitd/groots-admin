<form name="myform" method="post" action="<?php echo Yii::app()->getBaseUrl().'/index.php?r=Grootsledger/dailyCollection';?>">
<h1> Daily Collection </h1>
<?php 
$base_url = Yii::app()->getBaseUrl(true);

 // echo CHtml::link("Download", array('onclick' => 'document.location.href="index.php?r=Grootsledger/dailyCollection&download=true"'),
 // 	array('target' => '_blank'));
?>
 <div>
 <a href=<?php echo $base_url;?>?r=Grootsledger/dailyCollection&download=true>Download</a>
</div>

<?php  
	echo "<br>";
	echo "<br>";
	echo CHtml::submitButton('update',array('name' => 'update')); 
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'id',
		'dataProvider'=> $data,
		'columns' => array(
			'name',
			'amount',
			'warehouse',
			
			array(
        		'header'=>'collected_amount',
        		'value'=>'CHTML::textField("amount[]")',
        		'type'=>'raw',
        		'htmlOptions'=>array('width'=>'25px'),
        	),

			array(
        		'value'=> function($data){
        			return CHTML::hiddenField("retailer_id[]",$data['id']);
        		},
        		
        		'type'=>'raw',
        		'htmlOptions'=>array('width'=>'25px'),
        	),
		),
	)
);
//var_dump();
?>
</form>