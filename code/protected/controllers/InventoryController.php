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
				'actions'=>array('create','update','admin','downloadWastageReport','bulkUpload','updateFileDownload'),
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
		//print_r($_POST);
        //print_r($_GET);


        $w_id = '';
        if(isset($_GET['w_id'])){
            $w_id = $_GET['w_id'];
        }
        $editOnly = true;
        if(!$this->checkAccessByData('InventoryEditor', array('warehouse_id'=>$w_id))){
            Yii::app()->user->setFlash('premission_info', 'You dont have permission.');
            Yii::app()->controller->redirect("index.php?r=inventory/create&w_id=".$w_id);
        }
        if($this->checkAccess('SuperAdmin')){
            $editOnly = false;
        }

        $inv_header = new InventoryHeader('search');
        //$date = date('Y-m-d');
        //$date = "2016-09-15";

        if(isset($_POST['inventory-date']) && !empty($_POST['InventoryHeader'])){
            $date = $_POST['InventoryHeader']['date'];
        }
        elseif(!empty($_POST['InventoryHeader'])){
            if(!empty($_POST['InventoryHeader']['date'])){
                $date = $_POST['InventoryHeader']['date'];
            }
            else{
                $date = date('Y-m-d');
            }
        }
        elseif(!empty($_GET['date'])){
            $date = $_GET['date'];
        }
        else{
            $date = date('Y-m-d');
            //$date = "2016-10-10";
        }
        
        $inv_header->date = $date;
        $inv_header->warehouse_id = $w_id;
        //$model->warehouse_id = $w_id;
        if(isset($_GET['InventoryHeader'])) {
            $inv_header->attributes = $_GET['InventoryHeader'];
        }
        $date = $inv_header->date;

        $dataProvider = $inv_header->search();
        //var_dump($dataProvider); die;
        $quantitiesMap = Inventory::getInventoryCalculationData($w_id, $date);

        $totalInvData = Inventory::getTotalInvOfDate($w_id, $date);
        $totalInvDataProvider = new CArrayDataProvider($totalInvData);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['inventory-create']))
		{
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $date = $_POST['InventoryHeader']['date'];
                $warehouse_id = $_POST['InventoryHeader']['warehouse_id'];
                $parentIdArr = array();
                $parentIdToUpdate = '';
                if(isset($_POST['parent_id'][0]) && $_POST['parent_id'][0] >= 0){
                    array_push($parentIdArr, $_POST['parent_id'][0]);
                }
                foreach ($_POST['base_product_id'] as $key => $bp_id) {
                    //$delivered_qty = trim($_POST['schedule_inv'][$key]);
                    $parentIdToUpdate = $_POST['parent_id'][$key];
                    $schedule_inv = trim($_POST['schedule_inv'][$key]);
                    $present_inv = trim($_POST['present_inv'][$key]);
                    $liquid_inv = trim($_POST['liquid_inv'][$key]);
                    $wastage = trim($_POST['wastage'][$key]);
                    $liquidation_wastage = trim($_POST['liquidation_wastage'][$key]);
                    $extra_inv = trim($_POST['extra_inv'][$key]);
                    $balance = trim($_POST['balance'][$key]);
                    $secondary_sale = 0;
                    if(!empty($_POST['secondary_sale'][$key])){
                        $secondary_sale = trim($_POST['secondary_sale'][$key]);
                    }

                    if(true){
                        /*echo "present_inv-".$present_inv;
                        echo "present_inv-".$wastage;
                        echo "present_inv-".$wastage_others;die;*/
                        $inv = Inventory::model()->findByAttributes(array('base_product_id'=>$bp_id, 'date'=>$date, 'warehouse_id'=>$warehouse_id));
                        if($inv==false){
                            $inv = new Inventory();
                            $inv->warehouse_id = $warehouse_id;
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
                        $inv->present_inv = empty($present_inv) ? 0: $present_inv;
                        $inv->liquid_inv = empty($liquid_inv) ? 0: $liquid_inv;
                        $inv->wastage = empty($wastage) ? 0: $wastage;
                        $inv->liquidation_wastage = empty($liquidation_wastage) ? 0: $liquidation_wastage;
                        $inv->extra_inv = empty($extra_inv) ? 0: $extra_inv;
                        $inv->balance = empty($balance) ? 0: $balance;
                        $inv->secondary_sale = empty($secondary_sale) ? 0: $secondary_sale;
                        //var_dump($inv);die;
                        $inv->save();

                    }
                }
                if($parentIdToUpdate != '' && $parentIdToUpdate > 0){
                    array_push($parentIdArr, $parentIdToUpdate);
                }
                $transaction->commit();
            }catch (\Exception $e) {
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', 'Transfer order Creation failed.');
                throw $e;
            }
            $transaction = Yii::app()->db->beginTransaction();
            try{
                foreach ($parentIdArr as $parentId){
                    if($parentId > 0 ){
                        $schedule_inv = 0;
                        $present_inv = 0;
                        $liquid_inv = 0;
                        $wastage = 0;
                        $liquidation_wastage = 0;
                        $extra_inv = 0;
                        $balance = 0;
                        $childIds = BaseProduct::getChildBPIds($parentId);
                        foreach ($childIds as $bp_id){
                            $inv = '';
                            $inv = Inventory::model()->findByAttributes(array('base_product_id'=>$bp_id, 'date'=>$date, 'warehouse_id'=>$warehouse_id));
                            if($inv){
                                $present_inv += $inv->present_inv;
                                $liquid_inv += $inv->liquid_inv;
                                $wastage += $inv->wastage;
                                $liquidation_wastage += $inv->liquidation_wastage;
                                $extra_inv += $inv->extra_inv;
                                $balance += $inv->balance;
                                $schedule_inv += $inv->schedule_inv;
                            }

                        }
                        $parentInv = Inventory::model()->findByAttributes(array('base_product_id'=>$parentId, 'date'=>$date, 'warehouse_id'=>$warehouse_id));
                        if($parentInv==false){
                            $parentInv = new Inventory();
                            $parentInv->warehouse_id = $warehouse_id;
                            $parentInv->base_product_id = $parentId;
                            $parentInv->date = $date;
                            $parentInv->inv_id = null;
                            $parentInv->created_at = date('Y-m-d');
                        }
                        $parentInv->schedule_inv = $schedule_inv;
                        $parentInv->present_inv = $present_inv;
                        $parentInv->liquid_inv = $liquid_inv;
                        $parentInv->wastage = $wastage;
                        $parentInv->liquidation_wastage = $liquidation_wastage;
                        $parentInv->extra_inv = $extra_inv;
                        $parentInv->balance = $balance;
                        $parentInv->save();
                    }
                }

                $this->redirect(array('create','w_id'=>$w_id, 'date'=>$date));

            }catch (\Exception $e) {
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', 'Transfer order Creation failed.');
                throw $e;
            }
		}

		$this->render('create',array(
            'model'=>$inv_header,
            'dataProvider'=>$dataProvider,
            'totalInvData' => $totalInvDataProvider,
            'w_id' => $_GET['w_id'],
            'quantitiesMap' => $quantitiesMap,
            'editOnly' => $editOnly,
		));
	}

    public function actionDownloadWastageReport(){
        //var_dump($_GET); echo "ehll"; die;


        //echo "<pre>";
        $date = $_GET['date'];
        $w_id = $_GET['w_id'];
        $select = "bp.title,i.base_product_id,  wa.name, i.present_inv, i.liquid_inv, i.wastage, i.liquidation_wastage, i.balance";
        // $dataArray = Inventory::model()->findAllByAttributes(array('warehouse_id' => $w_id , 'date' => $date),array('select' => $select));
        $sql = 'select '.$select.' from groots_orders.inventory as i left join cb_dev_groots.warehouses as wa on i.warehouse_id = wa.id left join cb_dev_groots.base_product as bp on i.base_product_id = bp.base_product_id 
        left join cb_dev_groots.product_category_mapping pcm on pcm.base_product_id=bp.base_product_id
        where date = '."'".$date."' order by pcm.category_id asc, bp.base_title asc, bp.priority asc";
        $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sql);
        $command->execute();
        $data = $command->queryAll();
        if(!isset($data) || empty($data)){
            Yii::app()->user->setFlash('error', 'nothing to download...');
            Yii::app()->controller->redirect("index.php?r=inventory/create&w_id=".$w_id);
        }
        $dataArray = $this->arrangeWastageReportData($data);
        // var_dump($dataArray);die;
        $fileName = $date."_wastageReport.csv";
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

	/*public function  actionAdmin(){
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
    }*/

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

    public function arrangeWastageReportData($data){
        $sql = 'select distinct name, id from cb_dev_groots.warehouses order by id';
        $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sql);
        $command->execute();
        $warehouses = $command->queryAll();
        $tempArray = array();
        foreach ($data as $key => $value) {
            if(isset($tempArray[$value['base_product_id']])){
                $row = $tempArray[$value['base_product_id']];
            }
            else{
                $row = array('title' => null);
                foreach ($warehouses as $key1 => $warehouse) {
                    if($warehouse['id'] == HD_OFFICE_WH_ID){
                        continue;
                    }
                    $nameSplit = explode(',', $warehouse['name']);
                    $warehouse['name'] = $nameSplit[0];
                    $row[$warehouse['name'].'_inv'] = null;
                    $row[$warehouse['name'].'_liq_inv'] = null;
                    $row[$warehouse['name'].'_wastage'] = null;
                    $row[$warehouse['name'].'_liquidation_wastage'] = null;
                    $row[$warehouse['name'].'_balance'] = null;
                    $row['separator'.$key1] = null;
                }
            }

            $nameSplit = explode(',', $value['name']);
            $value['name'] = $nameSplit[0];
            $w_name = $value['name'];
            $row[$w_name.'_inv'] = $value['present_inv'];
            $row[$w_name.'_liq_inv'] = $value['liquid_inv'];
            $row[$w_name.'_wastage'] = $value['wastage'];
            $row[$w_name.'_liquidation_wastage'] = $value['liquidation_wastage'];
            $row[$w_name.'_balance'] = $value['balance'];
            $row['title'] = $value['title'];
            /*if(!array_key_exists($value['base_product_id'], $tempArray)){
                $row['title'] = $value['title'];
            }*/
            $tempArray[$value['base_product_id']] = $row;
        }
        $finalArray = array();
        foreach ($tempArray as $key => $temp) {
            array_push($finalArray, $temp);
        }
        return $finalArray;
    }

    public function actionBulkUpload() {

        $w_id = '';
        if(isset($_GET['w_id'])){
            $w_id = $_GET['w_id'];
        }
        if(!$this->checkAccessByData('InventoryEditor', array('warehouse_id'=>$w_id))){
            Yii::app()->user->setFlash('premission_info', 'You dont have permission.');
            Yii::app()->controller->redirect("index.php?r=inventory/create&w_id=".$w_id);
        }

        $logTemplate = array('id', 'base_product_id', 'action', 'status', 'error');
        set_time_limit(0);
        $logfile = '';
        $baseid = '';
        $model = new Bulk();
        $keycsv = 1;
        $csv_filename = '';
        $insert_base_csv_info = array();
        $insert_base_csv_info[$keycsv]['base_product_id'] = 'base_product_id';
        $insert_base_csv_info[$keycsv]['model_name'] = 'model_name';
        $insert_base_csv_info[$keycsv]['model_number'] = 'model_number';
        $keycsv++;
        $cateogryarray = array();

        if (isset($_POST['Bulk'])) {

            $model->action = 'update';
            $model->attributes = $_POST['Bulk'];
            if (!empty($_FILES['Bulk']['tmp_name']['csv_file'])) {
                $csv = CUploadedFile::getInstance($model, 'csv_file');
                if (!empty($csv)) {
                    if ($csv->size > 30 * 1024 * 1024) {
                        Yii::app()->user->setFlash('error', 'Cannot upload file greater than 30 MB.');
                        $this->render('bulkupload', array('model' => $model));
                    }
                    $fileName = 'csvupload/' . $csv->name;
                    $filenameArr = explode('.', $fileName);
                    $fileName = $filenameArr[0] . '-' . Yii::app()->session['sessionId'] . '-' . time() . '.' . end($filenameArr);
                    $csv->saveAs($fileName);
                } else {

                    Yii::app()->user->setFlash('error', 'Please browse a CSV file to upload.');
                    $this->render('bulkupload', array('model' => $model));
                }
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                if ($ext != 'csv') {
                    Yii::app()->user->setFlash('error', 'Only .csv files allowed.');
                    $this->render('bulkupload', array('model' => $model));
                }
                if (isset($insert_base_csv_info) && !empty($insert_base_csv_info)) {
                    $csv_filename = LOG_BASE_PDT_DIR . uniqid() . '.csv';
                    $logfile = fopen($csv_filename, "a");
                    $uploadedFile = fopen($fileName, 'r');
                    fputcsv($logfile, $logTemplate);
                    Inventory::readInventoryUploadedFile($uploadedFile, $logfile, $w_id);

                    fclose($logfile);
                }
            }
        }


        // @unlink($fileName);
        $this->render('bulkupload', array(
            'model' => $model,
            'logfile' => $logfile,
            'csv_filename' => $csv_filename,
            'w_id' => $w_id,
        ));
    }

    public function actionUpdateFileDownload(){
//print_r($_GET);die("here");
        $date = $_GET['date'];
        $w_id = $_GET['w_id'];
        $select = "ih.base_product_id, bp.title,ih.id, wa.name, '".$date."' as date, i.present_inv, i.liquid_inv, i.wastage, i.liquidation_wastage, i.secondary_sale,bp.parent_id";
        // $dataArray = Inventory::model()->findAllByAttributes(array('warehouse_id' => $w_id , 'date' => $date),array('select' => $select));
        $sql = 'select '.$select.' from groots_orders.inventory_header ih  left join cb_dev_groots.warehouses as wa on ih.warehouse_id = wa.id 
        left join groots_orders.inventory i on i.inv_id=ih.id and date = "'.$date.'"
        left join cb_dev_groots.base_product as bp on ih.base_product_id = bp.base_product_id 
        left join cb_dev_groots.product_category_mapping pcm on pcm.base_product_id=bp.base_product_id
        where ih.warehouse_id='.$w_id.' and parent_id > 0 order by pcm.category_id asc, bp.base_title asc, bp.priority asc';
        $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sql);
        $command->execute();
        $data = $command->queryAll();
        //echo $sql;die;
        if(!isset($data) || empty($data)){
            //Yii::app()->user->setFlash('error', 'nothing to download...');
            Yii::app()->controller->redirect("index.php?r=inventory/bulkUpload&w_id=".$w_id);
        }
        //$dataArray = $this->arrangeWastageReportData($data);
        // var_dump($dataArray);die;
        $fileName = $date."_InvBulkUpload.csv";
        ob_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);

        if (isset($data['0'])) {
            $fp = fopen('php://output', 'w');
            $columnstring = implode(',', array_keys($data['0']));
            $updatecolumn = str_replace('_', ' ', $columnstring);

            $updatecolumn = explode(',', $updatecolumn);
            fputcsv($fp, $updatecolumn);
            foreach ($data AS $values) {
                fputcsv($fp, $values);
            }
            fclose($fp);
        }
        ob_flush();
    }


}
