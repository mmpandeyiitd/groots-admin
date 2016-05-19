<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

//$this->pageTitle=Yii::app()->name . ' - forgotpassword';
//$this->breadcrumbs=array(
//	'forgotpassword',
//);
?>

<!-- <div class="page-header">
<h1>forgot password</h1>
</div> -->
<div class="row-fluid">
	
    <div class="span4 offset4">
    	<div class="">
</div>
<div class="span12 login_formnew">
<!-- <p>Please fill out the following form with your login credentials:</p> -->

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
<h4>forgot password</h4>
<!-- 
	<p class="note">Fields with <span class="required">*</span> are required.</p> -->
<?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-error" style="color: green;"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')): ?><div class="flash-error" style="color: red;"><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>

	<div class="row">
		<label> <i class="fa fa-envelope-o"></i> </label>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
<div class="row">
    <a href="index.php?r=site/login">Login</a>
		
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Send',array('class'=>'btn btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
    </div>
    </div>
</div>
<style type="text/css">
.login_formnew form { border: 0 !important; width: 340px !important;     margin: 0 auto; margin-top: 120px !important; }
.login_formnew form h4 {text-align: center; color: #333; font-size: 18px; text-transform: uppercase;font-weight:500;letter-spacing: 1px;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; margin: 10px 0 0; padding: 0; line-height: 28px;}
.portlet-decoration  { display: none;}
.portlet-content { bottom: 0;}
.portlet { border: 0; box-shadow: none;}
body { background: url(site-img/grey.jpg) ; background-size: cover;}
@media(min-width:0) and (max-width:767px) {
	#login-form input { width: auto; float: none;}
 .row-fluid .offset4:first-child {    margin-left: 0 !important; padding-left: 0 !important;}
 .row-fluid .login_formnew {padding: 0;}
 #login-form input { width: 90%;}
    }
</style>