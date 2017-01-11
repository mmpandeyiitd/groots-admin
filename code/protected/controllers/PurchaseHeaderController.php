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
                $parentIdArr = array();
                $parentIdToUpdate = '';
                if(isset($_POST['parent_id'][0]) && $_POST['parent_id'][0] >= 0){
                    array_push($parentIdArr, $_POST['parent_id'][0]);
                }

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

                    if(isset($_POST['order_qty']) || isset($_POST['received_qty'])){
                        foreach ($_POST['base_product_id'] as $key => $id) {

                            $quantity = '';
                            if(isset($_POST['order_qty'][$key])){
                                $quantity = $_POST['order_qty'][$key];
                            }
                            $receivedQty = '';
                            if(isset($_POST['received_qty'][$key])){
                                $receivedQty = $_POST['received_qty'][$key];
                            }

                            if ($quantity > 0 || $receivedQty > 0) {
                                $purchaseLine = new PurchaseLine();
                                $purchaseLine->purchase_id = $model->id;
                                $purchaseLine->base_product_id = $id;
                                if($quantity > 0){
                                    $purchaseLine->order_qty = $quantity;
                                }
                                if($receivedQty > 0){
                                    $purchaseLine->received_qty = $receivedQty;
                                }
                                if(isset($_POST['price'][$key]) && $_POST['price'][$key] > 0){
                                    $purchaseLine->unit_price = $_POST['price'][$key];
                                }
                                if(isset($_POST['totalPrice'][$key]) && $_POST['totalPrice'][$key] > 0){
                                    $purchaseLine->price = $_POST['totalPrice'][$key];
                                }
                                $purchaseLine->created_at = date("y-m-d H:i:s");
                                $purchaseLine->vendor_id =$_POST['InventoryHeader']['vendor_id'][$key];
                                
                                if(!$purchaseLine->save()){
                                    die(print_r($purchaseLine->getErrors()));
                                }
                            }
                            $parentIdToUpdate = $_POST['parent_id'][$key];
                        }
                    }

                    if($parentIdToUpdate != '' && $parentIdToUpdate > 0){
                        array_push($parentIdArr, $parentIdToUpdate);
                    }
                    $transaction->commit();
                    $this->updateParentsItems($parentIdArr,$model->id);
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
        $priceMap = VendorDao::getAllVendorsPriceMap();
		$this->render('create',array(
			'model'=>$model,
            'inv_header'=>$inv_header,
            'purchaseLineMap'=> $purchaseLineMap,
            'dataProvider'=>$dataProvider,
            //'otherItems'=> $otherItems,
            'w_id' => $w_id,
            'priceMap' => $priceMap,
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
		//var_dump($_POST);die;
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
        $updateType = "update";
        if(isset($_GET['type'])){
            if ($_GET['type']=="add"){
                $updateType = "add";
            }
        }
        $model=$this->loadModel($id);


        $inv_header = new InventoryHeader('search');
        $inv_header->warehouse_id = $w_id;

        if(isset($_GET['InventoryHeader'])) {
            $inv_header->attributes = $_GET['InventoryHeader'];
        }
        $inv_header->purchase_id = $id;
        $inv_header->update_type = $updateType;
        $dataProvider = $inv_header->purchaseSearch();

        if(isset($_POST['purchase-update'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $purchaseLines = PurchaseLine::model()->findAllByAttributes(array('purchase_id' => $id));
                $purchaseLineMap = array();
                foreach ($purchaseLines as $item){
                    $purchaseLineMap[$item->base_product_id] = $item;
                }
                $model->attributes = $_POST['PurchaseHeader'];
                $parentIdArr = array();
                $parentIdToUpdate = '';
                if(isset($_POST['parent_id'][0]) && $_POST['parent_id'][0] >= 0){
                    array_push($parentIdArr, $_POST['parent_id'][0]);
                }

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
                    if(isset($_POST['order_qty']) || isset($_POST['received_qty'])){


                        foreach ($_POST['base_product_id'] as $key => $id) {
                            $order_qty = $received_qty = $price = $vendor_id = '';
                            if(isset($_POST['order_qty'][$key])){
                                $order_qty = trim($_POST['order_qty'][$key]);
                            }

                            if(isset($_POST['received_qty'][$key]) ){
                                $received_qty = trim($_POST['received_qty'][$key]);
                            }
                            if(isset($_POST['price'][$key])){
                                $price = trim($_POST['price'][$key]);
                            }
                            if(isset($_POST['totalPrice'][$key])){
                                $totalPrice = trim($_POST['totalPrice'][$key]);
                            }
                            if(isset($_POST['InventoryHeader']['vendor_id'][$key])){
                                $vendor_id = trim($_POST['InventoryHeader']['vendor_id'][$key]);
                            }

                            if (isset($purchaseLineMap[$id])) {
                                $purchaseLine = $purchaseLineMap[$id];
                            }
                            else if(!empty($order_qty) || !empty($received_qty)){
                                $purchaseLine = new PurchaseLine();
                                $purchaseLine->purchase_id = $model->id;
                                $purchaseLine->base_product_id = $id;
                                $purchaseLine->created_at = date("y-m-d H:i:s");

                            }
                            if(isset($purchaseLine)){
                                if($order_qty != ""){
                                    $purchaseLine->order_qty = $order_qty;
                                }

                                if($received_qty != ""){
                                    $purchaseLine->received_qty = $received_qty;
                                }
                                if($price != ''){
                                    $purchaseLine->unit_price = $price;
                                }
                                if($price != ''){
                                    $purchaseLine->price = $totalPrice;
                                }
                                if($vendor_id != ''){
                                    $purchaseLine->vendor_id = $vendor_id;
                                }


                                $purchaseLine->save();

                            }
                            else{
                                if(isset($purchaseLineMap[$id])){
                                    $purchaseLine = $purchaseLineMap[$id];
                                    $purchaseLine->deleteByPk($purchaseLine->id);
                                }

                            }

                            $parentIdToUpdate = $_POST['parent_id'][$key];
                        }
                    }


                    $transaction->commit();
                    if($parentIdToUpdate != '' && $parentIdToUpdate > 0){
                        array_push($parentIdArr, $parentIdToUpdate);
                    }
                    $this->updateParentsItems($parentIdArr, $model->id);
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

        $priceMap = VendorDao::getAllVendorsPriceMap();
		$this->render('update',array(
			'model'=>$model,
            'inv_header'=>$inv_header,
            //'purchaseLineMap'=> $purchaseLineMap,
            'dataProvider'=>$dataProvider,
            //'otherItems'=> $otherItems,
            'w_id' => $_GET['w_id'],
            'update'=>true,
            'priceMap' => $priceMap,
		));
	}


	private function updateParentsItems($parentIdArr, $purchaseId){
        foreach ($parentIdArr as $parentId){
            if($parentId > 0 ){
                $orderQty = 0;
                $receivedQty = 0;
                $tobe_procured_qty = 0;
                $childIds = BaseProduct::getChildBPIds($parentId);
                foreach ($childIds as $bp_id){
                    $pl = PurchaseLine::model()->findByAttributes(array('base_product_id'=>$bp_id, 'purchase_id'=>$purchaseId));
                    if($pl){
                        $orderQty += $pl->order_qty;
                        $receivedQty += $pl->received_qty;
                        $tobe_procured_qty += $pl->tobe_procured_qty;
                    }

                }
                $parentPl = PurchaseLine::model()->findByAttributes(array('base_product_id'=>$parentId, 'purchase_id'=>$purchaseId));
                if($parentPl==false && ($orderQty>0 || $receivedQty>0 || $tobe_procured_qty > 0)){
                    $parentPl = new PurchaseLine();
                    $parentPl->purchase_id = $purchaseId;
                    $parentPl->base_product_id = $parentId;
                    $parentPl->created_at = date('Y-m-d');
                }
                if($parentPl){
                    $parentPl->order_qty = $orderQty;
                    $parentPl->received_qty = $receivedQty;
                    $parentPl->tobe_procured_qty = $tobe_procured_qty;
                    $parentPl->save();
                }

            }
        }
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
                if($qty < 0) {
                    $qty=0;
                }
                if (isset($purchaseLineMap[$bp_id])) {
                    $item = $purchaseLineMap[$bp_id];

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
        //echo "<pre>";
        $w_id = $_GET['w_id'];
        $sourceWId = SOURCE_WH_ID;
        $headOffId = HD_OFFICE_WH_ID;
        if($w_id != $sourceWId){
            return;
        }
        $date = $_GET['date'];
        $data = array();
        $sql = 'select pl.base_product_id, bp.title as title, bp.grade as grade, wa.name as warehouse, sum(pl.tobe_procured_qty) as tobe_procured_qty, sum(pl.order_qty) as procured_qty, sum(pl.received_qty) as received_qty from groots_orders.purchase_line as pl 
        left join purchase_header as ph on ph.id = pl.purchase_id left join cb_dev_groots.base_product as bp on pl.base_product_id = bp.base_product_id left join cb_dev_groots.warehouses as wa on ph.warehouse_id = wa.id
        left join cb_dev_groots.product_category_mapping pcm on pcm.base_product_id=bp.base_product_id
         where ph.status not in ("failed", "cancelled") and ph.delivery_date = '.'"'.$date.'"'.'and ph.warehouse_id = '.$w_id.' and pl.tobe_procured_qty > 0 group by pl.base_product_id order by pcm.category_id asc, bp.base_title asc, bp.priority asc ';
           $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sql);
        $command->execute();
        $dataArray = $command->queryAll();
        if(!isset($dataArray) || empty($dataArray)){
            Yii::app()->user->setFlash('error', 'nothing to download...');
            Yii::app()->controller->redirect("index.php?r=purchaseHeader/admin&w_id=".$w_id);
        }

        $sql = 'select name, id from cb_dev_groots.warehouses order by id';
        $command = $connection->createCommand($sql);
        $command->execute();
        $res = $command->queryAll();
        $warehouses = array();
        $nameArr = array();
        foreach ($res as $key => $wh) {
            $w_name = "For ".explode(',', $wh['name'])[0];
            $warehouses[$wh['id']] = $w_name;
            if($wh['id'] != $headOffId){
                array_push($nameArr, $w_name);
            }
        }

        foreach ($dataArray as $d){
            $tmp = array();
            //$tmp['item'] = $d['title'];
            $tmp['item'] = $d['title'];
            $tmp['grade'] = $d['grade'];
            $tmp['tobe_procured_qty'] = $d['tobe_procured_qty'];
            $tmp['procured'] = $d['procured_qty'];
            $tmp['received_by_operation'] = $d['received_qty'];
            foreach ($nameArr as $name){
                $tmp[$name] = 0;
            }
            $data[$d['base_product_id']] = $tmp;
        }

        foreach ($warehouses as $wh_id => $name) {

            if ($wh_id ==  HD_OFFICE_WH_ID){
                continue;
            }
            $sql = 'select tl.base_product_id, tl.order_qty from groots_orders.transfer_header as th
            join groots_orders.transfer_line as tl
            on th.id = tl.transfer_id
            join cb_dev_groots.base_product as bp
            on bp.base_product_id = tl.base_product_id
            join cb_dev_groots.warehouses sw on sw.id = th.source_warehouse_id
            join cb_dev_groots.warehouses dw on dw.id = th.dest_warehouse_id
            where  th.delivery_date = "'.$date.'" and th.status != "cancelled" and th.source_warehouse_id='.$sourceWId.' and th.dest_warehouse_id='.$wh_id.' and th.transfer_type = "regular"';
            $command = $connection->createCommand($sql);
            $command->execute();
            $transfers = $command->queryAll();
            foreach ($transfers as $t){
                if(isset($data[$t['base_product_id']])){
                    $tmp = $data[$t['base_product_id']];

                    $tmp[$name] = $t['order_qty'];
                    $data[$t['base_product_id']] = $tmp;
                }
            }
        }
        //print_r(reset($data));die;
        //print_r($data);die;

        $fileName = $date."procurement_report".".csv";
        ob_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);

        if (count($data > 0)) {
            $fp = fopen('php://output', 'w');
            //$columnstring = implode(',', array_keys($data[0]));
            $columnstring = implode(',', array_keys(reset($data)));

            $updatecolumn = str_replace('_', ' ', $columnstring);

            $updatecolumn = explode(',', $updatecolumn);
            //print_r( $updatecolumn); die;
            fputcsv($fp, $updatecolumn);
            foreach ($data AS $values) {
                fputcsv($fp, $values);
            }

            fclose($fp);
        }
        ob_flush(); 
    }
}
