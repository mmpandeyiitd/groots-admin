<?php 
	$w_id = $_GET['w_id'];
	$form = $this->beginWidget('CActiveForm', array(
	'id' => 'inventory-update-form',
	'enableAjaxValidation' => true,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),));
?>
	<form name="myform" method="post" action="<?php echo Yii::app()->getBaseUrl().'/index.php?r=purchaseHeader/bulkUploadPurchase';?>">
		<div>
			<?php echo $form->labelEx($model,'date'); ?>
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'date',
				'value'=>$model->date,

				'id'=>'date',
                        //'value'=> date('Y-m-d'),
				'options'=>array(
					'dateFormat' => 'yy-mm-dd',
					'showAnim'=>'fold',
					),
				'htmlOptions'=>array(
					'style'=>'height:20px;'
					),
					)); ?>
					<?php echo $form->error($model,'date'); ?>
					<?php echo '<br />'.'<br>'; ?>
				</div>
				<div>
					<?php echo 'Download Create Purchase Template' ?>
					<?php $url = Yii::app()->controller->createUrl("purchaseHeader/downloadPurchaseTemplate&w_id=".$w_id); ?>
					<?php echo CHtml::button('Download Template', array('onClick'=>'onClickDate("'.$url.'")')); ?>
					<?php echo '<br />'.'<br>'; ?>

				</div>

				<div>
                    <?php echo $form->labelEx($model, 'csv_file'); ?>
                    <?php echo $form->fileField($model, 'csv_file',array('size' => 150, 'maxlength' => 300)); ?>
                    <?php echo $form->error($model, 'csv_file'); ?>
                </div>

				<div class="buttons">
                    <?php echo CHtml::submitButton('Upload', array("class" => "Bulk btn")); ?>
                    <?php echo $form->errorSummary($model); ?><div class="Csv">
                        <?php echo '<br />'; ?>
                    </div>
                </div>

				<?php
				$this->endWidget();
				?>
			<?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="Csv" style="color:green">
           	<?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
            <?php endif; ?>
        <?php if (Yii::app()->user->hasFlash('error')): ?>
       <span class="Csv" style="color:red">
        <?php echo Yii::app()->user->getFlash('error'); ?>
       </span>
        <?php endif; ?>
	</form>

<script type="text/javascript">

	function onClickDate(url){
		console.log('here');
		var date = $("#date").val().trim();
		if(!date){
			alert('Please Select Date');
			return false;
		}
		url = url + "&date="+date;
		console.log(url);
        //return false;
        window.open(url, '_blank');
    }

</script>