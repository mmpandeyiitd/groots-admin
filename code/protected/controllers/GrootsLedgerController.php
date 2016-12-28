<?php

class GrootsLedgerController extends Controller
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
				'actions'=>array('index','view','report'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','report'),
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
		$model=new GrootsLedger;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GrootsLedger']))
		{
			$model->attributes=$_POST['GrootsLedger'];
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

		if(isset($_POST['GrootsLedger']))
		{
			$model->attributes=$_POST['GrootsLedger'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionreport()
	{    
		//var_dump($_POST);die;
        $model=new GrootsLedger;
         
         if (isset($_POST['filter'])) {
             $start_date = $_POST['GrootsLedger']['created_at'];
             $end_date = $_POST['GrootsLedger']['inv_created_at'];

             $cDate = date("Y-m-d", strtotime($start_date));
             $cdate1 = date("Y-m-d", strtotime($end_date));
             if ($cDate > $cdate1)
              {
                 Yii::app()->user->setFlash('error', 'End date always greater than Start date');
                  Yii::app()->controller->redirect("index.php?r=GrootsLedger/report");
             }

            else
            {
                ob_clean();
                 $data= $model->downloadCSVByIDs($cDate,$cdate1);
                 ob_flush();
                 exit();
             }
          
        }

        if (isset($_POST['client'])) {
           	$start_date = $_POST['tocdate'];
            /*if($_POST['CatLevel1']==0)
            {
            	Yii::app()->user->setFlash('error', 'Client not selected');
                Yii::app()->controller->redirect("index.php?r=GrootsLedger/report");
            } */
            if ($start_date !='')
            {
           
            $cDate = date("Y-m-d", strtotime($start_date));
                        	ob_clean();
                $data= $model->downloadCSVByCIDs($cDate);
                ob_flush();
                exit();
            }
            else
            {
            	 Yii::app()->user->setFlash('error', 'Date not selected');
                 Yii::app()->controller->redirect("index.php?r=GrootsLedger/report");
            }
        }

        if (isset($_POST['total-wastage'])) {

            $start_date = $_POST['date'];

            /*if($_POST['CatLevel1']==0)
            {
            	Yii::app()->user->setFlash('error', 'Client not selected');
                Yii::app()->controller->redirect("index.php?r=GrootsLedger/report");
            } */
            if ($start_date !='')
            {
                $start_date = date("Y-m-d", strtotime($start_date));
                $this->downloadTotalWastageReport($start_date);
                exit();
            }
            else
            {
                Yii::app()->user->setFlash('error', 'Date not selected');
                Yii::app()->controller->redirect("index.php?r=GrootsLedger/report");
            }


        }

        if(isset($_POST['collection']) && !empty($_POST['collection'])){
        	$startDate = $_POST['collection_from'];
        	$endDate = $_POST['collection_to'];
        	if($startDate == '' || $endDate == ''){
        		Yii::app()->user->setFlash('error', 'Date Not Selected');
                Yii::app()->controller->redirect("index.php?r=GrootsLedger/report");
        	}
        	else{
	        	$startDate = date('Y-m-d', strtotime($startDate));
	        	$endDate = date('Y-m-d', strtotime($endDate));
	        	if(strtotime($startDate) > strtotime($endDate)){
	        		Yii::app()->user->setFlash('error', 'End date sholud be greater than Start date');
	                 Yii::app()->controller->redirect("index.php?r=GrootsLedger/report");
	        	}
	        	else{
	        		$model->downloadCollectionReport($startDate, $endDate);
	        		exit();
	        	}
        	}
        }



      $this->render('report',array(
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
		$dataProvider=new CActiveDataProvider('GrootsLedger');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new GrootsLedger('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GrootsLedger']))
			$model->attributes=$_GET['GrootsLedger'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return GrootsLedger the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=GrootsLedger::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param GrootsLedger $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='groots-ledger-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


    public function downloadTotalWastageReport($date){

        //echo "<pre>";
        $connection = Yii::app()->secondaryDb;

        $sql = 'select name, id from cb_dev_groots.warehouses order by id';
        $command = $connection->createCommand($sql);
        $command->execute();
        $res = $command->queryAll();
        $warehouses = array();
        $nameArr = array();

        $data = array();
        $hdArr = array();
        foreach ($res as $key => $wh) {
            $w_name = explode(',', $wh['name'])[0];
            $warehouses[$wh['id']] = $w_name;
            if($wh['id'] != HD_OFFICE_WH_ID){
                array_push($nameArr, $w_name);
            }
        }

        //create header array
        $hdArr['item'] = '';
        $hdArr['grade'] = '';
        foreach ($nameArr as $name){
            $hdArr["procurement ".$name] = 0;
        }
        foreach ($nameArr as $name){
            $hdArr["order ".$name] = 0;
        }
        foreach ($nameArr as $name){
            $hdArr["inv-order ".$name] = 0;
            $hdArr["inv-liquid ".$name] = 0;
        }

        foreach ($warehouses as $w_id => $name) {

            if ($w_id == HD_OFFICE_WH_ID) {
                continue;
            }


            $orderSql = "select ol.base_product_id, bp.base_title,bp.grade, sum(ol.delivered_qty) as qty 
          from order_header oh join order_line ol on ol.order_id=oh.order_id 
          join cb_dev_groots.base_product bp on bp.base_product_id=ol.base_product_id 
          left join cb_dev_groots.product_category_mapping pcm on pcm.base_product_id=bp.base_product_id
          where oh.status='Delivered' and oh.delivery_date='".$date."' and oh.warehouse_id=".$w_id." 
          group by ol.base_product_id  order by pcm.category_id asc, bp.base_title asc, bp.priority asc";
            $command = $connection->createCommand($orderSql);
            $command->execute();
            $orderData = $command->queryAll();
            foreach ($orderData as $oD){
                if(!isset($data[$oD['base_product_id']])){
                    $data[$oD['base_product_id']] = $hdArr;
                    $data[$oD['base_product_id']]["item"] = $oD['base_title'];
                    $data[$oD['base_product_id']]["grade"] = $oD['grade'];
                }
                $data[$oD['base_product_id']]["order ".$name] = $oD['qty'];
            }


            $procureSql = "select pl.base_product_id, bp.base_title,bp.grade, sum(pl.received_qty) as qty 
          from purchase_header ph join purchase_line pl on pl.purchase_id=ph.id 
          join cb_dev_groots.base_product bp on bp.base_product_id=pl.base_product_id 
          left join cb_dev_groots.product_category_mapping pcm on pcm.base_product_id=bp.base_product_id
          where ph.status='received' and ph.delivery_date='".$date."' and ph.warehouse_id=".$w_id." 
          group by pl.base_product_id  order by pcm.category_id asc, bp.base_title asc, bp.priority asc";
            $command = $connection->createCommand($procureSql);
            $command->execute();
            $orderData = $command->queryAll();
            foreach ($orderData as $oD){
                if(!isset($data[$oD['base_product_id']])){
                    $data[$oD['base_product_id']] = $hdArr;
                    $data[$oD['base_product_id']]["item"] = $oD['base_title'];
                    $data[$oD['base_product_id']]["grade"] = $oD['grade'];
                }
                $data[$oD['base_product_id']]["procurement ".$name] = $oD['qty'];
            }

            $inventorySql = "select i.base_product_id, bp.base_title,bp.grade, sum(i.present_inv) as order_inv, sum(i.liquid_inv) as liquid_inv 
          from inventory i join cb_dev_groots.base_product bp on bp.base_product_id=i.base_product_id 
          left join cb_dev_groots.product_category_mapping pcm on pcm.base_product_id=bp.base_product_id
          where i.date='".$date."' and i.warehouse_id=".$w_id." 
          group by i.base_product_id  order by pcm.category_id asc, bp.base_title asc, bp.priority asc";
            $command = $connection->createCommand($inventorySql);
            $command->execute();
            $orderData = $command->queryAll();
            foreach ($orderData as $oD){
                if(!isset($data[$oD['base_product_id']])){
                    $data[$oD['base_product_id']] = $hdArr;
                    $data[$oD['base_product_id']]["item"] = $oD['base_title'];
                    $data[$oD['base_product_id']]["grade"] = $oD['grade'];
                }
                $data[$oD['base_product_id']]["inv-order ".$name] = $oD['order_inv'];
                $data[$oD['base_product_id']]["inv-liquid ".$name] = $oD['liquid_inv'];
            }
        }


        if(!isset($data) || empty($data)){
            Yii::app()->user->setFlash('error', 'nothing to download...');
            Yii::app()->controller->redirect("index.php?r=GrootsLedger/report&w_id=".$w_id);
        }
        //$dataArray = $this->arrangeWastageReportData($data);
        //print_r($data);die;
        $fileName = $date."_totalWastageReport.csv";
        ob_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);

        if (count($data) > 0) {
            $fp = fopen('php://output', 'w');
            $columnstring = implode(',', array_keys(reset($data)));
            $updatecolumn = str_replace('_', ' ', $columnstring);
//echo $updatecolumn;die;
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
