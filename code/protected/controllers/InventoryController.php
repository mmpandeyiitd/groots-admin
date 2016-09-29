<?php

class InventoryController extends Controller
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
				'actions'=>array('create','update','admin'),
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
	    //echo "<pre>";
		//print_r($_POST);die;
        //$model=new Inventory('search');

        $w_id = '';
        if(isset($_GET['w_id'])){
            $w_id = $_GET['w_id'];
        }
        if(!$this->checkAccessByData('InventoryEditor', array('warehouse_id'=>$w_id))){
            Yii::app()->user->setFlash('premission_info', 'You dont have permission.');
            Yii::app()->controller->redirect("index.php?r=inventory/admin&w_id=".$w_id);
        }
        $inv_header = new InventoryHeader('search');
        $date = date('Y-m-d');
        //$date = "2016-09-15";
        $inv_header->date = $date;
        $inv_header->warehouse_id = $w_id;
        //$model->warehouse_id = $w_id;
        if(isset($_GET['InventoryHeader'])) {
            $inv_header->attributes = $_GET['InventoryHeader'];
        }
        list($popularItems, $otherItems) = BaseProduct::PopularItems();
        //$inventories = Inventory::model()->with('BaseProduct')->findAllByAttributes(array('warehouse_id'=>$w_id, 'date'=>$date),array('order'=> ' BaseProduct.title ASC'));
        //$dataProvider = $model->search();
        $dataProvider = $inv_header->search();
        $orderSum = OrderLine::getOrderSumByDate($w_id, $date);
        $purchaseSum = PurchaseLine::getPurchaseSumByDate($w_id, $date);
        $transferInSum = TransferLine::getTransferInSumByDate($w_id,$date);
        $transferOutSum = TransferLine::getTransferOutSumByDate($w_id,$date);
        $avgOrderByItem = OrderHeader::getAvgOrderByItem($w_id, $date);
        $quantitiesMap = array();
        $quantitiesMap['orderSum'] = $orderSum;
        $quantitiesMap['purchaseSum'] = $purchaseSum;
        $quantitiesMap['transferInSum'] = $transferInSum;
        $quantitiesMap['transferOutSum'] = $transferOutSum;
        $quantitiesMap['avgOrder'] = $avgOrderByItem;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['inventory-create']))
		{
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($_POST['base_product_id'] as $key => $bp_id) {
                    $date = $_POST['InventoryHeader']['date'];
                    $delivered_qty = trim($_POST['schedule_inv'][$key]);
                    $schedule_inv = trim($_POST['schedule_inv'][$key]);

                    $inv = Inventory::model()->findAllByAttributes(array('base_product_id'=>$bp_id, 'date'=>$date));
                    if($inv==false){
                        $inv = new Inventory();
                        $inv->warehouse_id = $_POST['InventoryHeader']['warehouse_id'];;
                        $inv->base_product_id = $bp_id;
                        $inv->date = $date;
                        $inv->inv_id = $_POST['inv_hd_id'][$key];
                        $inv->created_at = date('Y-m-d');
                    }
                    if(isset($schedule_inv) && $schedule_inv>0){
                        $inv->schedule_inv = $schedule_inv;
                    }
                    else{
                        $inv->schedule_inv = 0;
                    }
                    $inv->present_inv = $_POST['present_inv'][$key];
                    $inv->wastage = $_POST['wastage'][$key];
                    $inv->extra_inv = $_POST['extra_inv'][$key];
                    $inv->save();
                }
                $transaction->commit();
                $this->redirect(array('admin','w_id'=>$w_id));

            }catch (\Exception $e) {
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', 'Transfer order Creation failed.');
                throw $e;
            }
		}

		$this->render('create',array(
            'model'=>$inv_header,
            'dataProvider'=>$dataProvider,

            'otherItems'=> $otherItems,
            'w_id' => $_GET['w_id'],
            'quantitiesMap' => $quantitiesMap,
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
        if(isset($_GET['w_id'])){
            $w_id = $_GET['w_id'];
        }
        if(!$this->checkAccessByData('InventoryEditor', array('warehouse_id'=>$w_id))){
            Yii::app()->user->setFlash('premission_info', 'You dont have permission.');
            Yii::app()->controller->redirect("index.php?r=inventory/admin&w_id=".$w_id);
        }
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Inventory']))
		{
			$model->attributes=$_POST['Inventory'];
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
		$dataProvider=new CActiveDataProvider('Inventory');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdminOld()
	{
		$model=new Inventory('search');
		$model->unsetAttributes();  // clear any default values
        $w_id = $_GET['w_id'];
		if(isset($_GET['Inventory']))
			$model->attributes=$_GET['Inventory'];

		$this->render('admin',array(
			'model'=>$model,
            'w_id' => $w_id,
		));
	}

	public function  actionAdmin(){
	    //echo "<pre>";
        $model=new Inventory('search');
        $inv_header = new InventoryHeader('search');
        $w_id= $_GET['w_id'];
        //print_r($_POST);die;
        if(isset($_POST['inventory-date']) && !empty($_POST['Inventory'])){
            $date = $_POST['Inventory']['date'];
        }
        else{
            //$date = date('Y-m-d');
            $date = "2016-09-15";
        }
        $model->date = $date;

        //$model->date = $date;
        $model->warehouse_id = $w_id;
        if(isset($_GET['Inventory'])) {
            $model->attributes = $_GET['Inventory'];
        }
        list($popularItems, $otherItems) = BaseProduct::PopularItems();
        //$inventories = Inventory::model()->with('BaseProduct')->findAllByAttributes(array('warehouse_id'=>$w_id, 'date'=>$date),array('order'=> ' BaseProduct.title ASC'));
        $dataProvider = $model->search();
        //$dataProvider = $inv_header->search();
        $prevDayInv = $this->getPrevDayInv($date);
        $orderSum = OrderLine::getOrderSumByDate($w_id, $date);
        $purchaseSum = PurchaseLine::getPurchaseSumByDate($w_id, $date);
        $transferInSum = TransferLine::getTransferInSumByDate($w_id,$date);
        $transferOutSum = TransferLine::getTransferOutSumByDate($w_id,$date);
        $avgOrderByItem = OrderHeader::getAvgOrderByItem($w_id, $date);
        $quantitiesMap = array();
        $quantitiesMap['prevDayInv'] = $prevDayInv;
        $quantitiesMap['orderSum'] = $orderSum;
        $quantitiesMap['purchaseSum'] = $purchaseSum;
        $quantitiesMap['transferInSum'] = $transferInSum;
        $quantitiesMap['transferOutSum'] = $transferOutSum;
        $quantitiesMap['avgOrder'] = $avgOrderByItem;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
//print_r($_POST);die;
        if(isset($_POST['inventory-update']))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($_POST['base_product_id'] as $key => $bp_id) {
                    $date = $_POST['date'][$key];
                    $schedule_inv = trim($_POST['schedule_inv'][$key]);
                    $present_inv = trim($_POST['present_inv'][$key]);
                    $wastage = trim($_POST['wastage'][$key]);
                    $wastage_others = trim($_POST['wastage_others'][$key]);
                    $inv = Inventory::model()->findByAttributes(array('base_product_id'=>$bp_id, 'date'=>$date));
                    //var_dump($inv);die;
                    if($inv==false){
                        $inv = new Inventory();
                        $inv->base_product_id = $bp_id;
                        $inv->date = $date;
                        $inv->inv_id = $_POST['inv_hd_id'][$key];
                        $inv->created_at = date('Y-m-d');
                    }
                    if(isset($schedule_inv) && $schedule_inv>0){
                        $inv->schedule_inv = $schedule_inv;
                    }
                    else{
                        $inv->schedule_inv = 0;
                    }
                    $inv->present_inv = $present_inv;
                    $inv->wastage = $wastage;
                    $inv->wastage_others = $wastage_others;
                    $inv->extra_inv = $_POST['extra_inv'][$key];
                    $inv->save();
                }
                $transaction->commit();
                //$this->redirect(array('admin','w_id'=>$model->dest_warehouse_id));

            }catch (\Exception $e) {
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', 'Transfer order Creation failed.');
                throw $e;
            }
        }

        $this->render('update',array(
            'model'=>$model,
            'dataProvider'=>$dataProvider,
            'otherItems'=> $otherItems,
            'w_id' => $_GET['w_id'],
            'quantitiesMap' => $quantitiesMap,
        ));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Inventory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Inventory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Inventory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='inventory-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function getQuantities(){

    }

    protected function beforeAction() {
        $w_id='';
        if(parent::beforeAction()){
            if(isset($_GET['w_id'])){
                $w_id = $_GET['w_id'];
            }
            if($w_id>0 && $this->checkAccessByData('InventoryViewer', array('warehouse_id'=>$w_id))){
                return true;
            }
            elseif($this->checkAccess('SuperAdmin')){
                return true;
            }
            else{
                Yii::app()->user->setFlash('permission_error', 'You have no permission to access this page');
                Yii::app()->controller->redirect("index.php?r=user/profile");
            }
        }
    }

    public function getPrevDayInv($today){
        $invArr = array();
        $time = strtotime($today.' -1 days');
        $prevDay = date("Y-m-d", $time);
        $invs = Inventory::model()->findAllByAttributes(array('date'=>$prevDay), array('select'=>'base_product_id, present_inv'));
        foreach ($invs as $inv){
            $invArr[$inv->base_product_id] = $inv->present_inv;
        }
        return $invArr;
    }
}
