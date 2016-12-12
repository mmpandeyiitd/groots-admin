<?php

class DashboardPageController extends Controller {

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
                'actions' => array('index'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'index'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'index'),
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
        $model = new DashboardPage;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['DashboardPage'])) {
            $model->attributes = $_POST['DashboardPage'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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

        if (isset($_POST['DashboardPage'])) {
            $model->attributes = $_POST['DashboardPage'];
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
        $model = new DashboardPage;
        $start_date = '';
        $end_date = '';
        $warehouse_id = '';
        $order_start_date = '';
        $order_end_date = '';
        //if (isset($_POST['DashboardPage'])) {
        //$model->attributes = $_POST['DashboardPage'];
         if(isset($_POST['Reset'])){
              Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        if (isset($_POST['filter'])) {
            $start_date = $_POST['DashboardPage']['start_date'];
            $end_date = $_POST['DashboardPage']['end_date'];
            
            $cDate = date("Y-m-d H:i:s", strtotime($start_date));
            $cdate1 = date("Y-m-d H:i:s", strtotime($end_date));
            if ($cDate > $cdate1) {
                Yii::app()->user->setFlash('error', 'End date always greater than Start date');
                Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
            } elseif ($cDate == $cdate1) {
                Yii::app()->user->setFlash('error', 'Start date and end date should not be same !!');
                Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
            }
        }
        if (isset($_POST['orderQtSummary'])) {
            if(isset($_POST['warehouse_id1']) && !empty($_POST['warehouse_id1'])){
                $warehouse_id = $_POST['warehouse_id1'];
            }          
            else{
                Yii::app()->user->setFlash('error', 'Warehouse not selected');
                Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
            }
           //if ($_POST['DashboardPage']['order_start_date'] !='') {
            $order_start_date = $_POST['DashboardPage']['order_start_date'];
            $oDate = date("Y-m-d H:i:s", strtotime($order_start_date));
            $oDate = Utility::getNextDeliveryDate(); echo $oDate;die;
            //echo $oDate;die;
            if (isset($oDate)) {
                ob_clean();
                $data= $model->downloadCSVByIDs($oDate, $warehouse_id);
                ob_flush();
                exit();
            }else {
               // Yii::app()->user->setFlash('error', 'Date not greater then current date');
                Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
            }
           /*}else {
                Yii::app()->user->setFlash('error', 'Date not selected');
                Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
            }*/
        }
        if (isset($_POST['deliveredQtSummary'])) {
            if(isset($_POST['warehouse_id2']) && !empty($_POST['warehouse_id2'])){
                $warehouse_id = $_POST['warehouse_id2'];
            }          
            else{
                Yii::app()->user->setFlash('error', 'Warehouse not selected');
                Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
            }

            //if ($_POST['DashboardPage']['deliverySummaryDeliveryDate'] !='') {
                $order_start_date = $_POST['DashboardPage']['deliverySummaryDeliveryDate'];
                $oDate = date("Y-m-d H:i:s", strtotime($order_start_date));
                //echo $oDate;die;
                $odate1 = date("Y-m-d H:i:s");
                if (isset($oDate)) {
                    ob_clean();
                    $data= $model->downloadCSVDelivered($oDate, $warehouse_id);
                    ob_flush();
                    exit();
                }else {
                    // Yii::app()->user->setFlash('error', 'Date not greater then current date');
                    Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
                }
            /*}else {
                Yii::app()->user->setFlash('error', 'Date not selected');
                Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
            }*/
        }
       
        $this->render('index', array(
            'model' => $model,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new DashboardPage('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DashboardPage']))
            $model->attributes = $_GET['DashboardPage'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return DashboardPage the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = DashboardPage::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param DashboardPage $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dashboard-page-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*protected function beforeAction($action) {

        $session = Yii::app()->session['user_id'];

        if ($session == '') {
            echo Yii::app()->controller->redirect("index.php?r=site/login");
        }
        return true;
    }*/

    protected function beforeAction() {
        if(parent::beforeAction()){
            if($this->checkAccess('SuperAdmin')){
                //die("here0");
                return true;
            }
            else{
                //die("here1");
                Yii::app()->user->setFlash('permission_error', 'You have no permission to access this page');
                Yii::app()->controller->redirect("index.php?r=user/profile");
            }
        }
    }
}
