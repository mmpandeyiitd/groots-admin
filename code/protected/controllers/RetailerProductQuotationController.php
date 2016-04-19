<?php

class RetailerProductQuotationController extends Controller {

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
                'actions' => array('index', 'view', 'admin'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
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
        //echo $_REQUEST);die;
        
       if (substr_count(Yii::app()->session['premission_info']['module_info']['retailerProductQuotation'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
       

        $model = new RetailerProductQuotation;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['RetailerProductQuotation'])) {
//                echo '<pre>';
//                   print_r($_POST);die;
             if(isset($_POST['RetailerProductQuotation']['effective_price']) && $_POST['RetailerProductQuotation']['effective_price'] != ''){
                if($model->numeric($_POST['RetailerProductQuotation']['effective_price']) == FALSE){
                   Yii::app()->user->setFlash('error', ' effective price numeric only');
                $this->redirect(array('create'));
                }
            }
            
            if(isset($_POST['RetailerProductQuotation']['discout_per']) && $_POST['RetailerProductQuotation']['discout_per'] != ''){
                if($model->numeric($_POST['RetailerProductQuotation']['discout_per']) == FALSE){
                 Yii::app()->user->setFlash('error', ' discout percentage numeric only');
                $this->redirect(array('create'));
                }
            }
            if($model->is_natural_no_zero($_POST['RetailerProductQuotation']['retailer_id']) == FALSE){
                Yii::app()->user->setFlash('error', ' retailer id numeric only');
                $this->redirect(array('create'));
               }
            
            if($model->is_natural_no_zero($_POST['RetailerProductQuotation']['subscribed_product_id']) == FALSE){
                Yii::app()->user->setFlash('error', ' subscribed product id numeric only');
                $this->redirect(array('create'));
                
            }
            
            $rs= $model->check_retailer_id($_POST['RetailerProductQuotation']['retailer_id'],$_POST['RetailerProductQuotation']['subscribed_product_id']);
           if(!empty($rs)){
               Yii::app()->user->setFlash('error', 'retailer_id and subscribed_product_id  already exist');
                $this->redirect(array('create'));
           }
           if ($_POST['RetailerProductQuotation']['effective_price'] != '' && $_POST['RetailerProductQuotation']['discout_per'] != '') {
                Yii::app()->user->setFlash('error', ' effective price or discout percentage only one field fill');
                $this->redirect(array('create'));
            } else if ($_POST['RetailerProductQuotation']['effective_price'] != '' && $_POST['RetailerProductQuotation']['discout_per'] == '') {
                $_POST['RetailerProductQuotation']['discout_per'] = 0;
            } else if ($_POST['RetailerProductQuotation']['effective_price'] == '' && $_POST['RetailerProductQuotation']['discout_per'] != '') {
                $_POST['RetailerProductQuotation']['effective_price'] = 0;
            } else {
                Yii::app()->user->setFlash('error', ' effective price or discout percentage both of field one field mandatory');
                $this->redirect(array('create'));
            }

            $model->attributes = $_POST['RetailerProductQuotation'];
            if ($model->save())
                  Yii::app()->user->setFlash('success', 'created Sucessfully');
               // $this->redirect(array('admin'));
             $this->redirect(array('retailerProductQuotation/admin&id=adminlist'));
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
          if (substr_count(Yii::app()->session['premission_info']['module_info']['retailerProductQuotation'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['RetailerProductQuotation'])) {
            $model->attributes = $_POST['RetailerProductQuotation'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
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
        $dataProvider = new CActiveDataProvider('RetailerProductQuotation');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new RetailerProductQuotation('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RetailerProductQuotation']))
            $model->attributes = $_GET['RetailerProductQuotation'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return RetailerProductQuotation the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = RetailerProductQuotation::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param RetailerProductQuotation $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'retailer-product-quotation-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
