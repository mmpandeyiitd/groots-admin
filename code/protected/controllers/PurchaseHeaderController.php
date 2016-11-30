<?php

class PurchaseHeaderController extends Controller
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
				'actions'=>array('create','update', 'admin','downloadReconciliationReport', 'dailyProcurement', 'downloadProcurementReport'),
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

    /*protected function beforeAction() {
        $session = Yii::app()->session['user_id'];
        if ($session == '') {
            echo Yii::app()->controller->redirect("index.php?r=site/logout");
        }
        if (Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] != "S") {
            Yii::app()->user->setFlash('permission_error', 'You have no permission');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        return true;
    }*/

    protected function beforeAction() {
        $w_id='';
        if(parent::beforeAction()){
            if(isset($_GET['w_id'])){
                $w_id = $_GET['w_id'];
            }
            if($w_id>0 && $this->checkAccessByData('PurchaseViewer', array('warehouse_id'=>$w_id))){
                return true;
            }
            if($w_id>0 && $this->checkAccessByData('ProcurementViewer', array('warehouse_id'=>$w_id))){
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
        $w_id = '';
        if(isset($_GET['w_id'])){
            $w_id = $_GET['w_id'];
        }

        if(!$this->checkAccessByData('ProcurementEditor', array('warehouse_id'=>$w_id))){
            Yii::app()->user->setFlash('premission_info', 'You dont have permission.');
            Yii::app()->controller->redirect("index.php?r=purchaseHeader/admin&w_id=".$w_id);
        }

		$model=new PurchaseHeader('search');
        /*list($popularItems, $otherItems) = BaseProduct::PopularItems();
        $dataProvider=new CArrayDataProvider($popularItems, array(
            'pagination'=>array(
                'pageSize'=>300,
            ),
        ));*/

        $purchaseLineMap = array();
        $inv_header = new InventoryHeader('search');

        $inv_header->warehouse_id = $w_id;
        //$model->warehouse_id = $w_id;
        if(isset($_GET['InventoryHeader'])) {
            $inv_header->attributes = $_GET['InventoryHeader'];
        }

        $dataProvider = $inv_header->search();
//print_r($_POST);die;
        //print_r($otherItems);die;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['purchase-create']))
		{
            $transaction = Yii::app()->db->beginTransaction();
            try {

                $model->attributes=$_POST['PurchaseHeader'];
                $model->created_at = date('Y-m-d');
                if($model->payment_method == ''){
                    $model->payment_method = null;
                }
                if($model->payment_status == ''){
                    $model->payment_status = null;
                }
                if($model->paid_amount == ''){
                    $model->paid_amount = null;
                }
                if($model->comment == ''){
                    $model->comment = null;
                }
                //print_r($model);die;

                if($model->save()){

                    if(isset($_POST['order_qty'])){
                        foreach ($_POST['order_qty'] as $key => $quantity) {
                            if ($quantity > 0) {
                                $purchaseLine = new PurchaseLine();
                                $purchaseLine->purchase_id = $model->id;
                                $purchaseLine->base_product_id = $_POST['base_product_id'][$key];
                                if(isset($_POST['order_qty'][$key]) && $_POST['order_qty'][$key] > 0){
                                    $purchaseLine->order_qty = $quantity;
                                }
                                $purchaseLine->created_at = date("y-m-d H:i:s");
                                $purchaseLine->save();
                            }
                        }
                    }
                    if(isset($_POST['received_qty'])){
                        foreach ($_POST['received_qty'] as $key => $quantity) {
                            if ($quantity > 0) {
                                $purchaseLine = new PurchaseLine();
                                $purchaseLine->purchase_id = $model->id;
                                $purchaseLine->base_product_id = $_POST['base_product_id'][$key];
                                if(isset($_POST['received_qty'][$key]) && $_POST['received_qty'][$key] > 0){
                                    $purchaseLine->received_qty = $quantity;
                                }
                                $purchaseLine->created_at = date("y-m-d H:i:s");
                                $purchaseLine->save();
                            }
                
                        }
                    }
                    $transaction->commit();
                    $this->redirect(array('admin','w_id'=>$model->warehouse_id));
                }
                else{
                    Yii::app()->user->setFlash('error', 'Purchase order Creation failed.');
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', 'Purchase order Creation failed.');
                throw $e;
            }

		}

		$this->render('create',array(
			'model'=>$model,
            'inv_header'=>$inv_header,
            'purchaseLineMap'=> $purchaseLineMap,
            'dataProvider'=>$dataProvider,
            //'otherItems'=> $otherItems,
            'w_id' => $w_id,
		));
	}



	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
	    //echo "<pre>";
		//print_r($_POST);die;
        $w_id = '';
        if(isset($_GET['w_id'])){
            $w_id = $_GET['w_id'];
        }
        /*if(!($this->checkAccess('ProcurementEditor', array('warehouse_id'=>$w_id)) || $this->checkAccess('PurchaseEditor',array('warehouse_id'=>$w_id)))){
            Yii::app()->controller->redirect("index.php?r=purchaseHeader/admin&w_id=".$w_id);
        }*/
        if(!($this->checkAccessByData(array('ProcurementEditor', 'PurchaseEditor'), array('warehouse_id'=>$w_id)))){
            Yii::app()->controller->redirect("index.php?r=purchaseHeader/admin&w_id=".$w_id);
        }

        $model=$this->loadModel($id);
        $purchaseLines = PurchaseLine::model()->findAllByAttributes(array('purchase_id' => $id));
        //list($popularItems, $otherItems) = BaseProduct::PopularItems();
        $purchaseLineMap = array();
        $purchaseLinesArr = array();
        foreach ($purchaseLines as $item){
            //var_dump($item->BaseProduct); die;
            $purchaseLineMap[$item->base_product_id] = $item;
            array_push($purchaseLinesArr,$item);
        }

        $dataProvider=new CArrayDataProvider($purchaseLinesArr, array(
            'pagination'=>array(
                'pageSize'=>100,
            ),
        ));


        $inv_header = new InventoryHeader('search');
        $inv_header->warehouse_id = $w_id;

        if(isset($_GET['InventoryHeader'])) {
            $inv_header->attributes = $_GET['InventoryHeader'];
        }

        $dataProvider = $inv_header->search();


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        if(isset($_POST['purchase-update'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {

                $model->attributes = $_POST['PurchaseHeader'];
                if($model->payment_method == ''){
                    $model->payment_method = null;
                }
                if($model->payment_status == ''){
                    $model->payment_status = null;
                }
                if($model->paid_amount == ''){
                    $model->paid_amount = null;
                }
                if($model->comment == ''){
                    $model->comment = null;
                }
                if ($model->save()) {
                    if(isset($_POST['order_qty'])){
                        foreach ($_POST['order_qty'] as $key => $quantity) {

                            if (isset($purchaseLineMap[$_POST['base_product_id'][$key]])) {
                                $purchaseLine = $purchaseLineMap[$_POST['base_product_id'][$key]];
                            } else {
                                $purchaseLine = new PurchaseLine();
                                $purchaseLine->purchase_id = $model->id;
                                $purchaseLine->base_product_id = $_POST['base_product_id'][$key];
                                $purchaseLine->created_at = date("y-m-d H:i:s");

                            }

                            if (isset($_POST['order_qty'][$key]) ) {
                                if($quantity==''){
                                    $quantity = 0;
                                }
                                $purchaseLine->order_qty = $quantity;
                            }

                            $purchaseLine->save();

                        }
                    }
                    if(isset($_POST['received_qty'])){
                        foreach ($_POST['received_qty'] as $key => $quantity) {

                            if (isset($purchaseLineMap[$_POST['base_product_id'][$key]])) {
                                $purchaseLine = $purchaseLineMap[$_POST['base_product_id'][$key]];
                            } else {
                                $purchaseLine = new PurchaseLine();
                                $purchaseLine->purchase_id = $model->id;
                                $purchaseLine->base_product_id = $_POST['base_product_id'][$key];
                                $purchaseLine->created_at = date("y-m-d H:i:s");

                            }

                            if (isset($_POST['received_qty'][$key]) ) {
                                if($quantity==''){
                                    $quantity = 0;
                                }
                                $purchaseLine->received_qty = $quantity;
                            }

                            $purchaseLine->save();

                        }
                    }

                    $transaction->commit();
                    $url = Yii::app()->controller->createUrl("purchaseHeader/update",array("w_id"=>$w_id, "id"=>$model->id));
                    Yii::app()->user->setFlash('success', 'purchase order successfully Updated.');
                    Yii::app()->controller->redirect($url);
                    //$this->redirect(array('admin','w_id'=>$model->warehouse_id));
                }
                else{
                    Yii::app()->user->setFlash('error', 'Purchase order Update failed.');
                }
            }catch (\Exception $e) {
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', 'Purchase order Creation failed.');
                throw $e;
            }
        }


		$this->render('update',array(
			'model'=>$model,
            'inv_header'=>$inv_header,
            'purchaseLineMap'=> $purchaseLineMap,
            'dataProvider'=>$dataProvider,
            //'otherItems'=> $otherItems,
            'w_id' => $_GET['w_id'],
            'update'=>true,
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
		$dataProvider=new CActiveDataProvider('PurchaseHeader');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PurchaseHeader('search');
		$model->unsetAttributes();  // clear any default values
        $w_id = $_GET['w_id'];
		if(isset($_GET['PurchaseHeader']))
			$model->attributes=$_GET['PurchaseHeader'];
        $model->warehouse_id=$w_id;
        $showCreate = false;
        if($w_id>0 && $this->checkAccessByData('ProcurementViewer', array('warehouse_id'=>$w_id))){
            $showCreate = true;
        }
		$this->render('admin',array(
			'model'=>$model,
            'w_id' => $w_id,
            'showCreate'=>$showCreate,
        ));
	}


    public function actionDownloadReconciliationReport(){
        $w_id = $_GET['w_id'];
        $date = $_GET['date'];
        $sql = 'select pl.base_product_id, bp.title, ph.id, ph.delivery_date, pl.order_qty as order_qty, pl.received_qty as received_qty from groots_orders.purchase_line as pl
                left join groots_orders.purchase_header as ph
                on ph.id = pl.purchase_id
                left join cb_dev_groots.base_product as bp 
                on bp.base_product_id = pl.base_product_id
                left join cb_dev_groots.product_category_mapping pcm on pcm.base_product_id=bp.base_product_id
                where ( pl.order_qty != pl.received_qty or pl.order_qty is null or pl.received_qty is null) and ph.delivery_date = '."'".$date."'".'and ph.warehouse_id = '.$w_id.' and ph.status in ("received" , "pending")
                 order by pcm.category_id asc, bp.base_title asc, bp.priority asc ';
        $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sql);
        $command->execute();
        $dataArray = $command->queryAll();
        if(!isset($dataArray) || empty($dataArray)){
            Yii::app()->user->setFlash('error', 'nothing to download... select correct date!!!');
            Yii::app()->controller->redirect("index.php?r=purchaseHeader/admin&w_id=".$w_id);
        }
        else{
            $w_name = str_replace(' ', '',Utility::getWarehouseNameById($w_id));
            $fileName = $date."reconciliation_report".".csv";
            ob_clean();
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);

            if (isset($dataArray['0'])) {
                $fp = fopen('php://output', 'w');
                $columnstring = implode(',', array_keys($dataArray['0']));
                $updatecolumn = str_replace('_', ' ', $columnstring);

                $updatecolumn = explode(',', $updatecolumn);
                fputcsv($fp, $updatecolumn);
                foreach ($dataArray AS $values) {
                    fputcsv($fp, $values);
                }
                fclose($fp);
            }
            ob_flush();
        }
    }


public static function createProcurementOrder($purchaseOrderMap, $date, $w_id){
    //echo "<pre>";
    //print_r($purchaseOrderMap);
        $purchaseOrder = PurchaseHeader::model()->findByAttributes(array('delivery_date' => $date, 'warehouse_id' =>$w_id, 'purchase_type' => 'regular', 'status' => 'pending'));


        $transaction = Yii::app()->db->beginTransaction();
        try {

            if (empty($purchaseOrder)) {
                $purchaseOrder = new PurchaseHeader();
                $purchaseOrder->warehouse_id = $w_id;
                $purchaseOrder->vendor_id = 1;
                $purchaseOrder->delivery_date = $date;
                $purchaseOrder->status = 'pending';
                $purchaseOrder->comment = 'system generated';
                $purchaseOrder->created_at = date('Y-m-d');
                $purchaseOrder->purchase_type = "regular";
            }
            $purchaseOrder->save();
            $purchaseLineMap = self::getPurchaseLineMap($purchaseOrder->id);
            foreach ($purchaseOrderMap as $bp_id => $qty) {
                if (isset($purchaseLineMap[$bp_id])) {
                    $item = $purchaseLineMap[$bp_id];
                    /*if($qty < 0) {
                        $qty=0;
                    }*/
                    $item->tobe_procured_qty = $qty;
                    $item->save();
                } else {
                        $item = new PurchaseLine();
                        $item->purchase_id = $purchaseOrder->id;
                        $item->base_product_id = $bp_id;
                        $item->status = 'pending';
                        $item->created_at = date('Y-m-d');
                        $item->tobe_procured_qty = $qty;
                        $item->save();
                }
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::app()->user->setFlash('error', 'Transfer order Creation failed.');
            throw $e;
            Yii::app()->controller->redirect(Yii::app()->request->urlReferrer);
        }
    }

    private static function getPurchaseLineMap($purchase_id){
        $itemArr = array();
        $items = PurchaseLine::model()->findAllByAttributes(array('purchase_id'=>$purchase_id));
        foreach ($items as $item){
            $itemArr[$item->base_product_id] = $item;
        }
        return $itemArr;
    }

    public function actionDailyProcurement(){
        //echo "<pre>";
        if(empty($_GET['w_id'])){
            Yii::app()->controller->redirect("index.php?r=user/profile");
        }
        $w_id = $_GET['w_id'];

        if(empty($_POST['delivery_date'])){
            //Yii::app()->controller->redirect(Yii::app()->request->urlReferrer);
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        $date = $_POST['delivery_date'];
        //$date = $this->getDateForDailyTransfer();

        TransferDao::createTransfer($w_id, $date);

        Yii::app()->controller->redirect(Yii::app()->request->urlReferrer);
    }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PurchaseHeader the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PurchaseHeader::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PurchaseHeader $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='purchase-header-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionDownloadProcurementReport(){
        $w_id = $_GET['w_id'];
        $date = $_GET['date'];
        $sql = 'select pl.base_product_id, bp.title, wa.name as warehouse, sum(pl.tobe_procured_qty) as "Qty To Be Procured" from groots_orders.purchase_line as pl 
        left join purchase_header as ph on ph.id = pl.purchase_id left join cb_dev_groots.base_product as bp on pl.base_product_id = bp.base_product_id left join cb_dev_groots.warehouses as wa on ph.warehouse_id = wa.id
        left join cb_dev_groots.product_category_mapping pcm on pcm.base_product_id=bp.base_product_id
         where ph.status not in ("failed", "cancelled") and ph.delivery_date = '.'"'.$date.'"'.'and ph.warehouse_id = '.$w_id.' group by pl.base_product_id order by pcm.category_id asc, bp.base_title asc, bp.priority asc ';
           $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sql);
        $command->execute();
        $dataArray = $command->queryAll();
        if(!isset($dataArray) || empty($dataArray)){
            Yii::app()->user->setFlash('error', 'nothing to download... select correct date!!!');
            Yii::app()->controller->redirect("index.php?r=purchaseHeader/admin&w_id=".$w_id);
        }
        $w_name = str_replace(' ', '',Utility::getWarehouseNameById($w_id));
        $fileName = $date."procurement_report".".csv";
        ob_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);

        if (isset($dataArray['0'])) {
            $fp = fopen('php://output', 'w');
            $columnstring = implode(',', array_keys($dataArray['0']));
            $updatecolumn = str_replace('_', ' ', $columnstring);

            $updatecolumn = explode(',', $updatecolumn);
            fputcsv($fp, $updatecolumn);
            foreach ($dataArray AS $values) {
                fputcsv($fp, $values);
            }
            fclose($fp);
        }
        ob_flush(); 
    }
}
