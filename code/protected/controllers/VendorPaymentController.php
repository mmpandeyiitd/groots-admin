<?php

class VendorPaymentController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
			);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
				),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
				),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
				),
			array('deny',  // deny all users
				'users'=>array('*'),
				),
			);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($vendor_id)
	{
		//die('here');
		$w_id = '';
		if(isset(Yii::app()->session['w_id']) && !empty(Yii::app()->session['w_id'])){
			$w_id = Yii::app()->session['w_id'];
		}
		if(!$this->checkAccessByData('VendorCreditEditor', array('warehouse_id'=>$w_id))){
			Yii::app()->user->setFlash('premission_info', 'You dont have permission.! Bitch');
			Yii::app()->controller->redirect("index.php?r=vendor/admin&w_id=".$w_id);
		}
		$model=new VendorPayment;
		$model->vendor_id = $vendor_id;
		$vendor = Vendor::model()->findByPk($vendor_id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VendorPayment']))
		{
			$model->attributes=$_POST['VendorPayment'];
			$model->created_at = date('Y-m-d');
			if($model->save()){
				$vendor->total_pending_amount-= $model->paid_amount;
				if(!$vendor->save()){
					echo '<pre>';
					die(print_r($vendor->getErrors()));
				}
				$this->redirect(array('vendor/admin'));
			}
		}
		$this->render('create',array(
			'model'=>$model,
			'vendor' => $vendor,
			));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{	
		$w_id = '';
		if(isset(Yii::app()->session['w_id']) && !empty(Yii::app()->session['w_id'])){
			$w_id = Yii::app()->session['w_id'];
		}
		if(!$this->checkAccessByData('VendorCreditEditor', array('warehouse_id'=>$w_id))){
			Yii::app()->user->setFlash('premission_info', 'You dont have permission.! Bitch');
			Yii::app()->controller->redirect("index.php?r=vendor/admin&w_id=".$w_id);
		}

		$model=$this->loadModel($id);
		$vendor = Vendor::model()->findByPk($model->vendor_id);
		$initialPaid = $model->paid_amount;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VendorPayment']))
		{
			$model->attributes=$_POST['VendorPayment'];
			if($model->save()){
				$vendor->total_pending_amount += $initialPaid;
				$vendor->total_pending_amount -= $model->paid_amount;
				if(!$vendor->save()){
					die(print_r($vendor->getErrors()));
				}
				$this->redirect(array('vendor/admin'));
			}
		}
		$this->render('update',array(
			'model'=>$model,
			'vendor' => $vendor,
			));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$w_id = '';
		if(isset(Yii::app()->session['w_id']) && !empty(Yii::app()->session['w_id'])){
			$w_id = Yii::app()->session['w_id'];
		}
		if(!$this->checkAccessByData('VendorCreditEditor', array('warehouse_id'=>$w_id))){
			Yii::app()->user->setFlash('premission_info', 'You dont have permission.! Bitch');
			Yii::app()->controller->redirect("index.php?r=vendor/admin&w_id=".$w_id);
		}

		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('VendorPayment');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new VendorPayment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VendorPayment']))
			$model->attributes=$_GET['VendorPayment'];

		$this->render('admin',array(
			'model'=>$model,
			));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return VendorPayment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=VendorPayment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param VendorPayment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vendor-payment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function beforeAction(){
		if(parent::beforeAction()){
			$w_id = '';
			if(isset(Yii::app()->session['w_id']) && !empty(Yii::app()->session['w_id'])){
				$w_id = Yii::app()->session['w_id'];
			}
			if(!$this->checkAccessByData('VendorCreditViewer', array('warehouse_id'=>$w_id))){
				Yii::app()->user->setFlash('premission_info', 'You dont have permission.');
				Yii::app()->controller->redirect("index.php?r=vendor/admin&w_id=".$w_id);
			}
			return true;
		}
		else{
			return false;
		}
	}
}
