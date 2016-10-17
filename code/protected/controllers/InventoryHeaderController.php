<?php

class InventoryHeaderController extends Controller
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
				'actions'=>array('create','update','editInventory'),
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
	public function actionCreate()
	{
		$model=new InventoryHeader;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['InventoryHeader']))
		{
			$model->attributes=$_POST['InventoryHeader'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['InventoryHeader']))
		{
			$model->attributes=$_POST['InventoryHeader'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
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
		$dataProvider=new CActiveDataProvider('InventoryHeader');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new InventoryHeader('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['InventoryHeader']))
			$model->attributes=$_GET['InventoryHeader'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return InventoryHeader the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=InventoryHeader::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param InventoryHeader $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='inventory-header-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionEditInventory(){
		
		$w_id = '';
		if(isset($_GET['w_id']))
			$w_id = $_GET['w_id'];
		//echo $w_id; die;

		$inv_header = new InventoryHeader('search');
		if(isset($_GET['InventoryHeader'])){
			$inv_header->attributes = $_GET['InventoryHeader'];
		}
		$inv_header->warehouse_id = $w_id;
		if(isset($_POST['update'])){
			// var_dump($_POST);
			// var_dump($_GET); die;
			self::onUpdateInventory($_POST);
		}
		$dataProvider = $inv_header->search();
        $this->render('editInventory',
        	array(
        		'data'=>$dataProvider,
        		'model'=>$inv_header));
	}

	public static function onUpdateInventory($post){
		$id = $post['id'];
		$sch_inv = $post['schedule_inv'];
		$sch_inv_type = $post['schedule_inv_type'];
		$ext_inv = $post['extra_inv'];
		$ext_inv_type = $post['extra_inv_type'];

		foreach ($id as $key => $cur_id) {
			$cur_inv = InventoryHeader::model()->findByPk($cur_id);
			$cur_inv->schedule_inv = $sch_inv[$key];
	        $cur_inv->schedule_inv_type = $sch_inv_type[$key];
	        $cur_inv->extra_inv = $ext_inv[$key];
	        $cur_inv->extra_inv_type = $ext_inv_type[$key];	
	        $cur_inv->save();
		}
	}
}
	