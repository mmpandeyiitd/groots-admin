<?php
/* @var $this LookbookController */
/* @var $model Lookbook */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'press-release-form',
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
    <?php if (Yii::app()->user->hasFlash('premission')): ?><div class="errorSummary"><?php echo Yii::app()->user->getFlash('premission'); ?></div><?php endif; ?>
    <?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-error" style="color: green;"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>
    <div class="">

        <div class="row">
            <?php echo $form->labelEx($model, 'title'); ?>
            <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'title'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php echo $form->textArea($model, 'description', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'front_url'); ?>
            <?php echo $form->textField($model, 'front_url', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'front_url'); ?>
        </div>
       
    </div>
    <div class="row" >
        <label for="Lookbook_status">Upload Image</label>
        <?php echo $form->fileField($model, 'image'); ?>
        <?php if (!$model->isNewRecord) { ?>
            <img src="<?php echo $model->image_thumb_url; ?>" width="100" height="100"/>
            <p class="fileupload_note">Allow image types : jpeg, jpg, png</p>
        <?php } ?>
    </div>
 <div class="row">
            <?php echo $form->labelEx($model, 'status'); ?>
            <div class="check-awesome" style="float: left;">  
                <?php if (!$model->isNewRecord) { ?>
                    <input  name="status" type="checkbox" id="check-one" value="1" <?php
                    if ($model->status == 1) {
                        echo 'checked';
                    }
                    ?>>
                        <?php } else { ?>
                    <input name="status" type="checkbox" id="check-one" value="1" checked >;
                <?php } ?>
                <label for="check-one">
                    <span class="check"></span>
                    <span class="box"></span>
                    Publish
                </label>
            </div>
            <?php echo $form->error($model, 'status'); ?>
        </div>
    <div style="clear:both;"></div>
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');?>
        <?php 
        if (!$model->isNewRecord && substr_count(Yii::app()->session['premission_info']['module_info']['pressrelease'], 'D') > 0) {
            echo CHtml::submitButton('Delete', array('confirm' => 'Are you sure you want to Delete?'));
        }
        ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->