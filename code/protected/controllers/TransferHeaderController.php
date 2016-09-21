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
        $w_id = $_GET['w_id'];
        list($popularItems, $otherItems) = BaseProduct::PopularItems();
        $dataProvider=new CArrayDataProvider($popularItems, array(
            'pagination'=>array(
                'pageSize'=>50,
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
                    $this->redirect(array('admin','w_id'=>$model->dest_warehouse_id));
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
                'pageSize'=>50,
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
                    $this->redirect(array('admin','w_id'=>$model->dest_warehouse_id));
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
}