<?php if (Yii::app()->user->hasFlash('premission_info')): ?><div class="errorSummary"><?php echo Yii::app()->user->getFlash('premission_info'); ?></div><?php endif; ?>
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="Csv" style="color:green;">
        <?php echo Yii::app()->user->getFlash('success'); ?>
        <?php echo Yii::app()->user->getFlash('prod'); ?>
    </div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="Csv" style="color:red;">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>
<form name="myform" method="post" enctype="multipart/form-data" action="<?php echo Yii::app()->getBaseUrl().'/index.php?r=vendor/vendorS3Upload';?>">
    <?php
    $fileTypes = array('0' =>'Select File Type', 'pdf'=>'pdf', 'doc' => 'doc', 'csv'=>'csv','xlxs'=>'xlxs');
    echo 'Select Date';
    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
        //'model'=>$vendor,
        'name' => 'date',
        'attribute'=>'date',
        //'value' => $vendorPayment->date,
        'id'=>'date',
        'options'=>array(
            'dateFormat' => 'yy-mm-dd',
            'showAnim'=>'fold',
        ),
        'htmlOptions'=>array(
            'style'=>'height:20px;'
        ),
    ));
    echo CHtml::dropDownList('vendor_list', 0,VendorDao::allVendorDropDown(), array('style' => 'width:220.5px;'));
    echo CHtml::dropDownList('file_type', 0,$fileTypes, array('style' => 'width:220.5px;'));
    echo CHtml::fileField('file');
    echo CHtml::submitButton('Submit', array('name' => 'addFile'));
    ?>

</form>
