<?php
$this->menu=array(
    array('label'=>'Manage Vendor', 'url'=>array('admin')),
    array('label' => 'Credit Management', 'url' => array('creditManagement')),
    array('label' => 'Vendor Payment' , 'url' => array('vendorPayment/admin')),
);
 
?>
<h1 style = "color:#003300;">Vendor Ledger</h1>
<br>
<h4>
	Name : <?php echo $vendor->name; ?></br>
    Bussiness Name : <?php echo $vendor->bussiness_name;?></br>
	Id: <?php echo $vendor->id; ?>
</h4>

<?php if (Yii::app()->user->hasFlash('premission_info')): ?>
	<span class="Csv" style="color:red">
        <?php echo Yii::app()->user->getFlash('premission_info'); ?>
    </span>
<?php endif; ?>

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
			array(
				'header' => 'Invoice',
				'type'=>'raw',
				'value' => function($data) use ($vendor){
					if(isset($data['purchase_id']) && !empty($data['purchase_id'])){
						return CHtml::button('Invoice', array('submit' => 'index.php?r=vendor/invoice&vendorId='.$vendor->id.'&purchaseId='.$data['purchase_id']));
					}
					else return '';
				}
				)
				),
		));
?>
