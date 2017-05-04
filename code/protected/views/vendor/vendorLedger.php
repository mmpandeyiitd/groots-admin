<?php
$this->menu=array(
    array('label'=>'Manage Vendor', 'url'=>array('admin')),
    array('label' => 'Credit Management', 'url' => array('creditManagement')),
    array('label' => 'Vendor Payment' , 'url' => array('vendorPayment/admin')),
);
 
?>
<form name="myform" method="post" action="<?php echo Yii::app()->getBaseUrl().'/index.php?r=vendor/vendorLedger&vendor_id='.$vendor->id;?>">
<h1 style = "color:#003300;">Vendor Ledger</h1>
<br>
<br>
<h4>
	Name : <?php echo $vendor->name; ?></br>
    Bussiness Name : <?php echo $vendor->bussiness_name;?></br>
    Id: <?php echo $vendor->id; ?></br>
    InitialPayableAmount <?php echo VendorDao::getVendorInitialPendingAmount($vendor->id); ?>
</h4>

<?php if (Yii::app()->user->hasFlash('premission_info')): ?>
	<span class="Csv" style="color:red">
        <?php echo Yii::app()->user->getFlash('premission_info'); ?>
    </span>
<?php endif; ?>

<?php
echo CHtml::submitButton('Download Ledger', array('name'=>'ledgerDownload'));
echo CHtml::button('Upload Files', array('submit' => array('vendor/vendorS3Upload&vendor_id='.$vendor->id)));
?>

    <div class="dashboard-table">
        <form method="post">
            <h4 style="width:20%">balance confirmation</h4>
            <div class="right_date" style="width:80%">
                <label>Date</label>
                <?php

                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    // 'model' => $model,
                    'name' => 'balance_date',
                    'attribute' => 'balance_date',
                    //'value' => $model->created_at,
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'showAnim' => 'fold',
                        'debug' => true,
                        //'maxDate' => "60",
                    ), //DateTimePicker options
                    'htmlOptions' => array('readonly' => 'true'),
                ));
                //echo $form->error($model, 'created_at');
                ?>


                <?php


                ?>

                <input name="balance_template" class="button_new" type="submit" value="Download" />

            </div>
        </form>

    </div>


    <?php
    $labourVisible = ($vendor->id == 4);
$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'ledger-grid',   
		'itemsCssClass' => 'table table-striped table-bordered table-hover',
		'dataProvider'=> $dataProvider,
		'columns' => array(
			'id',
			'date',
			'paid_amount',
            'payment_type',
            'cheque_status',
            array(
                'header'=>'Labour Cost',
                'type' => 'raw',
                'visible' => $labourVisible,
                'value' => function($data){
                    echo $data['labour_cost'];
                }
            ),
            'order_amount',
			'order_quantity',
			'outstanding',
			array(
				'header' => 'Invoice',
				'type'=>'raw',
				'value' => function($data) use ($vendor){
					if($data['type'] == "Order"){
						return CHtml::button('Invoice', array('submit' => 'index.php?r=vendor/invoice&vendorId='.$vendor->id.'&purchaseId='.$data['id']));
					}
					else return '';
				}
				)
				),
		));
?>
</form>