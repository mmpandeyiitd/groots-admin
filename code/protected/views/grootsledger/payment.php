<?php
/* @var $this GrootsLedgerController */
/* @var $model GrootsLedger */

$this->breadcrumbs=array(
    'Groots Ledgers'=>array('index'),
    'Payment',
);

if(isset($update) && ($update == true)){
    $update = true;
    $title = "Update a Payment";
}
else{
    $update = false;
    $title = "Create a Payment";
}
/*$this->menu=array(
    array('label'=>'List GrootsLedger', 'url'=>array('index')),
    array('label'=>'Create GrootsLedger', 'url'=>array('create')),
);*/


?>

<h1><?php echo $title;?></h1>


<?php


echo $this->renderPartial('_payment_form', array(
    'model'=>$model,
    'update'=>$update,
    'w_id' => $w_id,
));
?>


