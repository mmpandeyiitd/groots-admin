<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 29/12/16
 * Time: 3:17 PM
 */

$this->breadcrumbs=array(
    'Inventory'=>array('create&w_id='.$w_id),
    'BulkUpload',
);

/*$this->menu=array(
    //array('label'=>'List Inventory', 'url'=>array('admin&w_id='.$w_id)),
    //array('label'=>'Manage Inventory', 'url'=>array('admin')),
    array('label'=>'EDIT INVENTORY', 'url'=>array('inventoryHeader/editInventory&w_id='.$w_id)),
    array('label'=>'BULK UPLOAD', 'url'=>array('inventory/bulkUpload&w_id='.$w_id)),
);*/

?>
<div class="" >
<div class="portlet-content">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'inventory-update-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),));


 ?>


    <div class="bulk_center" >

    <div class="portlet-content">

        <div >
            <div class="span12">

            <?php
            if(!empty($csv_filename)){ ?>
               <div class="row" id="logfile" >
                        To view logs of recently uploaded Inventory click : <a id='loglink' target='_blank' href='<?php echo $csv_filename; ?>'>Bulk Upload Inventory Log File

                        </a>
                    </div> 
            <?php } 
            ?>

                <!--<div class="bulkupload_btn">

                    <?php /*echo CHtml::button('Download Template For Update', array('onclick' => 'js:document.location.href="index.php?r=inventory/UpdateFileDownload&w_id=$w_id"',)); */?>
                    <br>
                </div>-->


                <div class="row">
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
                    <?php
                    $url = Yii::app()->controller->createUrl("Inventory/UpdateFileDownload",array('w_id' => $w_id));
                    echo CHtml::submitButton('Download Bulk Upload File', array('name'=>'inventory-date', 'onclick' => "onClickDate('".$url."')"));

                    ?>
                </div>


                <div>
                    <?php echo $form->labelEx($model, 'csv_file'); ?>
                    <?php echo $form->fileField($model, 'csv_file',array('size' => 150, 'maxlength' => 300)); ?>
                    <?php echo $form->error($model, 'csv_file'); ?>
                </div>
                <div style="clear:both;"></div>
                <!--<div>
                    <?php /*echo $form->dropDownList($model, 'action', array('create' => 'Create', 'update' => 'Update')); */?>
                    <?php /*echo $form->error($model, 'csv_file'); */?>
                </div>-->
                <div class="buttons">
                    <?php echo CHtml::submitButton('Upload', array("class" => "Bulk btn")); ?>
                    <?php echo $form->errorSummary($model); ?><div class="Csv">
                        <?php echo '<br />'; ?>
                    </div>
                </div>
            </div>
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
        </div>

    </div>

<?php
$this->endWidget();
?>

        <script type="text/javascript">
            function onClickDate(url){
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