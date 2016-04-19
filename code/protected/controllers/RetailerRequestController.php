<?php

class RetailerRequestController extends Controller {

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

    protected function beforeAction($action) {
        $session = Yii::app()->session['user_id'];
        if ($session == '') {
            echo Yii::app()->controller->redirect("index.php?r=site/logout");
        }

//        if (Yii::app()->session['premission_info']['menu_info']['retailerrequest_menu_info'] != "S") {
//            Yii::app()->user->setFlash('permission_error', 'You have no permission');
//            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
//        }
     
        return true;
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'update','Admin', 'create', 'activate', 'deactivate', 'activate_edit', 'deactivate_edit'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'activate', 'deactivate', 'activate_edit', 'deactivate_edit'),
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
        $model = new RetailerRequest;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

         if (substr_count(Yii::app()->session['premission_info']['module_info']['retailerrequest'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        if (isset($_POST['RetailerRequest'])) {
            $model->attributes = $_POST['RetailerRequest'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Created Successfully');
                $this->redirect(array('update', 'id' => $model->id, "retailer_id" => $_GET['retailer_id']));
            }
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
         if (substr_count(Yii::app()->session['premission_info']['module_info']['retailerrequest'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        if (isset($_POST['RetailerRequest'])) {
            $model->attributes = $_POST['RetailerRequest'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Updated Successfully');
                $this->redirect(array('update', 'id' => $model->id, "retailer_id" => $_GET['retailer_id']));
            }
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
 if (substr_count(Yii::app()->session['premission_info']['module_info']['retailerrequest'], 'D') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('RetailerRequest');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new RetailerRequest('search');
//         if (substr_count(Yii::app()->session['premission_info']['module_info']['retailerrequest'], 'R') == 0) {
//            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
//            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
//        }
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RetailerRequest'])) {
            $model->attributes = $_GET['RetailerRequest'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    #....... activate data..........#

    public function actionactivate($request_id,$retailer_id) {
      echo $request_id;
      echo $retailer_id;
     // echo $store_id;
     // die;
        $model = new RetailerRequest();
       // $retailer_id = $_GET['retailer_id'];
        $model->activateuser($request_id,$retailer_id);
        Yii::app()->user->setFlash('error', 'This request Approved Successfully');
        $this->redirect(array('retailerRequest/admin', "retailer_id" => $retailer_id));
    }

    #....... activate data..........#

    public function actionactivate_edit($request_id,$retailer_id) {
        $model = new RetailerRequest();
        //$retailer_id = $_GET['retailer_id'];
        $model->activateuser($request_id,$retailer_id);
        Yii::app()->user->setFlash('error', 'This request Approved Successfully');
        $this->redirect(array('retailer/update', "id" => $retailer_id));
    }

    #....... deactivate data..........#

    public function actiondeactivate($request_id,$retailer_id) {
        $model = new RetailerRequest();
       // $retailer_id = $_GET['retailer_id'];
        $model->deactivateuser($request_id,$retailer_id);
        Yii::app()->user->setFlash('error', 'This request Rejected Successfully');
        $this->redirect(array('retailerRequest/admin', "retailer_id" => $retailer_id));
    }

    #....... deactivate data..........#

    public function actiondeactivate_edit($request_id,$retailer_id) {
        $model = new RetailerRequest();
       // $retailer_id = $_GET['retailer_id'];
        $model->deactivateuser($request_id,$retailer_id);
        Yii::app()->user->setFlash('error', 'This request Rejected Successfully');
        $this->redirect(array('retailer/update', "id" => $retailer_id));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return RetailerRequest the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = RetailerRequest::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param RetailerRequest $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'retailer-request-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
