<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

//$this->pageTitle=Yii::app()->name . ' - Login';
//$this->breadcrumbs=array(
//	'Login',
//);
?>

<?php echo Yii::app()->user->getFlash('error'); ?>
<h1>Login</h1>
<div class="span10 ">
    <p>Please fill out the following form with your login credentials:</p>

    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <div class="row">
            <?php echo $form->textField($model, 'username'); ?>
            <?php if (Yii::app()->user->hasFlash('error')): ?><div class="label label-important"><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>
        </div>
        
        <div class="row">
            <?php echo $form->labelEx($model, 'username'); ?>
<?php echo $form->textField($model, 'username'); ?>
<?php echo $form->error($model, 'username'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'password'); ?>
                <?php echo $form->passwordField($model, 'password'); ?>
                <?php echo $form->error($model, 'password'); ?>
            <p class="hint">
<?php echo CHtml::link('Forgot Password', array('site/forgotpassword')); ?>
            </p>
        </div>

        <div class="row rememberMe">
            <?php //echo $form->checkBox($model,'rememberMe'); ?>
<?php //echo $form->label($model,'rememberMe');  ?>
<?php //echo $form->error($model,'rememberMe');  ?>
        </div>

        <div class="row buttons">
        <?php echo CHtml::submitButton('Login'); ?>
        </div>

<?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
<style type="text/css">
    .portlet-content {padding: 5px 25px !important;}
    @media(min-width:0) and (max-width:767px) {
        .row-fluid .offset4:first-child {    margin-left: 0 !important; padding-left: 0 !important;}
    }
</style>
</style>