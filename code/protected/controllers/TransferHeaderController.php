<?php

class TransferHeaderController extends Controller
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
				'actions'=>array('create','update','admin', 'dailyTransfer', 'downloadTransferReport'),
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
            if($w_id>0 && $this->checkAccessByData('TransferViewer', array('warehouse_id'=>$w_id))){
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
        $model=new TransferHeader('search');
        //$model->unsetAttributes();
        $w_id = '';
        if(isset($_GET['w_id'])){
            $w_id = $_GET['w_id'];
        }
        if(!$this->checkAccessByData('TransferEditor', array('warehouse_id'=>$w_id))){
            Yii::app()->user->setFlash('premission_info', 'You dont have permission.');
            Yii::app()->controller->redirect("index.php?r=transferHeader/admin&w_id=".$w_id);
        }
        list($popularItems, $otherItems) = BaseProduct::PopularItems();
        $dataProvider=new CArrayDataProvider($popularItems, array(
            'pagination'=>array(
                'pageSize'=>100,
            ),
        ));
//print_r($_POST);die;
        //print_r($otherItems);die;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['transfer-create']))
        {
            //$transaction = Yii::app()->db->beginTransaction();
            try {
//print_r($_POST);die;
                $model->attributes=$_POST['TransferHeader'];
                $model->created_at = date('Y-m-d');
                //print_r($model);die;

                if($model->save()){

                    foreach ($_POST['order_qty'] as $key => $order_qty) {
                        if ($order_qty > 0) {
                            $transferLine = new TransferLine();
                            $transferLine->transfer_id = $model->id;
                            $transferLine->base_product_id = $_POST['base_product_id'][$key];
                            if(isset($_POST['order_qty'][$key]) && $_POST['order_qty'][$key] > 0){
                                $transferLine->order_qty = $_POST['order_qty'][$key];
                            }
                            if(isset($_POST['delivered_qty'][$key]) && $_POST['delivered_qty'][$key] > 0){
                                $transferLine->delivered_qty = $_POST['delivered_qty'][$key];
                            }
                            if(isset($_POST['received_qty'][$key]) && $_POST['received_qty'][$key] > 0){
                                $transferLine->received_qty = $_POST['received_qty'][$key];
                            }

                            //$transferLine->unit_price = $_POST['store_offer_price'][$key];
                                $transferLine->created_at = date("y-m-d H:i:s");
                            $transferLine->save();
                        }
                    }
                    //$transaction->commit();
                    Yii::app()->controller->redirect(array('admin','w_id'=>$w_id));
                }
                else{
                    Yii::app()->user->setFlash('error', 'Transfer order Creation failed.');
                }
            } catch (\Exception $e) {
                //$transaction->rollBack();
                Yii::app()->user->setFlash('error', 'Transfer order Creation failed.');
                throw $e;
            }

        }

        $this->render('create',array(
            'model'=>$model,
            'dataProvider'=>$dataProvider,
            'otherItems'=> $otherItems,
            'w_id' => $_GET['w_id'],
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
        if(!$this->checkAccessByData('TransferEditor', array('warehouse_id'=>$w_id))){
            Yii::app()->user->setFlash('premission_info', 'You dont have permission.');
            Yii::app()->controller->redirect("index.php?r=transferHeader/admin&w_id=".$w_id);
        }
        $model=$this->loadModel($id);
        $transferLines = TransferLine::model()->findAllByAttributes(array('transfer_id' => $id));
        list($popularItems, $otherItems) = BaseProduct::PopularItems();
        $transferLineMap = array();
        $transferLinesArr = array();
        foreach ($transferLines as $item){
            //var_dump($item->BaseProduct); die;
            $transferLineMap[$item->base_product_id] = $item;
            array_push($transferLinesArr,$item);
        }

        $dataProvider=new CArrayDataProvider($transferLinesArr, array(
            'pagination'=>array(
                'pageSize'=>100,
            ),
        ));
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['transfer-update'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {

                $model->attributes = $_POST['TransferHeader'];

                if ($model->save()) {
                    foreach ($_POST['order_qty'] as $key => $order_qty) {
                        //$orderQt = $_POST['product_qty'][$key];
                        $order_qty = trim($_POST['order_qty'][$key]);
                        $delivered_qty = trim($_POST['delivered_qty'][$key]);
                        $received_qty = trim($_POST['received_qty'][$key]);

                        if(!isset($order_qty) || empty($order_qty)){
                            $order_qty = 0;
                        }
                        if(!isset($delivered_qty) || empty($delivered_qty)){
                            $delivered_qty = 0;
                        }
                        if(!isset($received_qty) || empty($received_qty)){
                            $received_qty = 0;
                        }


                        //echo "ord ".$order_qty." delv ".$delivered_qty." rec ".$received_qty;die;
                        if ($order_qty > 0 || $delivered_qty > 0 || $received_qty > 0) {
                            if(isset($transferLineMap[$_POST['base_product_id'][$key]])){
                                $transferLine = $transferLineMap[$_POST['base_product_id'][$key]];
                            }
                            else{
                                $transferLine = new TransferLine();
                                $transferLine->transfer_id = $model->id;
                                $transferLine->base_product_id = $_POST['base_product_id'][$key];
                                $transferLine->created_at = date("y-m-d H:i:s");

                            }

                            $transferLine->order_qty = $order_qty;
                            $transferLine->delivered_qty = $delivered_qty;
                            $transferLine->received_qty = $received_qty;

                            $transferLine->save();
                        }
                        else{
                            if(isset($transferLineMap[$_POST['base_product_id'][$key]])){
                                $transferLine = $transferLineMap[$_POST['base_product_id'][$key]];
                                $transferLine->deleteByPk($transferLine->id);
                            }

                        }
                    }
                    $transaction->commit();
                    Yii::app()->controller->redirect(array('admin','w_id'=>$w_id));
                }
                else{
                    Yii::app()->user->setFlash('error', 'Transfer order Update failed.');
                }
            }catch (\Exception $e) {
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', 'Transfer order Creation failed.');
                throw $e;
            }
        }


        $this->render('update',array(
            'model'=>$model,
            'transferLines'=> $transferLines,
            'dataProvider'=>$dataProvider,
            'otherItems'=> $otherItems,
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
		$dataProvider=new CActiveDataProvider('TransferHeader');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
	    //echo "<pre>";
        //print_r($_GET);die;
        $model = new TransferHeader();
		$transferIn=new TransferHeader('search');
        $transferOut=new TransferHeader('search');

        $transferIn->unsetAttributes();  // clear any default values
        $transferOut->unsetAttributes();
        $w_id = $_GET['w_id'];
        $transferIn->dest_warehouse_id = $w_id;
        $transferOut->source_warehouse_id = $w_id;
        if(isset($_GET['TransferIn'])) {
            $transferIn->attributes = $_GET['TransferIn'];
        }
        if(isset($_GET['TransferOut'])) {
            $transferOut->attributes = $_GET['TransferOut'];
        }
        $transferInDataProvider=$transferIn->searchNew();

        $transferOutDataProvider=$transferOut->searchNew();
		$this->render('admin',array(
			'transferInDataProvider'=>$transferInDataProvider,
            'transferIn'=> $transferIn,
            'transferOutDataProvider'=> $transferOutDataProvider,
            'transferOut'=>$transferOut,
            'w_id' => $w_id,
            'model' => $model
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TransferHeader the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TransferHeader::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TransferHeader $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='transfer-header-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionDailyTransfer(){
        //echo "<pre>";
        if(empty($_GET['w_id'])){
            Yii::app()->controller->redirect("index.php?r=user/profile");
        }
        $w_id = $_GET['w_id'];
        if(empty($_POST['TransferHeader']['delivery_date'])){
            //Yii::app()->controller->redirect(Yii::app()->request->urlReferrer);
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        $date = $_POST['TransferHeader']['delivery_date'];
        //$date = $this->getDateForDailyTransfer();
        $orderLines = OrderLine::getOrderSumByDate($w_id, $date);
        //print_r($orderLines);
        $invHeadMap = InventoryHeaderDao::getInventoryHeaderMapByBpId($w_id);
        $warehouse = Warehouse::model()->findByAttributes(array('id'=>$w_id), array('select'=>'default_source_warehouse_id'));
        $transferOrder = TransferHeader::model()->findByAttributes(array('delivery_date'=> $date, 'source_warehouse_id'=>$warehouse->default_source_warehouse_id , 'dest_warehouse_id'=>$w_id, 'transfer_type'=>'regular'));
        $quantitiesMap = TransferHeader::getTransferInCalculationData($w_id, $date);
        $transaction = Yii::app()->db->beginTransaction();
        try {

            if(empty($transferOrder)){
                $transferOrder = new TransferHeader();
                $transferOrder->source_warehouse_id = $warehouse->default_source_warehouse_id;
                $transferOrder->dest_warehouse_id = $w_id;
                $transferOrder->delivery_date = $date;
                $transferOrder->status = 'pending';
                $transferOrder->comment = 'system generated';
                $transferOrder->created_at = date('Y-m-d');
                $transferOrder->transfer_type = "regular";
            }
            $transferOrder->save();
            $transferLineMap = $this->getTransferLineMap($transferOrder->id);
            foreach ($orderLines as $bp_id => $qty){

                $s_inv = 0;
                if (isset($quantitiesMap['avgOrder'][$bp_id]) && isset($invHeadMap[$bp_id])){
                    $avgOrderInKg = $quantitiesMap['avgOrder'][$bp_id];
                    $sch_inv_type = $invHeadMap[$bp_id]->schedule_inv_type;
                    $sch_inv_no = $invHeadMap[$bp_id]->schedule_inv;
                    if($sch_inv_type == 'days'){
                        $s_inv = $sch_inv_no * $avgOrderInKg;
                    }
                    elseif($sch_inv_type == 'percents'){
                        $s_inv = $sch_inv_no * $avgOrderInKg/100;
                    }

                }
                $prev_day_inv = empty($quantitiesMap['prevDayInv'][$bp_id]) ? 0 : $quantitiesMap['prevDayInv'][$bp_id] ;
                
                //$cur_inv =  empty($data->present_inv) ? 0 : $data->present_inv ;
                //$liq_inv =  empty($data->liquid_inv) ? 0 : $data->liquid_inv ;
                $order_sum = empty($quantitiesMap['orderSum'][$bp_id]) ? 0 : $quantitiesMap['orderSum'][$bp_id] ;
                $purchase = empty($quantitiesMap['purchaseSum'][$bp_id]) ? 0 : $quantitiesMap['purchaseSum'][$bp_id] ;
                $transIn_other = empty($quantitiesMap['transferInSum'][$bp_id]) ? 0 : $quantitiesMap['transferInSum'][$bp_id] ;
                $trans_out = empty($quantitiesMap['transferOutSum'][$bp_id]) ? 0 : $quantitiesMap['transferOutSum'][$bp_id] ;

                $extra_inv_absolute =$invHeadMap[$bp_id]->extra_inv * ($order_sum-$prev_day_inv+$trans_out+$s_inv)/100;
                if($extra_inv_absolute < 0){
                    $extra_inv_absolute = 0;
                }
//echo "sinv-".$s_inv."\n";
                /*echo "ord-".$order_sum."\n";
                echo "tranout-".$trans_out."\n";
                echo "extinv-".$extra_inv_absolute."\n";
                echo "prvin-".$prev_day_inv."\n";
                echo "purch-".$purchase."\n";
                echo "transInother-".$transIn_other."\n";*/

                $trans_in = $s_inv+$order_sum+$trans_out+$extra_inv_absolute - ($purchase+$prev_day_inv+$transIn_other);

                if(empty($trans_in) || $trans_in < 0) {
                    $trans_in = 0;
                }
                //echo "transin-".$trans_in."\n";
                if(isset($transferLineMap[$bp_id])){
                    $item = $transferLineMap[$bp_id];
                }
                else{
                    $item = new TransferLine();
                    $item->transfer_id = $transferOrder->id;
                    $item->base_product_id = $bp_id;
                    $item->status = 'pending';
                    $item->created_at = date('Y-m-d');
                }
                $item->order_qty = $trans_in;
                //var_dump($item);
                $item->save();
            }
            $transaction->commit();
            Yii::app()->controller->redirect(Yii::app()->request->urlReferrer);
        }catch (\Exception $e) {
            $transaction->rollBack();
            Yii::app()->user->setFlash('error', 'Transfer order Creation failed.');
            throw $e;
            Yii::app()->controller->redirect(Yii::app()->request->urlReferrer);
        }

    }

    public function actionDownloadTransferReport(){
        $sql = 'select tl.base_product_id, bp.title, th.source_warehouse_id , th.dest_warehouse_id, th.delivery_date,  tl.order_qty, tl.delivered_qty, tl.received_qty from groots_orders.transfer_header as th
            left join groots_orders.transfer_line as tl
            on th.id = tl.transfer_id
            left join cb_dev_groots.base_product as bp
            on bp.base_product_id = tl.base_product_id
            where tl.order_qty is not null and tl.order_qty > 0  and ( tl.delivered_qty != tl.received_qty or tl.delivered_qty is null or tl.received_qty is null) and th.delivery_date = CURDATE() and th.status = "received" and tl.status = "Confirmed"';
        $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sql);
        $command->execute();
        $dataArray = $command->queryAll();
        $fileName = date('Y-m-d')."tranfer_report.csv";
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

    private function getTransferLineMap($transfer_id){
        $itemArr = array();
        $items = TransferLine::model()->findAllByAttributes(array('transfer_id'=>$transfer_id));
        foreach ($items as $item){
            $itemArr[$item->base_product_id] = $item;
        }
        return $itemArr;
    }

    private function getDateForDailyTransfer(){

    }
}
