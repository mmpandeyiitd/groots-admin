<div class="" >  
<div class="portlet-content">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'registration-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),));

/*$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 1) {
    if (!(isset($_GET['store_id'])) || (empty($_GET['store_id']))) {
        $this->redirect(array('site/logout'));
    }
    $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_admin_id'] != $store_id) {
        $this->redirect(array('site/logout'));
    }
    $store_name = Store::model()->getstore_nameByid($store_id);
    $this->breadcrumbs = array(
        'Brand' => array('store/admin'),
        $store_name => array('store/update', "id" => $store_id),
        'Style' => array('admin', "store_id" => $store_id),
        'Bulk Upload Styles',
    );
} else {
    $store_id = Yii::app()->session['brand_id'];
    $this->breadcrumbs = array(
        'Styles' => array('admin'),
        'Bulk Upload Styles',
    );
}*/
 ?>


    <div class="bulk_center" >

<div class="portlet-content">
 
<div >
    <div class="span12">

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="row" id="logfile" >
        To view logs of recently uploaded product click : <a id='loglink' target='_blank' href='log/<?php echo $logfile; ?>'>Bulk Upload product Log File

        </a>
        </div>
<?php endif; ?>
<div class="bulkupload_btn">
    <?php echo CHtml::button('Download Template For Create', array('onclick' => 'js:document.location.href="index.php?r=baseProduct/CreateFileDownload"')); ?>
    <?php echo CHtml::button('Download Template For Update', array('onclick' => 'js:document.location.href="index.php?r=baseProduct/UpdateFileDownload"',)); ?>
    <br>
</div>
<div>
    <?php echo $form->labelEx($model, 'csv_file'); ?>
    <?php echo $form->fileField($model, 'csv_file'); ?>
    <?php echo $form->error($model, 'csv_file'); ?>
</div>
<div style="clear:both;"></div>
<div>
    <?php echo $form->dropDownList($model, 'action', array('create' => 'Create', 'update' => 'Update')); ?>
    <?php echo $form->error($model, 'csv_file'); ?>
</div>
<div class="buttons">
<?php echo CHtml::submitButton('Upload & Import', array("class" => "Bulk btn")); ?>
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