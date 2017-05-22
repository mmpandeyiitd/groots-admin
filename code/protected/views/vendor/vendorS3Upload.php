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
    echo CHtml::label('Vendor', 'vendor_id');
    echo CHtml::dropDownList('vendor_id', (!empty($vendor_id)? $vendor_id:0),VendorDao::allVendorDropDown(), array('style' => 'width:220.5px;'));
    echo '<br>'.'Select Date'.'<br>';
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
    echo CHtml::label('File Type', 'file_type');
    echo CHtml::dropDownList('file_type', 0,VendorDao::fileTypesDd(), array('style' => 'width:220.5px;'));
    echo $vendor_id.'<br>';
    echo CHtml::fileField('file');
    echo CHtml::submitButton('Submit', array('name' => 'addFile'));
    $fileNames = '';

    //if(!empty($vendor_id)){
        $this->widget('zii.widgets.grid.CGridView', array(
            'itemsCssClass' => 'table table-striped table-bordered table-hover',
            'id' => 'order-header-grid',
            'dataProvider' => $model->search($vendor_id),
            'filter' => $model,
            'columns' => array(
                'id',
                'bussiness_name',
                'date',
                'file_tag',
                'file_name',
                'file_type',
                array(
                    'header'=> 'File Link',
                    'type' => 'raw',
                    'value' => function($data){
                        return CHtml::link('Link to file', $data->file_link, array('target' => '_blank'));
                    }),
                array(
                    'header' => 'Delete',
                    'type' => 'raw',
                    'value' => function($data, $fileNames){
                        echo CHtml::checkBox('checkedId_'.$data->id, false, array('onclick' => "onCbStateChange("."'".$data->file_tag."'".",".$data->id.")"));
                    }
                ),
                array(
                    'type' => 'raw',
                    'value' => function($data){
                        return CHtml::hiddenField('file_id[]', $data->id);
                    }
                ),
                 array(
                     'type' => 'raw',
                     'value' => function($data){
                         return CHtml::hiddenField('file_name[]', $data->file_name);
                     }
                 )
            ),
        ));
   // }

    echo CHtml::submitButton('Delete File', array('name' => 'deleteFile','onclick' => 'onFileDeleteClick()'));
    ?>
</form>

<script type="text/javascript">
    var fileNames = '';
    function onCbStateChange(fileTag,id){
        var isChecked = $("#checkedId_"+id).is(':checked');
        console.log(isChecked);
        if(isChecked){
            fileNames += fileTag + ' , ';
            //alert('Are you sure you want to delete this file : '+fileTag);
        }
    }

    function onFileDeleteClick(){
        alert('Are you sure you want to delete this file : '+fileNames);
    }
</script>
