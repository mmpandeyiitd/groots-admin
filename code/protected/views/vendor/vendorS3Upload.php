<?php
$this->breadcrumbs=array(
'Vendors'=>array('admin'),
'Manage',
);

$this->menu=array(
//array('label'=>'List Vendor', 'url'=>array('index')),
//array('label'=>'Create Vendor', 'url'=>array('create')),
array('label' => 'Credit Management', 'url' => array('creditManagement')),
array('label' => 'Vendor Payment' , 'url' => array('vendorPayment/admin')),
//array('label' => 'Vendor Upload', 'url' => array('vendorS3Upload')),
);
?>

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
<?php
if(!empty($vendor_id)) {
    $vendor = Vendor::model()->findByPk($vendor_id);
?>
<h4><?php echo $vendor->bussiness_name.'<br>';}?></h4>
<form name="myform" method="post" enctype="multipart/form-data" action="<?php echo Yii::app()->getBaseUrl().'/index.php?r=vendor/vendorS3Upload';?>">
    <?php
    $fileTypes = array('0' =>'Select File Type', 'Document'=>'Document', 'Image' => 'Image', 'Presentation'=>'Presentation','Excel'=>'Excel','Adobe' => "Adobe");
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
    echo '<br>';
    echo CHtml::label('File Tag', 'fileTag');
    echo CHtml::textField('fileTag','',array('style' => 'width:220.5px;'));
    echo CHtml::dropDownList('vendor_id', (!empty($vendor_id)? $vendor_id:0),VendorDao::allVendorDropDown(), array('style' => 'width:220.5px;'));
    echo CHtml::dropDownList('file_type', 0,$fileTypes, array('style' => 'width:220.5px;'));
    echo CHtml::fileField('file');
    echo CHtml::submitButton('Submit', array('name' => 'addFile'));

    if(!empty($vendor_id)){
        $this->widget('zii.widgets.grid.CGridView', array(
            'itemsCssClass' => 'table table-striped table-bordered table-hover',
            'id' => 'order-header-grid',
            'dataProvider' => $model->search($vendor_id),
            'filter' => $model,
            'columns' => array(
                'id',
                'date',
                'file_tag',
                'file_name',
                'file_type',
                array(
                    'header'=> 'File Link',
                    'type' => 'raw',
                    'value' => function($data){
                        return CHtml::link('Link to file', $data->file_link);
                    }),


            )
        ));
    }

    ?>

</form>
