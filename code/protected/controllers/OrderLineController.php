<?php

class OrderLineController extends Controller
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
    
    /*protected function beforeAction() {
        $session = Yii::app()->session['user_id'];

        if ($session == '') {
            echo Yii::app()->controller->redirect("index.php?r=site/logout");
        }
        return true;
    }*/
    protected function beforeAction() {
        return parent::beforeAction();
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
        'actions'=>array('create','update'),
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
        $model=new OrderLine;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['OrderLine']))
        {
            $model->attributes=$_POST['OrderLine'];
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
    public function actionUpdate() 
    {    

        if(isset($_REQUEST['id']))
        {

            foreach($_REQUEST['id']  as $key=>$value)
            {
				
                $model=$this->loadModel($_REQUEST['id'][$key]); 


                $_POST['OrderLine']['status']=$_REQUEST['status'][$key] ;
                $_POST['OrderLine']['unit_price_discount']=$_REQUEST['unit_price_discount'][$key];
                $_POST['OrderLine']['total_price_discount']=$_REQUEST['total_price_discount'][$key];
                $_POST['yt0'] ='Save';             
                $model->attributes=  $_POST['OrderLine'];                 
                $model->save();

                //................send Sms......................//
               // $this->SendSms($_REQUEST['id'][$key],$_REQUEST['order_id']);

            }
        }                                              
        Yii::app()->user->setFlash('success', 'Update and Sms Send Successfully.');  
        $this->redirect(array('OrderHeader/update', 'id' => $_REQUEST['order_id']));        
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
        $dataProvider=new CActiveDataProvider('OrderLine');
        $this->render('index',array(
        'dataProvider'=>$dataProvider,
        ));
    }

    /**
    * Manages all models.
    */
    public function actionAdmin()
    {

        $model=new OrderLine('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['OrderLine']))
            $model->attributes=$_GET['OrderLine'];

        $this->render('admin',array(
        'model'=>$model,
        ));
    }

    /**
    * Returns the data model based on the primary key given in the GET variable.
    * If the data model is not found, an HTTP exception will be raised.
    * @param integer $id the ID of the model to be loaded
    * @return OrderLine the loaded model
    * @throws CHttpException
    */
    public function loadModel($id)
    {
        $model=OrderLine::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
    * Performs the AJAX validation.
    * @param OrderLine $model the model to be validated
    */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='order-line-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function SendSms($ordersub_Id,$orderId)
    {
        $mobile='';
        $model=OrderLine::model()->findByPk($ordersub_Id);
        $modelorderheader=OrderHeader::model()->findByPk($orderId); 

        $mobile=$modelorderheader->attributes['billing_phone'];
        $msg='';

        if($model->attributes['status']=='Processing')
        {         
            $msg="Hi, your Supplified order No".$model->attributes['order_id'].",has been successfully placed. Order will be confirmed soon. Check mails for details. Thank you for shopping at Supplified.";
            
             $modelRequest_Id=OrderLine::model()->findBySql("select delivery_request_id from order_line where id ='".$ordersub_Id."' "); 
            
            //.................Order Api..................//
            if(empty($modelRequest_Id->attributes['delivery_request_id']))
            {
              $this->deliveryapi($ordersub_Id,$orderId);
            }
            //..........................end......................//


        }
        elseif($model->attributes['status']=='Packaging' || $model->attributes['status']=='readytoship')
        {         
            $msg="Your Supplified Order No%".$model->attributes['order_id']."%is ready for shipment & will be shipped any time within%24%hrs.";
        }
        elseif($model->attributes['status']=='shipped')
        {         
            $msg="Your Supplified Order No%".$model->attributes['order_id']."%has been shipped. Tracking ID is%ABH2%and will reach you on or before%%";
        }
        elseif($model->attributes['status']=='Cancelled')
        {         
            $msg="Your Supplified Order No%".$model->attributes['order_id']."%is cancelled. If you have already paid, refund will be initiated shortly. Check emails for more details.";
        }
        if(!empty($msg))
        {

         $SMS_Url="http://bulksmsindia.mobi/sendurlcomma.aspx?user=20074197&pwd=ngiurg&senderid=SUPTRX&mobileno=".$mobile."&msgtext=".urlencode($msg)."&smstype=0";

   
        $curl = curl_init($SMS_Url);
        curl_setopt($curl, CURLOPT_URL, $SMS_Url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($curl);
        curl_close($curl);
        }   
    } 

    public function   deliveryapi($ordersub_Id,$orderId)
    {
        $Sub_Orderid_model=OrderLine::model()->findByPk($ordersub_Id);
        $Orderid_model=OrderHeader::model()->findByPk($orderId);

        
        $json_data ='[
        {
        "order_id": "'.$Sub_Orderid_model->attributes['id'].'",
        "order_date": "'.$Orderid_model->attributes['created_date'].'",
        "consignee": {
        "shipping_name": "'.$Orderid_model->attributes['shipping_name'].'",
        "shipping_state": "'.$Orderid_model->attributes['shipping_city'].'",
        "shipping_city": "'.$Orderid_model->attributes['shipping_city'].'",
        "shipping_pin": "'.$Orderid_model->attributes['shipping_pincode'].'",
        "shipping_ph2": "'.$Orderid_model->attributes['shipping_phone'].'",
        "shipping_ph1":"'.$Orderid_model->attributes['shipping_phone'].'",
        "shipping_add2": "'.$Orderid_model->attributes['shipping_city'].'",
        "shipping_add1": "'.$Orderid_model->attributes['shipping_city'].'",
        "shipping_country": "India"
        },
        "OrderLine": {
        "Products": [
        {
        "prod_sku": "",
        "prod_num": "",
        "prod_desc": "'.$Sub_Orderid_model->attributes['product_name'].'",
        "prod_qty": "'.$Sub_Orderid_model->attributes['product_qty'].'",
        "prod_name": "'.$Sub_Orderid_model->attributes['product_name'].'"
        }
        ],
        "fulfillment_mode": "BS",
        "supplier_id": "supp",
        "waybill_number": "",
        "Invoice": {
        "unit_taxes": 0,
        "total_price": '.$Orderid_model->attributes['total_payable_amount'].',
        "vat_percentage": 12.5,
        "cst_percentage": 12.5,
        "invoice_date": "'.$Orderid_model->attributes['created_date'].'",
        "gross_value": "'.$Orderid_model->attributes['total_payable_amount'].'",
        "round_off": 0,
        "mrp": "'.$Sub_Orderid_model->attributes['unit_price'].'",
        "unit_price": 0,
        "total_taxes": 123,
        "discount": 0,
        "total_vat": 12.5,
        "advance_payment": 0,
        "total_cst": 62.4,
        "invoice_number": "",
        "net_amount": "'.$Orderid_model->attributes['total_payable_amount'].'",
        "cod_amount": "'.$Orderid_model->attributes['total_payable_amount'].'",
        "tax_percentage": 12.5,
        "shipping_price": "'.$Orderid_model->attributes['total_payable_amount'].'"
        },
        "Extra": {
        "shipment_id": ""
        },
        "payment_mode": "COD",
        "couriers": "DELHIVERY",
        "order_line_id": 1,
        "express_delivery": true
        }
        }  
        ]'; 


        $api_domain = "https://stg2-godam.delhivery.com/oms/api/create/?client_store=Supplified&fulfillment_center=DELFC2&version=2014.09"; 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api_domain);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization : Token d101f59b57868baf874480ae36bb116067eeeb63',
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json_data)
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);      
        $result = curl_exec($curl); 
        $response = json_decode($result, true);  
        curl_close($curl);  
        
       
        //......................uapdate request Id..................//
        $row=array();
        $row['delivery_request_id']=$response['request_id'];
        $model=$this->loadModel($ordersub_Id); 
        $model->attributes=  $row;                 
        $model->save();  
        //.........................end.......................// 
    }


}
