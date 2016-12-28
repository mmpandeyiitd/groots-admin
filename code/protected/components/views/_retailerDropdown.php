<?php
/* @var $this OrderHeaderController */
/* @var $model OrderHeader */
/* @var $form CActiveForm */
?>

<div class="form">

<?php
$w_id='';
if(isset($_GET['w_id'])){
	$w_id = $_GET['w_id'];
}
if($w_id == HD_OFFICE_WH_ID){
	unset($w_id);
}

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-header-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


 <div <?php if($update != '') echo "style='display:none;'" ?> >
	<?php echo $form->labelEx($model, '<b>Select a retailer</b>'); ?>
	<?php
	$disabled = "";
	$condition = "";
	$retailerQueryArr = array();
	if($update != '') {
		$disabled = "disabled";
	}
	if(!$showInactive){
		$condition = 'status != 0 and ';
	}
	if(isset($w_id) && $w_id>0){
		$retailerQueryArr = array('select'=>'id,name','order' => 'name', 'condition'=> $condition.' allocated_warehouse_id = '.$w_id. ' and status =1');
	}
	else{
		$retailerQueryArr = array('select'=>'id,name','order' => 'name', 'condition'=> $condition.' status=1');
	}
	    echo $form->dropDownList($model,
	      'user_id',
	      CHtml::listData(Retailer::model()->findAll($retailerQueryArr),'id','name'),
	      array('empty' => 'Select a retailer', 'name' => 'retailer-dd', 'disabled'=>$disabled, 'options'=>array($retailerId=>array('selected'=>'selected')))
	    );
	?>

    <?php
	if($update == '') {
		echo CHtml::submitButton('Get retailer products', array('name' => 'select-retailer'));
	}?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->