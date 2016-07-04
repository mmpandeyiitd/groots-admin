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
				'actions'=>array('create','update','admin','report'),
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

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
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
}
