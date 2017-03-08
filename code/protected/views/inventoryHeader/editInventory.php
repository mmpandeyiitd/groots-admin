<?php
$w_id = '';
if(isset($_GET)){
 $w_id = $_GET['w_id'];
}
?>

<form name = 'inventrotyHeader' method = 'POST' action="<?php echo Yii::app()->getBaseUrl().'/index.php?r=inventoryHeader/editInventory&w_id='.$w_id?>">
<?php 
$this->breadcrumbs=array(
	' Create Inventory'=>array('create'),
	'Edit Inventory',
);
?>

<div align = "right"><?php echo CHtml::submitButton('UPDATE', array('name'=>'update')); ?> </div>
<?php


$this->widget('zii.widgets.grid.CGridView', array(
	'itemsCssClass' => 'table table-striped table-bordered table-hover',
	'id' => 'id',
	'dataProvider' => $data,
	'filter' => $model,
	'columns' => array(
		'item_title',
		'base_product_id',
		array(
                'header' => 'Schedule Inv',
                'value' => function ($data) {
                    return CHtml::textField('schedule_inv[]', $data->schedule_inv, array('style'=>'width:100px;'));
                },
                'type' => 'raw',
            ),
		array(
				'header' => 'Schedule Inv Type',
				'value' => function($data,$model){
					return CHtml::dropDownList('schedule_inv_type[]', $model	, CHtml::listData(InventoryHeader::scheduleInvType(),'value' ,'value'),
       						array('options' => array($data->schedule_inv_type=>array('selected'=>true)), 'style' => 'float:right; width:100px;')
						);
				},
				'type'=>'raw',
			),
		array(
                'header' => 'Extra Inv',
                'value' => function ($data) {
                    return CHtml::textField('extra_inv[]', $data->extra_inv, array('style'=>'width:100px;'));
                },
                'type' => 'raw',
            ),
		array(
				'header' => 'Extra Inv Type',
				'value' => function($data,$model){
					return CHtml::dropDownList('extra_inv_type[]', $model	, CHtml::listData(InventoryHeader::extraInvType(),'value'	,'value'),
       						array('options' => array($data->extra_inv_type=>array('selected'=>true)), 'style' => 'float:right;')
       						);
				},
				'type'=>'raw',
			),
		 array(
            'value' => function($data){
              return CHtml::hiddenField("id[]",$data->id);
            },
            'type' => 'raw',
            ),
		),
	)
);
echo '<a href="index.php?r=inventory/create&w_id='.$w_id.'"'.' class="button_new" style="width: auto;" target="_blank"  >Back</a>';
?>
</form>