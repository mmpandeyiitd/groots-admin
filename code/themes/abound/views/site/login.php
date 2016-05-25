<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

//$this->pageTitle=Yii::app()->name . ' - Login';
//$this->breadcrumbs=array(
//	'Login',
//);
?>
<!-- <div class="page-header">
	<h1>Login <small>to your account</small></h1>
</div> -->
<div class="row-fluid">
	
    <div class="span4 offset4" style="overflow:hidden;">
<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"Private access",
	));
	
?>

    <div class="span12 login_formnew" >

   <!--  <p>Please fill out the following form with your login credentials:</p> -->
    
    <div class="form" style="overflow:hidden;">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>
    
        <p class="note" style="margin-left: 0;">Fields with <span class="required">*</span> are required.</p>
        <div class="row">
            <span class="dashIcon_head"><i class="fa fa-user"></i></span>
            
            <h4>Dashboard Login</h4>
         </div>   
    
        <div class="row">
           <!--  <?php echo $form->labelEx($model,'username'); ?> -->
           <label> <i class="fa fa-user"></i> </label>
            <?php echo $form->textField($model,'username',array('placeholder'=>'Enter Email ID')); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>
    
        <div class="row">
            <label> <i class="fa fa-key"></i> </label>
            <?php echo $form->passwordField($model,'password',array('placeholder'=>'Enter Password')); ?>
            <?php echo $form->error($model,'password'); ?>
            
        </div>
     <p class="hint">
                 <?php //echo CHtml::link('Forgot Password',array('site/forgotpassword')); ?>
            </p>
      
    
        <div class="row buttons">
            <?php echo CHtml::submitButton('Login',array('class'=>'btn btn btn-primary')); ?>
        </div>
    
    <?php $this->endWidget(); ?>
    </div><!-- form -->

<?php $this->endWidget();?>

    </div>
     </div>

</div>
<style type="text/css">
.login_formnew form { border: 0 !important; width: 340px !important; margin-top: 80px !important;}
.login_formnew form h4 {text-align: center; color: #333; font-size: 18px; text-transform: uppercase;font-weight:500;letter-spacing: 1px;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; margin: 10px 0 0; padding: 0; line-height: 28px;}
.portlet-decoration  { display: none;}
.portlet-content { bottom: 0;}
.portlet { border: 0; box-shadow: none;}
body { background: url(site-img/grey.jpg) ; background-size: cover;}
footer { display: none;}
@media(min-width:0) and (max-width:767px) {
 .row-fluid .offset4:first-child {    margin-left: 0 !important; padding-left: 0 !important;}
 .row-fluid .login_formnew {padding: 0;}
 #login-form input { width: 90%;}
    }
</style>
