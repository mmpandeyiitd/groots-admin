<?php
/* @var $this GrootsLedgerController */
/* @var $model GrootsLedger */

$this->breadcrumbs=array(
    //'Groots Ledgers'=>array('index'),
    'Manage',
);

/*$this->menu=array(
    array('label'=>'List GrootsLedger', 'url'=>array('index')),
    array('label'=>'Create GrootsLedger', 'url'=>array('create')),
);
*/

?>
<div>
<h1>Manage Groots Ledgers</h1>

    <div>
        <?php
        echo "<br>";
        //echo CHtml::button("Get Today's Collection", array('onclick' => 'document.location.href="index.php?r=Grootsledger/dailyCollection"'));
        $url = "index.php?r=Grootsledger/dailyCollection&w_id=".$w_id;
        echo CHtml::button("Get Today's Collection", array('onclick' => 'document.location.href="'.$url.'"'));
        echo "<br>";
          ?>
        </div>
    </div>
<?php

    $this->widget('RetailerDropdown', array(
        'model'=>$model,
        'retailerId'=>$retailer->id,
        'showInactive' => true,
    ));

//var_dump($data);die;
if(isset($retailer->id)) {
    echo CHtml::link('<u>Create Payment</u>', array('Grootsledger/CreatePayment', 'retailerId' => $retailer->id, 'w_id' => $w_id));

    if(!empty($data)) {
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => '',
            'dataProvider' => $data,
            //'filter' => $data,
            'columns' => array(
                'id',
                'date',
                'type',
                'retailer_status',
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
                    'value' => function($data) use ($w_id){
                        $url = Yii::app()->controller->createUrl($data["update_url"],array("id"=>$data["id"],"w_id"=>$w_id));
                        return CHtml::button("Update",array("onclick"=>"document.location.href='".$url."'"));
                    },
                    /*'value' => 'CHtml::button("Update",array("onclick"=>"document.location.href=\'".Yii::app()->controller->createUrl($data["update_url"],array("id"=>$data["id"],"w_id"=>$w_id))."\'"))',*/
                )
            ),
        ));
    }
}

?>
