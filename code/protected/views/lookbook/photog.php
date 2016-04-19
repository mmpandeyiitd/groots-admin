<?php
    /* @var $this LookbookController */
    /* @var $model Lookbook */
    /* @var $form CActiveForm */

$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 1) {
    
    if (!(isset($_GET['store_id'])) || (empty($_GET['store_id']))) {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
    
    $store_id = $_GET['store_id'];
    
    if (Yii::app()->session['brand_admin_id'] != $store_id) {
       Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
    
    $store_name = Store::model()->getstore_nameByid($store_id);
    $this->breadcrumbs = array(
         'Brand' => array('store/admin'),
          $store_name => array('store/update', "id" => $store_id),
         'Photo Gallery' => array('Adminphoto', "store_id" => $store_id),
          $model->headline => array('photogallaryupdate', "store_id" => $store_id), 'Create',
    );
     
} else {
    if (!(isset($_GET['store_id']))||(empty($_GET['store_id']))) {
         Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
     $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_id'] != $store_id) {
        $this->redirect(array('site/logout'));
    }
    
    $this->breadcrumbs = array(
        'Photo Gallery' => array('Adminphoto', "store_id" => $store_id),
       'Create',);
  }


?>
<div class="portlet-content">
<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'lookbook-form',
        'focus' => '.error:first',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
//        'clientOptions'=>array(
//        'validateOnSubmit'=>true,
//        ),
        )); ?>
        

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
<?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-error" style="color: green;"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>
    <div class="">

    <div class="row">
        <?php echo $form->labelEx($model,'Title *'); ?>
        <?php echo $form->textField($model,'headline',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'headline'); ?>
    </div>
        
    <div class="row" >
        <label for="Lookbook_status">Upload Image</label>
    
    <?php $this->widget('CMultiFileUpload', array(
            'name' => 'images',
            'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
            'duplicate' => 'Duplicate file!', // useful, i think
            'denied' => 'Invalid file type', // useful, i think
            'options'=>array(
            'afterFileSelect'=>'function(e ,v ,m){
            var fileSize = e.files[0].size;
            if(fileSize>1024*1024*2){
            alert("Exceeds file upload limit 2MB");
            $("div.MultiFile-list div:last-child a.MultiFile-remove").click();
            }                     
            return true;
            }',                                                       
            ),
            'max'=>1, //max 5 files allowed
            ));
        ?>
        <p class="fileupload_note">Allow image types : jpeg, jpg, png</p>
        <?php if(!$model->isNewRecord){?>
        <img src="<?php echo $model->image_thumb_url;?>" width="100" height="100"/>
        <?php }?>
    </div>

<div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <div class="check-awesome" style="float: left;">  
           <?php 
              if(!$model->isNewRecord){?>
                 <input  name="status" type="checkbox" id="check-one" value="1" <?php if($model->status==1) { echo 'checked';}?>>;
              <?php }else{?>
                 <input name="status" type="checkbox" id="check-one" value="1" checked >;
             <?php  }?>
              <label for="check-one">
                <span class="check"></span>
                <span class="box"></span>
                Publish
              </label>
          </div>
          <?php echo $form->error($model, 'status'); ?>
    </div>

<div style="clear:both;"></div>
    <div class="row buttons" >
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
</div>