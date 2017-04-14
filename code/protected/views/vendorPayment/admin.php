<?php
/* @var $this VendorPaymentController */
/* @var $model VendorPayment */

$this->breadcrumbs=array(
	//'Vendor Payments'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List VendorPayment', 'url'=>array('index')),
	//array('label'=>'Create VendorPayment', 'url'=>array('create')),
    array('label'=>'Create Vendor', 'url'=>array('vendor/create')),
    array('label' => 'Credit Management', 'url' => array('vendor/creditManagement')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#vendor-payment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Vendor Payments</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<div class="dashboard-table">
    <form method="post">
        <h4 style="width:20%">vendor payment</h4>
        <div class="right_date" style="width:80%">
            <label>From</label>
            <?php

            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                // 'model' => $model,
                'name' => 'payment_from',
                'attribute' => 'payment_from',
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


            <label>To</label>
            <?php

            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                //'model' => $model,
                'name' => 'payment_to',
                'attribute' => 'payment_to',
                //'value' => $model->inv_created_at,
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                    'debug' => true,
                    //'maxDate' => "60",
                ), //DateTimePicker options
                'htmlOptions' => array('readonly' => 'true'),
            ));

            ?>

            <input name="paymentReport" class="button_new" type="submit" value="Download" />

        </div>
    </form>

</div>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vendor-payment-grid',
	'dataProvider'=>$model->search(),
	'itemsCssClass' => 'table table-striped table-bordered table-hover',
	'filter'=>$model,
	'columns'=>array(
		'id',
		'vendor_id',
        'bussiness_name',
		'paid_amount',
		'date',
		'payment_type',
		'cheque_no',
        //'cheque_status',
        array(
            'header' => 'Cheque Status',
            'name' => 'cheque_status',
            'value' => function($data){
                if($data->payment_type == 'Cheque'){
                    return $data->cheque_status;
                }
                else{
                    return '';
                }
            }
        ),
		/*
		'debit_no',
		'cheque_date',
		'cheque_name',
		'transaction_id',
		'receiving_acc_no',
		'bank_name',
		'isfc_code',
		'acc_holder_name',
		'comment',
		'created_at',
		'updated_at',
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
			'template' => '{view}{update}',
		),
	),
)); ?>
