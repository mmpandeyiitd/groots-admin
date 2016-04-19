<?php
/* @var $this LookbookController */
/* @var $model Lookbook */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'lookbook-form',
        'focus' => '.error:first',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
//        'clientOptions' => array(
//            'validateOnSubmit' => true,
//        ),
    ));
    ?>


    <p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>
<?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-error" style="color: green;"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>
    <div class="">

        <div class="row">
            <?php echo $form->labelEx($model, 'Title *'); ?>
<?php echo $form->textField($model, 'headline', array('size' => 60, 'maxlength' => 255)); ?>
<?php echo $form->error($model, 'headline'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'desciption'); ?>
<?php echo $form->textArea($model, 'desciption', array('size' => 60, 'maxlength' => 255)); ?>
<?php echo $form->error($model, 'desciption'); ?>
        </div>

       
    </div>
    <div class="row" >
        <label for="Lookbook_status">Upload Image</label>
        <?php
//        $media = array();
//        $medialog=array();
//        $medialogcounter=0;
//        $media_type="image";
//        $pdf_type="pdf";
//        $type_page="lookbook";
//        if(!$model->isNewRecord){
//            $media = Lookbook::model()->getMediaByBrand($model->id,$media_type,$type_page);
//            $pdf = Lookbook::model()->getPDFByBrand($model->id,$pdf_type,$type_page);
//        }
        ?>
        <?php
        $this->widget('CMultiFileUpload', array(
            'name' => 'images',
            'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
            'duplicate' => 'Duplicate file!', // useful, i think
            'denied' => 'Invalid file type', // useful, i think
            'options' => array(
                'afterFileSelect' => 'function(e ,v ,m){
            var fileSize = e.files[0].size;
            if(fileSize>1024*1024*2){
            alert("Exceeds file upload limit 2MB");
            $("div.MultiFile-list div:last-child a.MultiFile-remove").click();
            }                     
            return true;
            }',
            ),
            'max' => 1, //max 5 files allowed
        ));
        ?>

<?php if (!$model->isNewRecord) { ?>
            <img src="<?php echo $model->image_thumb_url; ?>" width="100" height="100"/>
<?php } ?>
        <div style="clear:both;"></div>
        <p class=" fileupload_note" >Allow image types : jpeg, jpg, png</p>
    </div>
    <div class="row" >
        <label for="Lookbook_status">Look Book PDF</label>
        <?php
        $this->widget('CMultiFileUpload', array(
            'name' => 'base_pdf',
            'accept' => 'doc|docx|pdf', // useful for verifying files
            'duplicate' => 'Duplicate file!', // useful, i think
            'denied' => 'Invalid file type', // useful, i think
            'options' => array(
                'afterFileSelect' => 'function(e ,v ,m){
            var fileSize = e.files[0].size;
            if(fileSize>1024*1024*2){
            alert("Exceeds file upload limit 2MB");
            $("div.MultiFile-list div:last-child a.MultiFile-remove").click();
            }                     
            return true;
            }',
            ),
            'max' => 1, //max 5 files allowed
        ));
        ?>
<?php if ($model->pdf_url != '') { ?>
            <a href="<?php echo $model->pdf_url; ?>" download>Dowland PDF</a>
<?php } ?>
        <p class=" fileupload_note" >Allow Document types : doc/docx/pdf</p>

    </div>

 <div class="row">
            <?php echo $form->labelEx($model, 'status'); ?>
            <!--  <?php echo $form->dropDownList($model, 'status', array('0' => 'Disable', '1' => 'Enable'), array('options' => array($model->status => array('selected' => true)))); ?>
                <?php echo $form->error($model, 'status'); ?> -->
            <div class="check-awesome" style="float: left;">  
                <?php if (!$model->isNewRecord) { ?>
                    <input  name="status" type="checkbox" id="check-one" value="1" <?php if ($model->status == 1) {
                        echo 'checked';
                    } ?>>;
<?php } else { ?>
                    <input name="status" type="checkbox" id="check-one" value="1" checked >;
<?php } ?>
                <label for="check-one">

                    <span class="check"></span>
                    <span class="box"></span>
                    Publish
                </label>
            </div>

        </div>

    <div style="clear:both;"></div>
    <div class="row buttons" >
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    <?php
    if (!$model->isNewRecord && substr_count(Yii::app()->session['premission_info']['module_info']['lookbook'], 'D') > 0) {
        echo CHtml::submitButton('Delete', array('confirm' => 'Are you sure you want to Delete?'));
    }
    ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->