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
                'actions' => array('index', 'view', 'admin', 'mappedProduct', 'listallproduct', 'Updatebaseproducrt', 'test', 'test2'),
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
        /*if (substr_count(Yii::app()->session['premission_info']['module_info']['subscribedProduct'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }*/
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
        /*if (substr_count(Yii::app()->session['premission_info']['module_info']['subscribedProduct'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }*/
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
        /*if (substr_count(Yii::app()->session['premission_info']['module_info']['subscribedProduct'], 'R') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }*/
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
         //echo '<pre>'; var_dump($_POST);die;
        /*if (substr_count(Yii::app()->session['premission_info']['module_info']['subscribedProduct'], 'R') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }*/
        $retailer_id = $_GET['id'];
	   if(isset($_FILES) && !empty($_FILES)){
         if( $_FILES['uploadedFile']['error'] >0){
             Yii::app()->user->setFlash('error', 'File Uploading Unsuccessful, Please try again...'); 
             Yii::app()->controller->redirect("index.php?r=subscribedProduct/admin&id=".$retailer_id);
            }
         else {
            $file = fopen( $_FILES['uploadedFile']['tmp_name'], "rb");
            self::uploadPrices($retailer_id, $file);
            Yii::app()->user->setFlash('success', 'Price Uploading Successfull');
            Yii::app()->controller->redirect("index.php?r=subscribedProduct/admin&id=".$retailer_id);
            }
      	}
        $no_of_Deletedataarray = 1;
        $model = new SubscribedProduct;
        //$model_grid = new RetailerproductquotationGridview('search');
        $model_grid = new SubscribedProduct('search');
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }
        $model_grid->unsetAttributes(); // clear any default values
        if (isset($_GET['SubscribedProduct'])) {
            $model_grid->attributes = $_GET['SubscribedProduct'];
            //$model->attributes=$_REQUEST['id'];
        }

        if (isset($_POST['savedata'])) {
            if (isset($_POST['selectedIds'])) {
                //echo '<pre>';print_r($_POST);die;
                $colnum = array();
                // echo '<pre>';print_r($_POST);die;
                $no_of_selectedIds = count($_POST['selectedIds']);
                $no_of_Deletedataarray = count($_POST['Deletedataarray']);
                 if(isset($_POST['effective_price']))
                $no_of_effective_price = count($_POST['effective_price']);
                if(isset($_POST['discount_price']))
                $no_of_discount_price = count($_POST['discount_price']);
                if ($no_of_Deletedataarray > 0) {
                    

                    for ($i = 0; $i < $no_of_Deletedataarray; $i++) {
                        $val = $_POST['Deletedataarray'][$i];

                        if (isset($_POST['effective_price'][$val]) ) {
                            // echo "hello";die;
                            $df = 0;
                            $ef = $_POST['effective_price'][$val];
                            $status = $_POST['status'][$val];
                        } else {
                           
                            $ef = 0;
                            $df = $_POST['discount_price'][$val];
                            $status = $_POST['status'][$val];
                        }
                        if ($ef > 0 || $df > 0) {
                            $active_record = $model->savedatagridview($_REQUEST['id'], $val, $ef, $df, $status);
                            $model->solrbacklogRetailerProductQuotation($val, $_REQUEST['id']);
                            if ($active_record == '') {
                                Yii::app()->user->setFlash('success', 'Selected product list updated Successfully.');
                            } else {
                                Yii::app()->user->setFlash('premission_info', 'Please try again');
                            }
                        } else {
                             $cat_flag = 0;
                            $datatitle = $model->productnamelist($val);
                              if (isset($_POST['effective_price'][$val]) && $ef<0) {
                                
                                $df = 0;
                               // $ef = $_POST['store_offer_price'][$val];
                                 $ef = 0;
                                $status = $_POST['status'][$val];
                            } 
                            //echo $val;die;
                           
                           else if (isset($_POST['effective_price'][$val]) && $_POST['discount_price'][$val] == '0') {
                                
                                $df = 0;
                                $ef =0;
                                $status = $_POST['status'][$val];
                            } else {
                                $ef = 0;
                                $df = $_POST['discount_price'][$val];
                                $status = $_POST['status'][$val];
                            }


                            //$df = 0;
                            // $ef = $_POST['store_offer_price'][$val];
                            $status = $_POST['status'][$val];
                            $active_record = $model->savedatagridview($_REQUEST['id'], $val, $ef, $df, $status);
                            $model->solrbacklogRetailerProductQuotation($val, $_REQUEST['id']);


                            $colnum[] = $datatitle['0']['title'];
                            Yii::app()->user->setFlash('success', 'Selected product list updated Successfully.');
                            // Yii::app()->user->setFlash('premission_info', 'Product List effective price or discount price not Blank or Zero: ' . implode(' , ', $colnum));
                            //Yii::app()->user->setFlash('premission_info', 'Product effective price or discount price should not blank,zero or negative');
                        }
                    }
                }
            } else {
                if (isset($_POST['Deletedataarray'])) {
                    $no_of_Deletedataarray = count($_POST['Deletedataarray']);
                    for ($i = 0; $i < $no_of_Deletedataarray; $i++) {
                        $val = $_POST['Deletedataarray'][$i];
                        $df = $_POST['discount_price'][$val];
                        $status = $_POST['status'][$val];
                        $ef = $_POST['effective_price'][$val];
                        $active_record = $model->savedatagridview($_REQUEST['id'], $val, $ef, $df, $status);
                        $model->solrbacklogRetailerProductQuotation($val, $_REQUEST['id']);
                    }


                    //echo "heoo";die;
                    // Yii::app()->user->setFlash('premission_info', 'Product list not selected');
                } else {
                    Yii::app()->user->setFlash('premission_info', 'Product list not selected');
                }
            }
        }
        $this->render('admin', array(
            //'model' => $model,
            'model_grid' => $model_grid,
                //'id' => $_REQUEST['id'],
        ));
    }


    public function actionlistallproduct() {
        //echo '<pre>';//print_r($_POST);die;
        /*if (substr_count(Yii::app()->session['premission_info']['module_info']['subscribedProduct'], 'R') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }*/
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

    /*protected function beforeAction($action) {

        $session = Yii::app()->session['user_id'];

        if ($session == '') {
            echo Yii::app()->controller->redirect("index.php?r=site/login");
        }
        return true;
    }*/

    protected function beforeAction() {
        return parent::beforeAction();
    }

    public function  uploadPrices($retailer_id, $file){
        $index = false; 
        $productIdIndex = 0;
        $priceIndex = 0;
        $dateIndex = 0;
        $retailerProductQuotation = array();
        while(! feof($file)){
            $row = fgetcsv($file);
            if($index == false){
                for($i= 0 ; $i < sizeof($row) ; $i++) {
                    if(trim($row[$i]) == 'Subscribed Product ID'){
                        $productIdIndex = $i;
                    }
                    elseif(trim($row[$i])== 'Price(Store Offer Price)'){
                        $priceIndex = $i;
                    }
                    elseif(trim($row[$i]) == 'Effective Price Date'){
                        $dateIndex = $i;
                    }
                }
            }
            else{
                   // echo 'here in else <br>';
                    $retailerProductQuotation = RetailerProductQuotation::model()->findByAttributes(array('retailer_id' => $retailer_id, 'subscribed_product_id' => $row[$productIdIndex], 'status' => 1));
                    // var_dump($retailerProductQuotation);
                   if($retailerProductQuotation != null && $row[$priceIndex] != '' && is_numeric($row[$priceIndex])){
                        $retailerProductQuotation['effective_price'] = $row[$priceIndex];
                        $retailerProductQuotation['created_at'] = date("Y-m-d H:i:s");
                        $retailerProductQuotation->save();
                       // print_r($retailerProductQuotation->getErrors());
                        $connection = Yii::app()->secondaryDb;
                        $sql ='select date from cb_dev_groots.retailer_product_quotation_log where retailer_id = '."'".$retailer_id."'".' and subscribed_product_id = '."'".$row[$productIdIndex]."'".'and date = '."'".$row[$dateIndex]."'".'and status = 1';
                        $command = $connection->createCommand($sql);
                        $command->execute();
                        $resultDate = $command->queryAll();
                        $query = '';
                        if(isset($resultDate) && !empty($resultDate)){
                                $query = 'update cb_dev_groots.retailer_product_quotation_log set effective_price = '."'".$row[$priceIndex]."'".', action = '."'".'UPDATE'."'".', created_at = NOW() where  retailer_id = '."'".$retailer_id."'".' and subscribed_product_id = '."'".$row[$productIdIndex]."'".'and status = 1 and date = '."'".$row[$dateIndex]."'";
                             }
                        else {
                        $query = 'insert into cb_dev_groots.retailer_product_quotation_log (action, retailer_id , subscribed_product_id, effective_price, status, date) values('."'".'INSERT'."'".', '."'".$retailer_id."'".', '."'".$row[$productIdIndex]."'".', '."'".$row[$priceIndex]."'".', '."'".'1'."'".', '."'".$row[$dateIndex]."')";
                            }
                        $command = $connection->createCommand($query);
                        $command->execute();
                    }       
                }
            $index = true;
        }
    }

    public function getLastOrderId(){
        $sql = 'select order_id from order_header order by order_id desc limit 1';
        $connection = Yii::app()->secondaryDb;
        $command = $connection->createCommand($sql);
        $command->execute();
        $result = $command->queryAll();
        return $result[0]['order_id'];
    }


    public function getIdByNameMap(){
        $file = fopen( dirname(__FILE__).'/Book1.csv', "rb");
        $start = true;
        $title = array();
        $index= array();
        while(!feof($file)){
            $row = fgetcsv($file);
            if($row[0] != ''){
                //var_dump($row);die;
                if($start){
                    for ($key=0; $key < count($row); $key++){
                        $value = $row[$key];
                        if($value == 'retailer id')
                            $index['r_id'] = $key;
                        else if($value == 'Product')
                            $index['p_name'] = $key;
                        else if($value == 'date')
                            $index['date'] = $key;
                        else if($value == 'Quantity')
                            $index['qty'] = $key;
                        else if($value == 'Price')
                            $index['price'] = $key;
                    }
                }
                else{
                    array_push($title, '"'.$row[$index['p_name']].'"');
                }
                $start = false;
            }
        }
        $ids = self::returnIdByName($title);
        //var_dump($ids);die;
        return $ids;
    }
    public function actionTest(){
        //die('here');
        echo "<pre>";
        $file = fopen( dirname(__FILE__).'/Book1.csv', "rb");
        $start = true;
        $index = array();
        $data = array();
        $title = array();
        $idByName = self::getIdByNameMap();
        //var_dump($idByName);die;
        $line = array();
        while(!feof($file)){
            $row = fgetcsv($file);
            if($row[0] != ''){
                //var_dump($row);die;
                array_push($title, $row[1]);
                if($start){
                    for ($key=0; $key < count($row); $key++){
                        $value = $row[$key];
                        if($value == 'retailer id')
                            $index['r_id'] = $key;
                        else if($value == 'Product')
                            $index['p_name'] = $key;
                        else if($value == 'date')
                            $index['date'] = $key;
                        else if($value == 'Quantity')
                            $index['qty'] = $key;
                        else if($value == 'Price')
                            $index['price'] = $key;
                    }
                }
                else{
                    $r_id = $row[$index['r_id']];
                    $product = $row[$index['p_name']];
                   // var_dump($product);die;$product;
                    $rate = $row[$index['price']];
                    $qty = $row[$index['qty']];
                    $date = $row[$index['date']];
                    $currentIndex = $r_id.'_'.$date;
                    if(!isset($data[$currentIndex])){
                        $data[$currentIndex] = array();
                        $data[$currentIndex]['user_id'] = $r_id;
                        $data[$currentIndex]['created_date'] = date('Y-m-d', strtotime($date.' -1 day'));
                        $data[$currentIndex]['status'] = '';
                        $data[$currentIndex]['delivery_date'] = $date;
                        $data[$currentIndex]['warehouse_id'] = 1;
                        $data[$currentIndex]['total'] = $qty*$rate;
                    }
                    else{
                        $data[$currentIndex]['total'] += $qty*$rate;                
                    }
                    if(!isset($line[$currentIndex])){
                        $line[$currentIndex] = array();
                    }
                    $p_id = $idByName[$product]['base_product_id'];
                    $line[$currentIndex][$p_id] = array();
                    $line[$currentIndex][$p_id]['subscribed_product_id'] = $idByName[$product]['subscribed_product_id'];
                    $line[$currentIndex][$p_id]['base_product_id'] = $p_id;
                    $line[$currentIndex][$p_id]['product_qty'] = $qty;
                    $line[$currentIndex][$p_id]['delivered_qty'] = $qty;
                    $line[$currentIndex][$p_id]['unit_price'] = $rate;
                    $line[$currentIndex][$p_id]['price'] = $qty*$rate ;
                    $line[$currentIndex][$p_id]['product_name'] = $product ;
                    $line[$currentIndex][$p_id]['created_date'] = date('Y-m-d', strtotime($date.' -1 day'));
                }
                $start = false;
            }
        }
        self::saveData($data,$line);
    }


    public function saveData($header, $line){
        foreach ($header as $key => $value) {
            $lastOrderId = self::getLastOrderId();
            $currentOrderId = $lastOrderId + 1;
            $value['order_number'] = 'GRT'.$currentOrderId;
            $value['total_payable_amount'] = $value['total'];
            $header[$key] = $value;
            $index = $key;
            $order_id =  self::saveOrderHeader($value);
            foreach ($line[$index] as $lineKey => $lineValue) {
                $lineValue['order_id'] = $order_id;
                $line[$index][$lineKey] = $lineValue; 
                self::saveOrderLine($lineValue, $order_id);
            }
        }
        //  die('here');
    }


    public function saveOrderHeader($data){
       // var_dump($data);
        mysql_connect('localhost','root', 'root');
        $sql = 'insert into groots_orders.order_header (user_id , order_number, created_date , delivery_date, warehouse_id, total, total_payable_amount, status) values ("'.$data['user_id'].'","'.$data['order_number'].'", "'.$data['created_date'].'", "'.$data['delivery_date'].'", "'.$data['warehouse_id'].'", "'.$data['total'].'", "'.$data['total_payable_amount'].'", "Delivered")';
        //print_r($sql);die;
        mysql_query($sql);
        $order_id = mysql_insert_id();
        $sql = 'update order_header set order_number = "GRT'.$order_id.'" where order_id = "'.$order_id.'"';
        return $order_id;

    }

    public function saveOrderLine($data, $order_id){
        //var_dump($data);
        mysql_connect('localhost','root', 'root');
        $sql = 'insert into groots_orders.order_line (subscribed_product_id, base_product_id, product_qty, delivered_qty, unit_price, price, created_date, order_id, store_id, product_name) values ("'.$data['subscribed_product_id'].'", "'.$data['base_product_id'].'", "'.$data['product_qty'].'", "'.$data['delivered_qty'].'", "'.$data['unit_price'].'", "'.$data['price'].'", "'.$data['created_date'].'", "'.$order_id.'", 1, "'.$data['product_name'].'")';
        //print_r($sql);die;
        mysql_query($sql);
        $order_id = mysql_insert_id();
        $sql = 'update order_header set order_number = "GRT'.$order_id.'" where order_id = "'.$order_id.'"';
    }

    public function returnIdByName($array){
        $string = implode(',', $array);
        $sql = 'select title, base_product_id from cb_dev_groots.base_product where title in ('.$string.')';
        //print_r($sql);die;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
        $result = $command->queryAll();
        //var_dump($result);die;
        $map = array();
        $ids = array();
        foreach ($result as $key => $value) {
            array_push($ids, $value['base_product_id']);
        }
        $ids = implode(',', $ids);
        $sql2 = 'select subscribed_product_id, base_product_id from cb_dev_groots.subscribed_product where base_product_id in ('.$ids.')';
        $command = $connection->createCommand($sql2);
        $command->execute();
        $result2 = $command->queryAll();
        //var_dump($result2);die;
        $spiMap = array();
        foreach ($result2 as $key => $value) {
            $spiMap[$value['base_product_id']] = $value['subscribed_product_id'];
        }
        foreach ($result as $key => $value) {
           $map[$value['title']] = array();
            $tempMap = array('base_product_id' => $value['base_product_id'], 'subscribed_product_id' => $spiMap[$value['base_product_id']]);
            $map[$value['title']] = $tempMap; 
        }
       // var_dump($map);die;
        return $map;
    }
}
