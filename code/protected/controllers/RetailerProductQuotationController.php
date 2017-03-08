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
            //'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('index', 'view', 'admin','deleteproduct'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin','deleteproduct'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete','deleteproduct'),
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
       
        if($_REQUEST['r']=='retailerProductQuotation/View')
        {
            $model = new RetailerProductQuotation;
            $sub_id=$_REQUEST['id'];
            $re_id=$_REQUEST['retailer_id'];
            $model->updatelog($sub_id,$re_id);
            $model->solrbacklogRetailerProductQuotation($sub_id,$re_id);
            $model->Delete_retelar($sub_id,$re_id);
            
           
        }
        $this->redirect(array('retailerProductQuotation/admin&id=' . $re_id . ''));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //echo $_REQUEST);die;

        /*if (substr_count(Yii::app()->session['premission_info']['module_info']['retailerProductQuotation'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }*/


        $model = new RetailerProductQuotation;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['RetailerProductQuotation'])) {
//                echo '<pre>';
//                   print_r($_POST);die;
            if (isset($_POST['RetailerProductQuotation']['effective_price']) && $_POST['RetailerProductQuotation']['effective_price'] != '') {
                if ($model->numeric($_POST['RetailerProductQuotation']['effective_price']) == FALSE) {
                    Yii::app()->user->setFlash('error', ' effective price numeric only');
                    $this->redirect(array('create'));
                }
            }

            if (isset($_POST['RetailerProductQuotation']['discout_per']) && $_POST['RetailerProductQuotation']['discout_per'] != '') {
                if ($model->numeric($_POST['RetailerProductQuotation']['discout_per']) == FALSE) {
                    Yii::app()->user->setFlash('error', ' discout percentage numeric only');
                    $this->redirect(array('create'));
                }
            }
            if ($model->is_natural_no_zero($_POST['RetailerProductQuotation']['retailer_id']) == FALSE) {
                Yii::app()->user->setFlash('error', ' retailer id numeric only');
                $this->redirect(array('create'));
            }

            if ($model->is_natural_no_zero($_POST['RetailerProductQuotation']['subscribed_product_id']) == FALSE) {
                Yii::app()->user->setFlash('error', ' subscribed product id numeric only');
                $this->redirect(array('create'));
            }

            $rs = $model->check_retailer_id($_POST['RetailerProductQuotation']['retailer_id'], $_POST['RetailerProductQuotation']['subscribed_product_id']);
            if (!empty($rs)) {
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
         /*if (substr_count(Yii::app()->session['premission_info']['module_info']['retailerProductQuotation'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        if (substr_count(Yii::app()->session['premission_info']['module_info']['retailerProductQuotation'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }*/
       
        $model = new RetailerProductQuotation;
        $ret_data = $model->updatedatalist($_REQUEST['id'], $_REQUEST['retailer_id']);
        $sub_store_data = $model->updatesubproduct($_REQUEST['id']);
//         echo '<pre>';
        // print_r( $ret_data);die;\

        if (isset($_POST['data'])) {
            if (isset($_POST['effective_price']) && $_POST['effective_price'] != '') {
                if ($model->numeric($_POST['effective_price']) == FALSE) {
                    Yii::app()->user->setFlash('error', ' effective price numeric only');
                    $this->redirect(array('retailerProductQuotation/update&id=' . $_POST['subscribed_product_id'] . '&retailer_id=' . $_POST['retailer_id'] . ''));
                }
            }
            if($_POST['discout_per']==''){
                $_POST['discout_per']=0;
            }
            
            if (isset($_POST['discout_per']) && $_POST['discout_per'] != '') {
                if ($model->numeric($_POST['discout_per']) == FALSE) {
                     Yii::app()->user->setFlash('error', ' discout percentage numeric only');
                    $this->redirect(array('retailerProductQuotation/update&id=' . $_POST['subscribed_product_id'] . '&retailer_id=' . $_POST['retailer_id'] . ''));
                }
            }
             if (( $_POST['effective_price'] ==0) && ( $_POST['discout_per'] == '')) {
                Yii::app()->user->setFlash('error', ' effective price or discout percentage only one field mandatory');
               $this->redirect(array('retailerProductQuotation/update&id=' . $_POST['subscribed_product_id'] . '&retailer_id=' . $_POST['retailer_id'] . ''));
            } 
             if (( $_POST['effective_price'] ==0) && ( $_POST['discout_per'] == 0)) {
                Yii::app()->user->setFlash('error', ' effective price or discout percentage one field mandatory');
               $this->redirect(array('retailerProductQuotation/update&id=' . $_POST['subscribed_product_id'] . '&retailer_id=' . $_POST['retailer_id'] . ''));
            } 
             if (( $_POST['effective_price'] !=0) && ( $_POST['discout_per'] != 0)) {
                Yii::app()->user->setFlash('error', ' effective price or discout percentage one field mandatory');
               $this->redirect(array('retailerProductQuotation/update&id=' . $_POST['subscribed_product_id'] . '&retailer_id=' . $_POST['retailer_id'] . ''));
            } 
            
             if (( $_POST['effective_price'] =='') && ( $_POST['discout_per'] == 0)) {
                Yii::app()->user->setFlash('error', ' effective price or discout percentage one field mandatory');
               $this->redirect(array('retailerProductQuotation/update&id=' . $_POST['subscribed_product_id'] . '&retailer_id=' . $_POST['retailer_id'] . ''));
            } else if ($_POST['discout_per'] > 100) {
                Yii::app()->user->setFlash('error', 'Discout percentage Not Greater than 100 %');
               $this->redirect(array('retailerProductQuotation/update&id=' . $_POST['subscribed_product_id'] . '&retailer_id=' . $_POST['retailer_id'] . ''));
            } else if ($_POST['effective_price'] == '' && $_POST['discout_per'] != '' ||$_POST['discout_per'] != '0') {
                $_POST['effective_price'] = 0;
            }
            else if ($_POST['effective_price'] != '' && $_POST['discout_per'] == '' ||$_POST['discout_per'] == '0') {
                $_POST['discout_per'] = 0;
            } else if ($_POST['effective_price'] == '0'|| $_POST['effective_price'] == '' && $_POST['discout_per'] != '') {
                $_POST['RetailerProductQuotation']['effective_price'] = 0;
            } else {
                Yii::app()->user->setFlash('error', ' Effective price or Discout percentage both of field one field mandatory');
                //$this->redirect(array('create_re'));
               $this->redirect(array('retailerProductQuotation/update&id=' . $_POST['subscribed_product_id'] . '&retailer_id=' . $_POST['retailer_id'] . ''));
            }
            
            $model->updatedata_retelar($_POST['effective_price'], $_POST['discout_per'], $_POST['retailer_id'], $_POST['subscribed_product_id']);
            //$this->redirect(array('admin', 'id' => $model->id));
             Yii::app()->user->setFlash('success', 'created Sucessfully');
            $this->redirect(array('retailerProductQuotation/admin&id=' . $_POST['retailer_id'] . ''));
            
        }
        if (isset($_POST['RetailerProductQuotation'])) {

            $model->attributes = $_POST['RetailerProductQuotation'];
            if ($model->save())
                $this->redirect(array('admin', 'id' => $model->id));
        }

        $retailer_id = $ret_data[0]['retailer_id'];
        $subscribed_product_id = $ret_data[0]['subscribed_product_id'];
        $discout_per = $ret_data[0]['discount_per'];
        $effective_price = $ret_data[0]['effective_price'];
        $store_price = $sub_store_data[0]['store_price'];
        $store_offer_price = $sub_store_data[0]['store_offer_price'];
        //  echo $store_offer_price;die;
        $this->render('update', array(
            'model' => $model,
            'retailer_id' => $retailer_id,
            'subscribed_product_id' => $subscribed_product_id,
            'discout_per' => $discout_per,
            'effective_price' => $effective_price,
            'store_price' => $store_price,
            'store_offer_price' => $store_offer_price,
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
       //  print_r($_POST);die;
        /*if (substr_count(Yii::app()->session['premission_info']['module_info']['retailerProductQuotation'], 'R') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }*/
        
        // echo '<pre>';print_r($_POST);die;
        
        $model = new RetailerProductQuotation;
        $model_grid = new ProductGridviewRetelar('search');

        $model_grid->unsetAttributes();
        // $model_grid = new ProductGridviewRetelar('search');
        // $model_grid->unsetAttributes();
       /* $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RetailerProductQuotation']))
            $model->attributes = $_GET['RetailerProductQuotation'];*/
        if (isset($_GET['ProductGridviewRetelar']))
            $model_grid->attributes = $_GET['ProductGridviewRetelar'];

        $this->render('admin', array(
            // 'model' => $model,
            'model_grid' => $model_grid,
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
        //  echo '<pre>';print_r($_REQUEST);die;
        //echo "hello";die;
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
