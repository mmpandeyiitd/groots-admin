<?php
/* @var $this GrootsLedgerController */
/* @var $model GrootsLedger */

$this->breadcrumbs=array(
    'Groots Ledgers'=>array('index'),
    'Manage',
);

/*$this->menu=array(
    array('label'=>'List GrootsLedger', 'url'=>array('index')),
    array('label'=>'Create GrootsLedger', 'url'=>array('create')),
);
*/

?>

<h1>Manage Groots Ledgers</h1>

<?php

    echo CHtml::button("Get Today's Collection", array('onclick' => 'document.location.href="index.php?r=Grootsledger/dailyCollection"'));
    echo "<br>";
    echo "<br>";
    echo "<br>";
    

    $this->widget('RetailerDropdown', array(
        'model'=>$model,
        'retailerId'=>$retailer->id,
    ));

//var_dump($data);die;
if(isset($retailer->id)) {
    echo CHtml::link('<u>Create Payment</u>', array('Grootsledger/CreatePayment', 'retailerId' => $retailer->id));
}
if(!empty($data)) {
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => '',
        'dataProvider' => $data,
        //'filter' => $data,
        'columns' => array(
            'id',
            'date',
            'type',
            array(
                'header' => 'payment_type',
                'value' => function($data){
                    if(isset($data['payment_type'])){
                    if($data['payment_type'] == trim('Cheque')  || $data['payment_type'] == trim('Debit Note') && $data['cheque_no'] != null)
                        return $data['payment_type'].' : '.$data['cheque_no'];
                    else 
                        return $data['payment_type'];
                }
                else 
                   return '';
           }

                ),
            //'payment_type',
            'invoiceAmount',
            'paymentAmount',
            'outstanding',
            'link' => array(
                'header' => 'Action',
                'headerHtmlOptions' => array('style' => 'color:#1d2e7b;'),
                'type' => 'raw',
                'value' => 'CHtml::button("Update",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl($data["update_url"],array("id"=>$data["id"]))."\'"))',
            )
        ),
    ));
}

?>
