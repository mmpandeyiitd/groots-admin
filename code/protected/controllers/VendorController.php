<?php

class VendorController extends Controller
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
				'actions'=>array('create','update', 'productMap', 'creditManagement', 'vendorLedger', 'vendorScript'),
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
		$model=new Vendor;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Vendor']))
		{
			$model->attributes=$_POST['Vendor'];
			$model->due_date = date('Y-m-d', strtotime($model->payment_start_date.' + '.$model->credit_days.' days'));
			$model->created_date = date('Y-m-d H:i:s');
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

		if(isset($_POST['Vendor']))
		{
			$model->attributes=$_POST['Vendor'];
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
		$dataProvider=new CActiveDataProvider('Vendor');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Vendor('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Vendor']))
			$model->attributes=$_GET['Vendor'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionProductMap($vendor_id){
		//var_dump($_POST);die;
		//flash , transaction remaning, price = ''
		$criteria  = new CDbCriteria;
		$criteria->select  = 'name, bussiness_name, mobile';
		$criteria->condition = 'id = '.$vendor_id.' and status = 1';
		$model = Vendor::model()->find($criteria);
		if(!isset($model) && empty($model)){
			Yii::app()->user->setFlash('error', 'Either Vendor Id Wrong or Vendor Inactive');
			Yii::app()->controller->redirect('index.php?r=vendor/admin');
		}
		$products = VendorDao::getVendorProductDetails($vendor_id);
		$data = new BaseProduct('search');
		$update = array();
		if(isset($_POST['save'])){
			$baseProductIds = array();
			$postPrice = array();
			if(isset($_POST['baseProductIds']) && !empty($_POST['baseProductIds'])){
				$baseProductIds = $_POST['baseProductIds'];
			}
			if(isset($_POST['price']) && !empty($_POST['price'])){
				$postPrice = $_POST['price'];
			}
			$newProducts = array();
			foreach ($_POST as $key => $value) {
			if(substr($key, 0, 9) == 'checkedId'){
				array_push($newProducts, substr($key, 10));
			}
		}
			foreach ($newProducts as $key => $value) {
				if(array_key_exists($value, $products)){
					$index = array_search($value, $baseProductIds);
					$price = ($postPrice[$index] != '') ? $postPrice[$index] : 0;
					if($price != $products[$value]['price']){
						$temp = array('id'=> $products[$value]['id'], 'price'=> $price);
						array_push($update, $temp);
					}
					unset($products[$value]);
					unset($newProducts[$key]);
				}
			}
			$ids = '';
			$first = true;
			foreach ($products as $key => $value) {
				if($first)
					$ids .= $value['id'];
				else{
					$ids .= ','.$value['id'];
				}
				$first = false;
			}
			$insert = array();
			foreach ($newProducts as $key => $value) {
				$index = array_search($value, $baseProductIds);
				$price = ($postPrice[$index] != '') ? $postPrice[$index] : 0;
				$temp = array('base_product_id' => $value, 'price' => $price);
				array_push($insert, $temp); 
			}
			VendorDao::updateVendorProductById($update);
			VendorDao::deleteVendorProductById($ids);
			VendorDao::insertVendorProductById($insert, $vendor_id);
		}

		$products = VendorDao::getVendorProductDetails($vendor_id);
		$this->render('productMap', array(
			'model' => $model,
			'dataProvider' => $data,
			'products' => $products,
		));
	}

	public function actionCreditManagement(){
		//var_dump($_POST);die;
		if(!empty($_GET['date'])){
			$endDate = $_GET['date'];
		}
		else if(isset($_POST['VendorPayment']) && !empty($_POST['VendorPayment'])){
			$endDate = $_POST['VendorPayment']['date'];
		}
		else{
			$endDate = date('Y-m-d');
		}
		$initial_pending_date = VendorDao::getInitialPendingDate();
		//var_dump($initial_pending_date);die;
		if(strtotime($endDate) < strtotime($initial_pending_date)){
			$startDate = VendorDao::getLastPendingDate($endDate, $initial_pending_date);
		}
		else $startDate = $initial_pending_date;
		if(isset($_POST['Payment']) && !empty($_POST['creditRepaid'])){
			self::saveVendorPaymet($_POST, $endDate);
		}
		$nextDate = date('Y-m-d', strtotime($startDate.' + 1 day'));
		$totalPendingMap = VendorDao::getAllVendorPayableAmount($nextDate, $endDate);
		$initialPendingMap = VendorDao::getAllVendorInitialPending($startDate);
		$lastPaymentDetails = VendorDao::getVendorLastPaymentDetails();
		//var_dump($lastPaymentDetails);
		$totalPending = 0;
		foreach ($totalPendingMap as $key => $value) {
			$totalPending += $value;
		}
		var_dump($totalPending);die;
		$totalPendingMap['total'] = strval($totalPending);
		$skuMap = VendorDao::getAllVendorSkus();
		$model = new Vendor();
		$vendorPayment = new VendorPayment;
		$vendorPayment->date = $endDate;
		$payable = VendorDao::getPayable($endDate, $nextDate);
		$totalPayable = 0;
		foreach ($payable as $key => $value) {
			$totalPayable += $value['amount'];
		}
		$payable['total'] = strval($totalPayable);
		$this->render('creditManagement', array(
				'model' => $model,
				'dataProvider' =>$model,
				'skuMap' => $skuMap,
				'vendorPayment' => $vendorPayment,
				'payable' => $payable,
				'totalPendingMap' => $totalPendingMap,
				'initialPendingMap' => $initialPendingMap,
				'lastPaymentDetails' => $lastPaymentDetails,
				));
		//var_dump($skuMap);die;
	}

	public function actionVendorLedger($vendor_id){
		$vendor = Vendor::model()->findByPk($vendor_id);
		$payments = VendorPayment::model()->findAllByAttributes(array('vendor_id' => $vendor_id, 'status' => 1), array('order'=>'date asc'));
		//var_dump($payments);die;
		$orders = VendorDao::getVendorOrderQuantity($vendor_id);
		$dataProvider = Vendor::getLedgerDataProvider($payments,$orders);
		$this->render('vendorLedger', array(
			'dataProvider' => $dataProvider,
			'vendor' => $vendor,));
		
	}

	public function actionVendorScript(){
		$username = "root";
		$password = "root";
		$localhost = "localhost";
		$connection = mysql_connect($localhost,$username, $password);
		mysql_select_db('cb_dev_groots');
		$sql = 'select due_date, id, name, payment_start_date, payment_days_range, initial_pending_date, initial_pending_amount from cb_dev_groots.vendors where status = 1';
		$query = mysql_query($sql);
		$rows = mysql_num_rows($query);
		$i=0;
		$today = date('Y-m-d');
		$yesterday = date('Y-m-d', strtotime($today.' - 1 day'));
		$initial_pending_date = mysql_result($query, 0, 3);
		mysql_data_seek($query, 0);
		$vendorPending = VendorDao::getAllVendorPayableAmount(date('Y-m-d', strtotime($initial_pending_date.' + 1 day')), $yesterday);
		while($i < $rows){
			$current = mysql_fetch_array($query);
			//var_dump($current);
			if(strtotime($current['due_date']) == strtotime($yesterday)){
				$newDueDate = date('Y-m-d', strtotime($current['due_date'].' + '.$current['payment_days_range'].' day'));
				$newStartDate = date('Y-m-d', strtotime($current['payment_start_date'].' + '.$current['payment_days_range'].' day'));
				$sql2 = 'update vendors set due_date = "'.$newDueDate.'", payment_start_date = "'.$newStartDate.'" where id = '.$current['id'];

				$update = mysql_query($sql2);
			}
			if(strtotime($yesterday) == date('Y-m-d', strtotime($current['initial_pending_date'].' + 2 month'))){
				$totalNow = $current['initial_pending_amount'] + $vendorPending[$current['id']];
				$newBaseDate = strtotime($current['initial_pending_date'].' + 2 month');
				$updateLog = 'insert into vendor_log values(null, '.$current['id'].', '.$totalNow.', '.$newBaseDate.', CURDATE(), null)';
				$updateVendorTable = 'update vendors set initial_pending_date = "'.$yesterday.'" , initial_pending_amount = "'.$totalNow.'"';
			}
			$i++;
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Vendor the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Vendor::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Vendor $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vendor-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function saveVendorPaymet($post, $date){
		$vendorIds = $post['vendorIds'];
		$creditRepaid = $post['creditRepaid'];
		foreach ($vendorIds as $key => $value) {
			if($creditRepaid[$key] != ''){
				VendorPayment::saveVendorCashPayment($value, $creditRepaid[$key], $date);
			}
		}
	}
}
