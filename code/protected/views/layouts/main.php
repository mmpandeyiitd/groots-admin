<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php 
		/**
			$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
                array('url'=>array('/index'),'visible'=>Yii::app()->session['checkAccess']=='Admin'),
                array('label'=>'Manage Stores', 'url'=>array('/store/index'),'visible'=>(Yii::app()->session['checkAccess']=='Admin')||(Yii::app()->session['checkAccess']=='Store')),
                array('label'=>'Manage Categories', 'url'=>array('/category/index'),'visible'=>(Yii::app()->session['checkAccess']=='Admin')||(Yii::app()->session['checkAccess']=='Store')),
                array('label'=>'Manage BaseProducts', 'url'=>array('/baseProduct/index'),'visible'=>(Yii::app()->session['checkAccess']=='Admin')||(Yii::app()->session['checkAccess']=='Store')),
                array('label'=>'Manage Subscribeds', 'url'=>array('/subscribedProduct/index'),'visible'=>Yii::app()->session['checkAccess']=='Admin'),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),


		));

		**/
		 ?>
		<?php 
		/**
                    $this->widget('zii.widgets.CMenu',array(
                    	'items'=>array(
		                    array('label' => 'Users', 'url' => array('/YmpdmUser/admin'), 'visible' => (@Yii::app()->session['premission_info']->menu_info->users_menu_info=="S"?true:false) ), 
		                    array('label'=>'Stores Front', 'url'=>array('/storeFront/admin'),'visible'=>(@Yii::app()->session['premission_info']->menu_info->storefront_menu_info=="S"?true:false) ),
		                    array('label' => 'Prepaid Seller', 'url' => array('/PrepaidStore/admin'), 'visible' => (@Yii::app()->session['premission_info']->menu_info->prepaid_menu_info=="S"?true:false) ), 
		                    array('label' => 'Coupon', 'url' => array('/coupon/admin'), 'visible' => (@Yii::app()->session['premission_info']->menu_info->coupon_menu_info=="S"?true:false),'items'=>array(
		                    array('label'=>'CommunicationStrips', 'url'=>array('/CommunicationStrips/admin','visible' => (@Yii::app()->session['premission_info']->menu_info->coupon_menu_info=="S"?true:false))),
		                    ) ),
		                    array('label' => 'CMS', 'url' => array('categoryCms/update&id=1'), 'visible' => (@Yii::app()->session['premission_info']->menu_info->cms_menu_info=="S"?true:false),'items'=>array(
		                    array('label'=>'ImageUpload', 'url'=>array('/coupon/Imageupload','visible' => (@Yii::app()->session['premission_info']->menu_info->cms_menu_info=="S"?true:false))),
		                    array('label'=>'Header Navigation', 'url'=>array('/category/create','visible' => (@Yii::app()->session['premission_info']->menu_info->cms_menu_info=="S"?true:false))),
		                    array('label'=>'Home Page', 'url'=>array('categoryCms/update&id=1','visible' => (@Yii::app()->session['premission_info']->menu_info->cms_menu_info=="S"?true:false))),
		                    array('label'=>'Landing Page', 'url'=>array('LandingPages/admin','visible' => (@Yii::app()->session['premission_info']->menu_info->cms_menu_info=="S"?true:false))),
		                    array('label'=>'StoreFront Page', 'url'=>array('StorefrontCms/admin','visible' => (@Yii::app()->session['premission_info']->menu_info->cms_menu_info=="S"?true:false))),
		                    ) ),        
		                    array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
		                    array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
		                ),
                    ));
                    **/
        ?>

	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
                    'homeLink'=>'dash',
                    'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
