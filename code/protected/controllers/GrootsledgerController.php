<?php

class GrootsledgerController extends Controller
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
				'actions'=>array('index','view','admin','report'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','report','adminOld','createPayment', 'updatePayment','dailyCollection','totalpayable'),
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
		$model=new Grootsledger;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Grootsledger']))
		{
			$model->attributes=$_POST['Grootsledger'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->Max_id));
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
	public function actionUpdate()
	{    


       //..................select info ledger.............//

         $ledger=new GrootsLedger();
         $ledgerinfo=$ledger->getinfo($_POST['pk']);


          if(!is_numeric($_POST['value']))
          {
               
                        echo CJSON::encode(array('success' => false, 'msg' => 'Please Enter Only Numeric value.'));
                    return;
                
                
          }
          else
         {
         if(isset($ledgerinfo[0]['due_amount']))
         {
         //..................inset into ledege..............//

         	if($_POST['value'] > $ledgerinfo[0]['due_amount'])
         	{
                echo CJSON::encode(array('success' => false, 'msg' => 'Paid Amount is must  less than or equal to Due Amount.'));
                    return;
         	}
         	else
         	{
              $dueamount='';
              $posvalue='';
              if($_POST['value'] < 0)
              {
              	$posvalue=$_POST['value'];
              	$_POST['value']=-$_POST['value'];
              	$dueamount=$ledgerinfo[0]['due_amount']+$_POST['value']; 
              	if($dueamount > $ledgerinfo[0]['total_amount'])
              	{
              		echo CJSON::encode(array('success' => false, 'msg' => 'Due Amount must  less than or equal to total_payable_amount.'));
                    return;
              	}
              }
              else
              {
                 $dueamount=$ledgerinfo[0]['due_amount']-$_POST['value'];
                 $posvalue= $_POST['value'];  
              }         
	           
	           if($posvalue < 0)  
	           {
	           	$ledger->putreturninfo($ledgerinfo[0]['id'],$_POST['value'],$dueamount);
	           }  
	           else
	           {
	           	$ledger->putinfo($ledgerinfo[0]['id'],$posvalue,$dueamount);
	           }  
	             
	       }
         //............................end.......................//
        }
        else
        {

         $ledgero=new OrderHeader();
         $ledgerinfoo=$ledgero->getinfo($_POST['pk']);  
         if($_POST['value'] > $ledgerinfoo[0]['total_payable_amount'])
         	{
                echo CJSON::encode(array('success' => false, 'msg' => 'Paid Amount is must greater less than or equal to Total Amount.'));
                    return;
         	}
         	elseif($_POST['value'] < 0)
	          {
	          	  echo CJSON::encode(array('success' => false, 'msg' => 'Paid Amount is must greater than 0.'));
	                    return;
	          }
         	else
         	{

	         $ledgerr=new GrootsLedger();   	
	         $ledgerr->putinfonew($ledgerinfoo,$_POST['value']);
            }

        }
           echo CJSON::encode(array('success' => true, 'msg' => 'ok done.'));
                    return;
    }

      


       //...................end.........................//


	}

	public function actionreport()
	{    


      $this->render('report');
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
		$dataProvider=new CActiveDataProvider('Grootsledger');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

    public function actionCreatePayment(){
        //print("<pre>");
        //print_r($_POST);die;
        $retailerId = $_GET['retailerId'];
        $retailer = Retailer::model()->findByPk($retailerId);
        $retailerPayment = new RetailerPayment();
        if(isset($_POST['create'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {
                //$retailerPayment = new RetailerPayment();
                //$retailerPayment->load($_POST['RetailerPayment']);
                $retailerPayment->attributes = $_POST['RetailerPayment'];
                $retailerPayment->created_at = date('Y-m-d');
                if ($retailerPayment->save()) {
                    $retailer->total_payable_amount -= $retailerPayment->paid_amount;
                    
                    if($retailer->total_payable_amount == 0){
                      $retailer->collection_fulfilled = true;
                    }
                    else{
                      $retailer->collection_fulfilled = false; 
                    }
                    $retailer->save();
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Payment has been saved');
                    $this->redirect($this->createUrl('Grootsledger/admin', array('retailerId' => $retailerPayment->retailer_id)));
                } else
                    Yii::app()->user->setFlash('error', 'Payment could not be saved');
            }
            catch (\Exception $e) {
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', 'Payment could not be saved.');
                throw $e;
            }

        }
        $retailerPayment->retailer_id = $retailerId;
        $retailerPayment->retailerName = $retailer->name;
        $retailerPayment->totalPayableAmount = $retailer->total_payable_amount;
        //print_r($retailerPayment);die;

        //echo "here", die;
        $this->render('payment',array(
            'model'=>$retailerPayment,
            'retailerId' => $retailerId,
        ));
    }

    public function actionUpdatePayment(){
        //print("<pre>");
        //print_r($_POST);die;
        if(isset($_POST['update'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {
                //$retailerPayment = new RetailerPayment();
                $retailerPayment = RetailerPayment::model()->findByPk($_POST['RetailerPayment']['id']);
                $paid_amount = $retailerPayment->paid_amount;
                //$retailerPayment->load($_POST['RetailerPayment']);
                $intial_status = $retailerPayment->status;
                $retailerPayment->attributes = $_POST['RetailerPayment'];
                //var_dump(Yii::app()->request());die;
                //$retailerPayment = $retailerPayment->load(Yii::app()->request->post('RetailerPayment'));
                //print_r($retailerPayment);die;

                $retailerPayment->paid_amount = $_POST['RetailerPayment']['paid_amount'];
                $retailerPayment->date = $_POST['RetailerPayment']['date'];
                $retailerPayment->payment_type = $_POST['RetailerPayment']['payment_type'];
                $retailerPayment->cheque_no = $_POST['RetailerPayment']['cheque_no'];
                $retailerPayment->status = $_POST['RetailerPayment']['status'];
                $retailerPayment->comment = $_POST['RetailerPayment']['comment'];
                if ($retailerPayment->save()) {

                    $retailer = Retailer::model()->findByPk($retailerPayment->retailer_id);
                    if($intial_status != $retailerPayment->status && $retailerPayment->status == '0')
                      $retailer->total_payable_amount -=$retailerPayment->paid_amount;
                    else {
                    $retailer->total_payable_amount += $paid_amount;
                    $retailer->total_payable_amount -= $retailerPayment->paid_amount;
                  }
                    $retailer->save();
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Payment has been saved');
                    $this->redirect($this->createUrl('Grootsledger/admin', array('retailerId' => $retailerPayment->retailer_id)));
                } else
                    Yii::app()->user->setFlash('error', 'Payment could not be saved');
            }
            catch (\Exception $e) {
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', 'Payment could not be saved.');
                throw $e;
            }

        }
        $paymentId = $_GET['id'];
        if(!isset($retailerPayment)){
            $retailerPayment = RetailerPayment::model()->findByPk($paymentId);
        }
        if(!isset($retailer)) {
            $retailer = Retailer::model()->findByPk($retailerPayment->retailer_id);
        }

        $retailerPayment->retailerName = $retailer->name;
        $retailerPayment->totalPayableAmount = $retailer->total_payable_amount;
        //print_r($retailerPayment);die;
        //echo "here", die;
        $this->render('payment',array(
            'model'=>$retailerPayment,
            'update' => true,
        ));
    }

    public function actiondailyCollection(){
      // var_dump($_POST);
      // die();
      if(isset($_POST['update'])){
        self::updateDaily($_POST['retailer_id'], $_POST['collected_amount']);
      }
      //die('here');
      if(isset($_POST['update2'])){
          self::updatePending($_POST['pending_collection'],$_POST['pending_retailer_id']);
      }
      $retailers = QueriesDailyCollection::todaysCollection();
      $dataprovider = array();
      $dataprovider2 = array();
      $pendingRetailer = QueriesDailyCollection::yesterdayPendingCollection();
      $total_paid_yesterday = QueriesDailyCollection::totalPaidAmount();
      $total_paid_yesterday = $total_paid_yesterday['0']['total_paid_yesterday'];
      $total_due_amount = 0;
      $amount_to_be_collected = 0;
      foreach ($retailers as $rowinfo) {
        $amount_to_be_collected += $rowinfo['total_payable_amount'];
        $total_due_amount += $rowinfo['total_payable_amount'];
        $tmp = array();
        $tmp['yesterday_payment_received'] = $rowinfo['last_paid_amount'];
        $tmp['id'] = $rowinfo['id'];
        $tmp['name'] = $rowinfo['retailer_name'];
        $tmp['collection_frequency'] = $rowinfo['collection_frequency'];
        $tmp['collection_agent'] = $rowinfo['collection_agent'];
        $tmp['total_payable_amount'] = $rowinfo['total_payable_amount'];
        $tmp['collection_center'] = $rowinfo['collection_center'];
        $tmp['warehouse'] = $rowinfo['warehouse_name'];
        $tmp['todays_order_amount'] = $rowinfo['todays_order'];
        array_push($dataprovider, $tmp);
      }
      foreach ($pendingRetailer as $rowinfo) {
        $total_due_amount += $rowinfo['due_payable_amount'];
        $amount_to_be_collected += $rowinfo['total_payable_amount'];
        $tmp = array();
        $tmp['id'] = $rowinfo['id'];
        $tmp['name'] = $rowinfo['retailer_name'];
        $tmp['collection_frequency'] = $rowinfo['collection_frequency'];
        $tmp['collection_agent'] = $rowinfo['collection_agent'];
        $tmp['warehouse'] = $rowinfo['warehouse_name'];
        $tmp['total_payable_amount'] = $rowinfo['total_payable_amount'];
        $tmp['due_payable_amount'] = $rowinfo['due_payable_amount'];
        $tmp['collection_center'] = $rowinfo['collection_center'];
        $tmp['todays_order_amount'] = $rowinfo['todays_order'];
        $tmp['last_paid_amount'] = $rowinfo['last_paid_amount'];
        $tmp['last_due_date'] = $rowinfo['last_due_date'];
        $tmp['last_paid_on'] = $rowinfo['last_paid_on'];
        array_push($dataprovider2, $tmp);
      }
      $dataprovider = new CArrayDataProvider($dataprovider, array(

                    'sort'=>array(
                        'attributes'=>array(
                            'warehouse','name','collection_frequency','collection_agent','total_payable_amount','todays_order_amount','id','due_payable_amount','collection_center',
                        ),
                    ),'pagination'=>array('pageSize'=>100)));

      $dataprovider2 = new CArrayDataProvider($dataprovider2, array(

                    'sort'=>array(
                        'attributes'=>array(
                            'name','collection_frequency','collection_agent','total_payable_amount','todays_order_amount','last_paid_on','last_paid_amount','last_due_date','id','warehouse','due_payable_amount','collection_center',
                        ),
                    ),'pagination'=>array('pageSize'=>100)));
      
// die("here");
      if(isset($_GET['download']) && $_GET['download']==true){
      ob_clean();
          QueriesDailyCollection::downloadDailyCollectionCsv();
            ob_flush();
            exit();
        }

        if(isset($_GET['downloadPending']) && $_GET['downloadPending']==true){
      ob_clean();
          QueriesDailyCollection::downloadBackDateCollectionCsv();
            ob_flush();
            exit();
        }

       $this->render('dailyCollection',array(
          'data' => $dataprovider,
          'data2' => $dataprovider2,
          'amount_to_be_collected' => $amount_to_be_collected,
          'total_paid_yesterday' => $total_paid_yesterday,
          'total_due_amount' => $total_due_amount,
          ));
    }

       

    public function actionAdmin()
    {
        //print("<pre>");
        $retailer= new Retailer();
        $model = new OrderHeader();
        $retailerOrders ='';
        $retailerPayments = '';
        $hidden_retailer_id = '';
        $dataprovider = array();
        if(isset($_POST['retailer-dd'])){
            $retailerId = $_POST['retailer-dd'];
        }
        if(isset($_POST['hidden_retailer_id']) && !empty($_POST['hidden_retailer_id'])){
          $hidden_retailer_id = $_POST['hidden_retailer_id'];
        }

        if(!isset($retailerId) || empty($retailerId) ){
            if(isset($_GET['retailerId'])){
                $retailerId = $_GET['retailerId'];
            } 
        }
//echo $retailerId;die;
//print_r($_POST);die;
        if (isset($retailerId) || !empty($retailerId)) {


            if($retailerId>0) {
                $retailerOrders = OrderHeader::model()->findAllByAttributes(array('user_id'=>$retailerId ),array('condition'=>'status = "Delivered" and delivery_date >= "2016-09-01"' ,'order'=> 'delivery_date ASC'));
                $retailerPayments = RetailerPayment::model()->findAllByAttributes(array('retailer_id'=>$retailerId), array('condition'=>'status != 0 and date >= "2016-09-01"', 'order'=> 'date ASC'));
                $retailer = Retailer::model()->findByPk($retailerId);
                $outstanding = $retailer->initial_payable_amount;
                foreach ($retailerOrders as $order){
                    $tmp = array();
                    $tmp['id'] = $order->order_id;
                    $tmp['date'] = substr($order->delivery_date,0,10);
                    $tmp['type'] = "Order";
                    $tmp['invoiceAmount'] = $order->total_payable_amount;
                    $tmp['paymentAmount'] = '';
                    $tmp['outstanding'] = '';
                    $tmp['update_url'] = 'OrderHeader/update';
                    array_push($dataprovider, $tmp);
                }

                foreach ($retailerPayments as $payment){
                    $tmp = array();
                    $tmp['id'] = $payment->id;
                    $tmp['date'] = substr($payment->date, 0,10);
                    $tmp['type'] = "Payment";
                    $tmp['payment_type'] = $payment->payment_type;
                    $tmp['cheque_no'] = $payment->cheque_no;
                    $tmp['invoiceAmount'] = '';
                    $tmp['paymentAmount'] = $payment->paid_amount;
                    $tmp['update_url'] = 'Grootsledger/UpdatePayment';
                    array_push($dataprovider, $tmp);
                }
                foreach ($dataprovider as $key => $value) {
                  $type[$key] = $value['type'];
                  $date[$key] = $value['date'];
                }
                //$dataprovider = Utility::array_sort($dataprovider, 'date', SORT_ASC);
                array_multisort($date, SORT_ASC, $type , SORT_ASC, $dataprovider);
                foreach ($dataprovider as $key=>$data){
                    if($data['type'] == 'Order'){
                        $outstanding += $data['invoiceAmount'];
                    }
                    elseif($data['type'] == 'Payment'){
                        $outstanding -= $data['paymentAmount'];
                    }
                    $data['outstanding'] = number_format((float)$outstanding,2, '.','');
                    $dataprovider[$key] = $data;
                }
                $dataprovider = new CArrayDataProvider($dataprovider, array(
                    'id'=>'id',
                    'pagination'=>array(
                        'pageSize'=>500,
                    ),
                ));
            }
            //print_r($dataprovider);
            //die;
            /*foreach ($retailerProducts as $retailerProduct) {
           # code...
            }*/
        }






        $this->render('list',array(
           'model'=>$model,
            'retailer' => $retailer,
            'data' => $dataprovider,
            'hidden_retailer_id' => $hidden_retailer_id,
        ));
    }


	/**
	 * Manages all models.
	 */
	public function actionAdminOld()
	{
		$model=new Grootsledger('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Grootsledger']))
			$model->attributes=$_GET['Grootsledger'];

     
       if(isset($_REQUEST['downloadbutton']))
       {
         ob_clean();
          $data= $model->downloadCSVByIDs();
            ob_flush();
            exit();
       }

		

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Grootsledger the loaded model
	 * @throws CHttpException
	 */






	public function loadModel($id)
	{
		$model=Grootsledger::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Grootsledger $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='grootsledger-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    protected function beforeAction() {
        $session = Yii::app()->session['user_id'];
        if ($session == '') {
            echo Yii::app()->controller->redirect("index.php?r=site/logout");
        }
        if (Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] != "S") {
            Yii::app()->user->setFlash('permission_error', 'You have no permission');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        return true;
    }

    public static function updateDaily($retailerIds, $payments){
      foreach ($retailerIds as $key => $retailerId) {
          $paymentAmount = $payments[$key];
          $current_retailer = Retailer::model()->findByPk($retailerId );
          if(isset($paymentAmount) and $paymentAmount > 0){
            $current_retailer->total_payable_amount -= $paymentAmount;
            $sql = "insert into groots_orders.retailer_payments(retailer_id, paid_amount, date, created_at)
                    values($retailerId, $paymentAmount, CURDATE(), CURDATE())";
            $sql2 = "update cb_dev_groots.retailer set total_payable_amount = ".$current_retailer->total_payable_amount.",due_payable_amount = ".$current_retailer->due_payable_amount." where id = ".$retailerId.";";
                   
            if($current_retailer->total_payable_amount == 0){
              $current_retailer->collection_fulfilled = true;
            }
            else 
              $current_retailer->collection_fulfilled = false;

            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sql2);
            $command2->execute();
            $command->execute();
            //$current_retailer->save();
          }

        }
    }

    public static function updatePending($pendingPayments, $pendingRetailerIds){
      foreach ($pendingRetailerIds as $key => $retailerId) {
          $paymentAmount = $pendingPayments[$key];
          $current_retailer = Retailer::model()->findByPk($retailerId );
          if(isset($paymentAmount) and $paymentAmount > 0){
            $current_retailer->total_payable_amount -= $paymentAmount;
            $current_retailer->due_payable_amount -= $paymentAmount;
            $sql = "insert into groots_orders.retailer_payments(retailer_id, paid_amount, date, created_at)
                    values($retailerId, $paymentAmount, CURDATE(), CURDATE())";
            $sql2 = "update cb_dev_groots.retailer set total_payable_amount = ".$current_retailer->total_payable_amount.",due_payable_amount = ".$current_retailer->due_payable_amount." where id = ".$retailerId.";";
                   
            if($current_retailer->total_payable_amount == 0){
              $current_retailer->collection_fulfilled = true;
            }
            else 
              $current_retailer->collection_fulfilled = false;

            $connection = Yii::app()->secondaryDb;
            $command = $connection->createCommand($sql);
            $command2 = $connection->createCommand($sql2);
            $command2->execute();
            $command->execute();
            //$current_retailer->save();
          }

        }
    }

    public function actiontotalpayable(){
      $retailer= Retailer::model()->findAll();
      //var_dump($retailer);
        foreach ($retailer as $current_retailer) {
        $retailerId = $current_retailer->id;
          if($retailerId>0) {
                        $retailerOrders = OrderHeader::model()->findAllByAttributes(array('user_id'=>$retailerId ),array('condition'=>'status = "Delivered" and delivery_date >= "2016-09-01"' ,'order'=> 'delivery_date ASC'));
                        $retailerPayments = RetailerPayment::model()->findAllByAttributes(array('retailer_id'=>$retailerId), array('condition'=>'status != 0 and date >= "2016-09-01"', 'order'=> 'date ASC'));
            $outstanding = $current_retailer->initial_payable_amount;
            foreach ($retailerOrders as $order) {
              $outstanding += $order->total_payable_amount;
            }
            foreach ($retailerPayments as $payment){
              $outstanding -= $payment->paid_amount;
            }
            echo "total_payable_amount----outstanding";
            echo "<br>";
            echo $current_retailer->total_payable_amount."-----------------------------".$outstanding;
            echo "<br>";
            echo "<br>";
            if($current_retailer->total_payable_amount != $outstanding)
            $current_retailer->total_payable_amount = $outstanding;
            
            $current_retailer->save();
          }
        }
  }
}
