

<?php
$form=$this->beginWidget('CActiveForm', array(
        'id'=>'registration-form',
         'enableAjaxValidation'=>true,
             'htmlOptions' => array('enctype' => 'multipart/form-data'),
        )); 
?>

<h2>Bulk Upload SubscribedProduct</h2>
<?php if(Yii::app()->user->hasFlash('success')):?>
     <div class="row" id="logfile" >
		To view logs of recently uploaded SubscribedProduct click : <a id='loglink' target='_blank' href='log/<?php echo $logfile;?>'>Bulk Upload SubscribedProduct Log File
		
		</a>
	</div>
	<?php endif; ?>
<div class="form">
    <div class="row">
        <?php echo CHtml::button('Download Templete For Create', array('onclick' => 'js:document.location.href="index.php?r=SubscribedProduct/CreateFileDownload"', )); ?>
        <?php echo CHtml::button('Download Templete For Update', array('onclick' => 'js:document.location.href="index.php?r=SubscribedProduct/UpdateFileDownload"', )); ?>
    </div>
   <div>
        <?php echo $form->labelEx($model,'csv_file'); ?>
        <?php echo $form->fileField($model,'csv_file'); ?>
        <?php echo $form->error($model, 'csv_file'); ?>
    </div>
	<div>
        <?php echo $form->labelEx($model,'csv_file'); ?>
<?php echo $form->dropDownList($model, 'action', array('create' => 'Create', 'update' => 'Update')); ?>
        <?php echo $form->error($model, 'csv_file'); ?>
    </div>	
        <hr>
        <?php  echo CHtml::submitButton('Upload & Import',array("class"=>"Csv")); ?>
		
        <?php echo $form->errorSummary($model); ?>
        <?php echo '<br />';?>
        <?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="Csv" style="color:green">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
     <?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="Csv" style="color:red">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>
    </div>


    
<?php
        $this->endWidget();
        ?>