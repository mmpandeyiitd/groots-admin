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
                'actions' => array('index', 'view', 'admin', 'mappedProduct', 'listallproduct', 'Updatebaseproducrt'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'mappedProduct', 'listallproduct', 'Updatebaseproducrt'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'mappedProduct', 'listallproduct', 'Updatebaseproducrt'),
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
        if (substr_count(Yii::app()->session['premission_info']['module_info']['subscribedProduct'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
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
        //echo '<pre>'; print_r($_POST);die;
        if (substr_count(Yii::app()->session['premission_info']['module_info']['subscribedProduct'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
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
        if (substr_count(Yii::app()->session['premission_info']['module_info']['subscribedProduct'], 'R') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        //$model=$this->loadModel($id);
        $effective_price = '';

        $model_subscribe = new RetailerProductQuotation();
        $rs = $model_subscribe->check_retailer_id($_REQUEST['id'], $_REQUEST['retailer_id']);
        $sub_data = $model_subscribe->updatesubproduct($_REQUEST['id']);
        //  echo '<pre>'; print_r($sub_data);die;
        $store_price = $sub_data['0']['store_price'];
        $store_offer_price = $sub_data['0']['store_offer_price'];

        if ($_POST == Array()) {

            $this->render('create_re', array(
                'model_subscribe' => $model_subscribe,
                'store_price' => $store_price,
                'store_offer_price' => $store_offer_price,
            ));
        } else {
            if (!empty($rs)) {
                Yii::app()->user->setFlash('error', 'retailer_id and subscribed_product_id  already exist');
                $this->redirect(array('subscribedProduct/mappedProduct&id=' . $_REQUEST["id"] . '&retailer_id=' . $_REQUEST["retailer_id"] . ''));
            }
            if (isset($_POST['RetailerProductQuotation']['effective_price']) && $_POST['RetailerProductQuotation']['effective_price'] != '') {
                if ($model_subscribe->numeric($_POST['RetailerProductQuotation']['effective_price']) == FALSE) {
                    Yii::app()->user->setFlash('error', ' effective price numeric only');
                    $this->redirect(array('subscribedProduct/mappedProduct&id=' . $_REQUEST["id"] . '&retailer_id=' . $_REQUEST["retailer_id"] . ''));
                }
            }
            if (isset($_POST['RetailerProductQuotation']['discout_per']) && $_POST['RetailerProductQuotation']['discount_per'] != '') {
                if ($model_subscribe->numeric($_POST['RetailerProductQuotation']['discout_per']) == FALSE) {
                    Yii::app()->user->setFlash('error', ' discout percentage numeric only');
                    $this->redirect(array('subscribedProduct/mappedProduct&id=' . $_REQUEST["id"] . '&retailer_id=' . $_REQUEST["retailer_id"] . ''));
                }
            }
            if ($_POST['RetailerProductQuotation']['effective_price'] != '' && $_POST['RetailerProductQuotation']['discount_per'] != '') {
                Yii::app()->user->setFlash('error', ' effective price or discout percentage only one field fill');
                $this->redirect(array('subscribedProduct/mappedProduct&id=' . $_REQUEST["id"] . '&retailer_id=' . $_REQUEST["retailer_id"] . ''));
            } else if ($_POST['RetailerProductQuotation']['discount_per'] > 100) {
                Yii::app()->user->setFlash('error', 'Discout percentage Not Greater than 100 %');
                $this->redirect(array('subscribedProduct/mappedProduct&id=' . $_REQUEST["id"] . '&retailer_id=' . $_REQUEST["retailer_id"] . ''));
            } else if ($_POST['RetailerProductQuotation']['effective_price'] != '' && $_POST['RetailerProductQuotation']['discount_per'] == '') {
                $_POST['RetailerProductQuotation']['discount_per'] = 0;
            } else if ($_POST['RetailerProductQuotation']['effective_price'] == '' && $_POST['RetailerProductQuotation']['discount_per'] != '') {
                $_POST['RetailerProductQuotation']['effective_price'] = 0;
            } else {
                Yii::app()->user->setFlash('error', ' Effective price or Discout percentage both of field one field mandatory');
                //$this->redirect(array('create_re'));
                $this->redirect(array('subscribedProduct/mappedProduct&id=' . $_REQUEST["id"] . '&retailer_id=' . $_REQUEST["retailer_id"] . ''));
            }

            $model_subscribe->attributes = $_POST['RetailerProductQuotation'];
            $model_subscribe->subscribed_product_id = $_REQUEST['id'];
            $model_subscribe->retailer_id = $_REQUEST['retailer_id'];
            $model_subscribe->save();
//            //$model_subscribe->effective_price = $_POST['effective_price'];
//             $model_subscribe->discout_per = $_POST['discout_per'];
//              $model_subscribe->status = $_POST['status'];
//               echo '<pre>';
//           print_r($model_subscribe);die;
            if ($model_subscribe->save()) {
                $model_subscribe->subscribed_product_id = $_REQUEST['id'];
                $model_subscribe->retailer_id = $_REQUEST['retailer_id'];
                $model_subscribe->solrbacklogRetailerProductQuotation($model_subscribe->subscribed_product_id, $model_subscribe->retailer_id = $_REQUEST['retailer_id']);
                Yii::app()->user->setFlash('success', 'created Sucessfully');
                $this->redirect(array('retailerProductQuotation/admin&id=' . $_REQUEST["retailer_id"] . ''));
            } else {
                Yii::app()->user->setFlash('error', ' Error !!');
                $this->redirect(array('subscribedProduct/mappedProduct&id=' . $_REQUEST["id"] . '&retailer_id=' . $_REQUEST["retailer_id"] . ''));
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
        //echo '<pre>'; print_r($_POST);die;
        if (substr_count(Yii::app()->session['premission_info']['module_info']['subscribedProduct'], 'R') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        $model = new SubscribedProduct;
        $model_grid = new RetailerproductquotationGridview('search');
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }
        $model_grid->unsetAttributes(); // clear any default values
        if (isset($_GET['RetailerproductquotationGridview'])) {
            $model_grid->attributes = $_GET['RetailerproductquotationGridview'];
            //$model->attributes=$_REQUEST['id'];
        }

        if (isset($_POST['savedata'])) {

            if (isset($_POST['selectedIds'])) {
                $no_of_selectedIds = count($_POST['selectedIds']);
                $no_of_effective_price = count($_POST['effective_price']);
                $no_of_discount_price = count($_POST['discount_price']);
                if ($no_of_selectedIds > 0) {
                    for ($i = 0; $i < $no_of_selectedIds; $i++) {
                        $val = $_POST['selectedIds'][$i];
//                       echo $no_of_discount_price.$no_of_effective_price;die;
                       if(isset($_POST['effective_price'][$val]) && $_POST['effective_price'][$val] > 0){
                          $df=0;
                          $ef = $_POST['effective_price'][$val];
                        }
                         else  if(isset($_POST['effective_price'][$val])){
                          $df=0;
                          $ef =0;
                        }

                        else {
                            $ef = 0;
                            $df = $_POST['discount_price'][$val];
                        }
                          $active_record = $model->savedatagridview($_REQUEST['id'], $val, $ef, $df);
                            $model->solrbacklogRetailerProductQuotation($val,$_REQUEST['id']);
                    }
                   
                    if ($active_record == '') {
                        Yii::app()->user->setFlash('success', 'Selected product list updated Successfully.');
                    } else {
                        Yii::app()->user->setFlash('premission_info', 'Please try again');
                    }
                }
            } else {
                //echo "heoo";die;
                Yii::app()->user->setFlash('premission_info', 'Product list not selected');
            }
        }
        $this->render('admin', array(
            //'model' => $model,
            'model_grid' => $model_grid,
                //'id' => $_REQUEST['id'],
        ));
    }

    public function actionlistallproduct() {
        // echo '<pre>';print_r($_POST);die;
        if (substr_count(Yii::app()->session['premission_info']['module_info']['subscribedProduct'], 'R') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        //echo '<pre>';
        //print_r($data);die;

        $model = new SubscribedProduct('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_POST['downloadbutton'])) {

            if (isset($_POST['selectedIds'])) {
                $no_of_selectedIds = count($_POST['selectedIds']);
                if ($no_of_selectedIds > 0) {
                    $base_product_ids = implode(',', $_POST['selectedIds']);
                    ob_clean();
                    $response = $model->downloadCSVByIDs($base_product_ids);
                    ob_flush();
                    exit();
                }
            } else {
                $sub_ids = $model->allcheckproductlcsv();
                if (count($sub_ids) > 0) {
                    for ($i = 0; $i < count($sub_ids); $i++) {
                        $subpro_id[] = implode(',', $sub_ids[$i]);
                    }
                    if (count($sub_ids) > 0) {
                        //echo "hello222";die;
                        $subpro_id_new = implode(',', $subpro_id);
                    }
                }
                ob_clean();
                $response = $model->downloadCSVByIDs($subpro_id_new);
                ob_flush();
                exit();
            }
            // Yii::app()->user->setFlash('premission_info', 'done.');
        }

        if (isset($_GET['SubscribedProduct'])) {
            $model->attributes = $_GET['SubscribedProduct'];
            //$model->attributes=$_REQUEST['id'];
        }
        $this->render('admin_all', array(
            'model' => $model,
                // 'base_product_id' => $model_base_product->base_product_id,
                //'id' => $_REQUEST['id'],
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

    public function actionAjaxupdate() {


        $act = $_GET['act'];
        if ($act == 'doSortOrder') {
            $sortOrderAll = $_POST['sortOrder'];
            if (count($sortOrderAll) > 0) {
                foreach ($sortOrderAll as $menuId => $sortOrder) {
                    $model = $this->loadModel($menuId);
                    $model->sortOrder = $sortOrder;
                    $model->save();
                }
            }
        } else {
            $autoIdAll = $_POST['autoId'];
            if (count($autoIdAll) > 0) {
                foreach ($autoIdAll as $autoId) {
                    $model = $this->loadModel($autoId);
                    if ($act == 'doDelete')
                        $model->isDeleted = '1';
                    if ($act == 'doActive')
                        $model->isActive = '1';
                    if ($act == 'doInactive')
                        $model->isActive = '0';
                    if ($model->save())
                        echo 'ok';
                    else
                        throw new Exception("Sorry", 500);
                }
            }
        }
    }

}
