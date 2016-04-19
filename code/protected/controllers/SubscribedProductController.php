<?php

class SubscribedProductController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
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
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'admin', 'mappedProduct'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'mappedProduct'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'mappedProduct'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new SubscribedProduct;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['SubscribedProduct'])) {
            $model->attributes = $_POST['SubscribedProduct'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->subscribed_product_id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['SubscribedProduct'])) {
            $model->attributes = $_POST['SubscribedProduct'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->subscribed_product_id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionmappedProduct() {
        //$model=$this->loadModel($id);
        $effective_price = '';

        $model_subscribe = new RetailerProductQuotation();
        $rs= $model_subscribe->check_retailer_id($_REQUEST['id'], $_REQUEST['retailer_id']);

        if ($_POST == Array()) {
            $this->render('create_re', array(
                'model_subscribe' => $model_subscribe,
            ));
        } else {
        if (!empty($rs)) {
                Yii::app()->user->setFlash('error', 'retailer_id and subscribed_product_id  already exist');
             $this->redirect(array('subscribedProduct/mappedProduct&id='.$_REQUEST["id"].'&retailer_id='.$_REQUEST["retailer_id"].''));
            }
            if(isset($_POST['RetailerProductQuotation']['effective_price']) && $_POST['RetailerProductQuotation']['effective_price'] != ''){
                if($model_subscribe->numeric($_POST['RetailerProductQuotation']['effective_price']) == FALSE){
                   Yii::app()->user->setFlash('error', ' effective price numeric only');
                 $this->redirect(array('subscribedProduct/mappedProduct&id='.$_REQUEST["id"].'&retailer_id='.$_REQUEST["retailer_id"].''));
                }
            }
            if(isset($_POST['RetailerProductQuotation']['discout_per']) && $_POST['RetailerProductQuotation']['discout_per'] != ''){
                if($model_subscribe->numeric($_POST['RetailerProductQuotation']['discout_per']) == FALSE){
                 Yii::app()->user->setFlash('error', ' discout percentage numeric only');
                $this->redirect(array('subscribedProduct/mappedProduct&id='.$_REQUEST["id"].'&retailer_id='.$_REQUEST["retailer_id"].''));
                }
            }
            if ($_POST['RetailerProductQuotation']['effective_price'] != '' && $_POST['RetailerProductQuotation']['discout_per'] != '') {
                Yii::app()->user->setFlash('error', ' effective price or discout percentage only one field fill');
                $this->redirect(array('subscribedProduct/mappedProduct&id='.$_REQUEST["id"].'&retailer_id='.$_REQUEST["retailer_id"].''));
            } else if ($_POST['RetailerProductQuotation']['discout_per']>100) {
                Yii::app()->user->setFlash('error', 'Discout percentage Not Greater than 100 %');
               $this->redirect(array('subscribedProduct/mappedProduct&id='.$_REQUEST["id"].'&retailer_id='.$_REQUEST["retailer_id"].''));
            }
            else if ($_POST['RetailerProductQuotation']['effective_price'] != '' && $_POST['RetailerProductQuotation']['discout_per'] == '') {
                $_POST['RetailerProductQuotation']['discout_per'] = 0;
            } else if ($_POST['RetailerProductQuotation']['effective_price'] == '' && $_POST['RetailerProductQuotation']['discout_per'] != '') {
                $_POST['RetailerProductQuotation']['effective_price'] = 0;
            } 
            else {
                Yii::app()->user->setFlash('error', ' Effective price or Discout percentage both of field one field mandatory');
                //$this->redirect(array('create_re'));
                $this->redirect(array('subscribedProduct/mappedProduct&id='.$_REQUEST["id"].'&retailer_id='.$_REQUEST["retailer_id"].''));
            }

            $model_subscribe->attributes = $_POST['RetailerProductQuotation'];
            $model_subscribe->subscribed_product_id = $_REQUEST['id'];
            $model_subscribe->retailer_id = $_REQUEST['retailer_id'];
            $model_subscribe->save();
//            //$model_subscribe->effective_price = $_POST['effective_price'];
//             $model_subscribe->discout_per = $_POST['discout_per'];
//              $model_subscribe->status = $_POST['status'];
//               echo '<pre>';
//            print_r($model_subscribe);die;
            if ($model_subscribe->save()) {
                $model_subscribe->subscribed_product_id = $_REQUEST['id'];
                $model_subscribe->retailer_id = $_REQUEST['retailer_id'];
               Yii::app()->user->setFlash('success', 'created Sucessfully');
                $this->redirect(array('retailerProductQuotation/admin&id='.$_REQUEST["retailer_id"].''));
            } else {
                Yii::app()->user->setFlash('error', ' Error !!');
                 $this->redirect(array('subscribedProduct/mappedProduct&id='.$_REQUEST["id"].'&retailer_id='.$_REQUEST["retailer_id"].''));
                
            }
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('SubscribedProduct');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        
        
        
        
        
         //echo '<pre>';
        //print_r($data);die;
        $model = new SubscribedProduct('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['SubscribedProduct'])) {
            $model->attributes = $_GET['SubscribedProduct'];
         //$model->attributes=$_REQUEST['id'];
        }
        $this->render('admin', array(
            'model' => $model,
            // 'base_product_id' => $model_base_product->base_product_id,
            'id' => $_REQUEST['id'],
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SubscribedProduct the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SubscribedProduct::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SubscribedProduct $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'subscribed-product-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
