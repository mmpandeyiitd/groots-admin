<?php

class OrderHeaderController extends Controller {

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
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'sales_by_retailer','sales_by_retailer_detail', 'sale_by_style','sale_by_style_dateial', 'sale_summery','sale_summery_detail', 'view', 'admin', 'report', 'Dispatch'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'report', 'Dispatch'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'admin', 'report'),
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
        $model = new OrderHeader;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['OrderHeader'])) {
            $model->attributes = $_POST['OrderHeader'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->order_id));
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
        $model = OrderLine::model()->findAllByAttributes(array('order_id' => $id));
        $modelOrder = $this->loadModel($id);


        // $model1= new OrderLine; 
        // echo "<pre>";
        // print_r($_REQUEST);

        if (isset($_POST['Update'])) {

            //........................chk .....................//
            $totalchk = 0;
            $unit_price_discount=array();
//            foreach ($_POST['total_price_discount'] as $key => $value) {
//                $totalchk = $value + $totalchk;
//            }
//            $totalchk = $totalchk + $_POST['gtotal_price_discount'];
//
//            if ($totalchk > $_POST['grand_total']) {
//                Yii::app()->user->setFlash('error', 'Grand total can,t be less than Zero.');
//                $this->redirect(array('OrderHeader/update', 'id' => $_REQUEST['order_id']));
//            } else {
                //....................end..........................//
                $linedescinfo = new OrderLine;
                $status=array();
                
                  if(isset($_POST['Status'])){
                    $status= $_POST['Status'];
                    $no_Status=  count($_POST['Status']);
                  for($p=0;$p<$no_Status;$p++) {
                    $status_data=  explode('<>',$status[$p]);
                    $update_status=$status_data[0];
                    $orderline_ids=$status_data[1];
                    $lineinfo = $linedescinfo->UpdatedStatus($update_status, $orderline_ids);
                 }
                  }
             if(isset($_POST['unit_price_discount'])&&isset($_POST['unit_price_discount_old'])&&!empty($_POST['orderline_ids_discount'])){  
                 $no_records=  count($_POST['unit_price_discount']);
                 for($p=0;$p<$no_records;$p++) {
                     
                       $unit_price_discount=$_POST['unit_price_discount'][$p];
                       $unit_price_discount_old=$_POST['unit_price_discount_old'][$p];
                       $unit_price=$_POST['unit_price'][$p];
                       $status_update=$status[$p];
                         $orderline_ids_discount=$_POST['orderline_ids_discount'][$p];       
                    //   die;
                       if($unit_price_discount!=$unit_price_discount_old && $unit_price>=$unit_price_discount){
                        $lineinfo = $linedescinfo->Updatediscountquantity($unit_price_discount, $orderline_ids_discount);
                           Yii::app()->user->setFlash('success', 'Unit Price updated Successfully.');
                        }
                   }
             }
                if(isset($_POST['uniq_order_size'])&&isset($_POST['sizeqty'])&&isset($_POST['sizeqty_old'])){
                  $no_records=  count($_POST['uniq_order_size']);
               
                  
                for($i=0;$i<$no_records;$i++) {
                    $uniq_order_size=$_POST['uniq_order_size'][$i];
                     $size_detail=  explode('>', $uniq_order_size);
                     $order_line_id=$size_detail[0];
                     $baseproduct_id=$size_detail[1];
                     $size_quantity=$_POST['sizeqty'][$i];
                     $sizeqty_old=$_POST['sizeqty_old'][$i];
                   //  $unit_price_discount_qnt=$_POST['unit_price_discount'][$i];
                     
                     if($sizeqty_old!=$size_quantity){
                     $lineinfo = $linedescinfo->Updatesizequantity($order_line_id, $baseproduct_id,$size_quantity);
                      Yii::app()->user->setFlash('success', 'Size Quantity updated Successfully.');
                     }
                }
                }

              //  $oderdescinfo = new OrderHeader;
            //  $orderinfo = $oderdescinfo->updatelinedescById($_POST['order_id'], $_POST['grand_total'], $_POST['gtotal_price_discount']);



                $this->redirect(array('OrderHeader/update', 'id' => $_POST['order_id'],));
               //  $this->redirect(array('OrderLine/update', 'id' => $_POST['id'], 'order_id' => $_POST['order_id'], 'status' => $_POST['Status'], 'unit_price_discount' => $_POST['unit_price_discount'], 'total_price_discount' => $_POST['total_price_discount']));
           // }
        }

        #............update Shipping Address............
        if (isset($_POST['update_shipping_address'])) {
            if (isset($_POST['shipping_name'])) {
                $modelOrder->shipping_name = $_POST['shipping_name'];
            }
            if (isset($_POST['shipping_address'])) {
                $modelOrder->shipping_address = $_POST['shipping_address'];
            }
            if (isset($_POST['shipping_city'])) {
                $modelOrder->shipping_city = $_POST['shipping_city'];
            }
            if (isset($_POST['shipping_state'])) {
                $modelOrder->shipping_state = $_POST['shipping_state'];
            }
            if (isset($_POST['shipping_phone'])) {
                $modelOrder->shipping_phone = $_POST['shipping_phone'];
            }
            if (isset($_POST['shipping_pincode'])) {
                $modelOrder->shipping_pincode = $_POST['shipping_pincode'];
            }

            if ($modelOrder->save()) {
                Yii::app()->user->setFlash('success', 'Shipping address updated Successfully.');
            } else {
                Yii::app()->user->setFlash('error', 'Invalid Entry.');
            }
        }
        #...........End update Shipping Address............

        $this->render('update', array(
            'model' => $model,
            'modelOrder' => $modelOrder
        ));
    }

    public function actionDispatch($id) {

        $model = OrderLine::model()->findAllByAttributes(array('order_id' => $id));
        $modelOrder = $this->loadModel($id);
        $dispatch_model = new Dispatch();
        $courier_name = '';
        $dispatched_date = '';
        $qty = array();
        $track_id = '';
        $remaining_qty = array();

        if (isset($_POST['save'])) {

            if (isset($_POST['order_id'])) {
                $order_id = $_POST['order_id'];
                $dispatch_model->order_id = $_POST['order_id'];
            }
            if (isset($_POST['subscribed_product'])) {
                $subscribed_product = $_POST['subscribed_product'];
            }
            if (isset($_POST['courier_name'])) {
                $courier_name = $_POST['courier_name'];
                $dispatch_model->courier_name = $_POST['courier_name'];
            }
            if (isset($_POST['dispatched_date'])) {
                $dispatched_date = $_POST['dispatched_date'];
                $dispatch_model->dispatched_date = $_POST['dispatched_date'];
            }
            if (isset($_POST['qty'])) {
                $qty = $_POST['qty'];
            }
            if (isset($_POST['remaining_qty'])) {
                $remaining_qty = $_POST['remaining_qty'];
            }
            if (isset($_POST['total_qty'])) {
                $total_qty = $_POST['total_qty'];
            }

            if (isset($_POST['track_id'])) {
                $track_id = $_POST['track_id'];
                $dispatch_model->track_id = $_POST['track_id'];
            }
            // $sql="INSERT INTO order_header (order_id,baseproduct_id,qty,track_id,dispatched_date,courier_name)VALUES ";
            // for( $i=0;$i<$count_record;$i++){
            // $sql .="('".$order_id."','".$baseproduct_id[$i]."','".$qty[$i]."','".$track_id."','".$dispatched_date."','".$courier_name."'),";
            // }   
            //  $sql=  rtrim($sql,',');
            // $succ= $dispatch_model->Insert_paertial_shipment($sql);
            //$dispatch_model->shipping_partner = $_POST['shipping_partner'];

            $flag = 0;
            $count_record = count($qty);

            for ($i = 0; $i < $count_record; $i++) {
                $dispatch_model->subscribed_product_id = $subscribed_product[$i];
                $dispatch_model->qty = $qty[$i];
                $addable = $remaining_qty[$i] + $qty[$i];

                if (($remaining_qty[$i] > 0) && ($qty[$i] > 0) && ($addable <= $total_qty[$i] || $remaining_qty[$i] == $total_qty[$i])) {
                    if ($dispatch_model->save()) {
                        $flag++;
                    }
                }
            }


            if ($flag > 0) {
                Yii::app()->user->setFlash('success', '' . $flag . ' Record Added Successfully.');
            } else if ($flag == 0) {
                Yii::app()->user->setFlash('error', 'Invalid Entry.');
            }
        }

        $this->render('dispatch', array(
            'model' => $model,
            'modelOrder' => $modelOrder,
            'dispatch_model' => $dispatch_model,
            'track_id' => $track_id,
            'qty' => $qty,
            'dispatched_date' => $dispatched_date,
            'courier_name' => $courier_name,
        ));
    }

    public function actionEdit($id) {
        $model = OrderLine::model()->findAllByAttributes(array('order_id' => $id));


        // $model1= new OrderLine; 
        if (isset($_POST['Update'])) {
            $this->redirect(array('OrderLine/update', 'id' => $_POST['id'], 'order_id' => $_POST['order_id'], 'status' => $_POST['Status']));
        }

        $this->render('edit', array(
            'model' => $model,
            'modelOrder' => $modelOrder,
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
        $dataProvider = new CActiveDataProvider('OrderHeader');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionsale_summery() {
        $model = new SalesSummery('search_1');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SalesSummery']))
            $model->attributes = $_GET['SalesSummery'];

        $this->render('sales_summery', array(
            'model' => $model,
        ));
    }
    
     public function actionsale_summery_detail() {
        $model = new SalesSummery('search_1');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SalesSummery']))
            $model->attributes = $_GET['SalesSummery'];

        $this->render('sales_summery_detail', array(
            'model' => $model,
        ));
    }

    public function actionsale_by_style() {
        $model = new SaleByStyles('search_1');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SaleByStyles']))
            $model->attributes = $_GET['SaleByStyles'];

        $this->render('sale_by_style', array(
            'model' => $model,
        ));
    }
    public function actionsale_by_style_detail() {
        $model = new SaleByStyles('search_1');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SaleByStyles']))
            $model->attributes = $_GET['SaleByStyles'];

        $this->render('sale_by_style_detail', array(
            'model' => $model,
        ));
    }

    public function actionsales_by_retailer() {
        $model = new SaleByRetailer('search_1');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SaleByRetailer']))
            $model->attributes = $_GET['SaleByRetailer'];

        $this->render('sales_by_retailer', array(
            'model' => $model,
        ));
    }
     public function actionsales_by_retailer_detail() {
         $model = new OrderHeader('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SaleByRetailer']))
            $model->attributes = $_GET['SaleByRetailer'];

        $this->render('sales_by_retailer_detail', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new OrderHeader('search');

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OrderHeader']))
            $model->attributes = $_GET['OrderHeader'];
        //echo "eeeee";die;
        if (isset($_POST['cancelbutton'])) {
            if (isset($_POST['selectedIds'])) {
                $no_of_selectedIds = count($_POST['selectedIds']);
                if ($no_of_selectedIds > 0) {
                    $order_ids = implode(',', $_POST['selectedIds']);
                    $active_record = $model->CancelOrderByID($order_ids);
                    if ($active_record) {
                        Yii::app()->user->setFlash('premission_info', 'Selected order list updated Successfully.');
                    } else {
                        Yii::app()->user->setFlash('premission_info', 'Please Try again.');
                    }
                }
            } else {
                Yii::app()->user->setFlash('premission_info', 'Please select at least one order.');
            }
        }

        if (isset($_POST['downloadbutton'])) {

            if (isset($_POST['selectedIds'])) {
                $no_of_selectedIds = count($_POST['selectedIds']);
                if ($no_of_selectedIds > 0) {
                    $order_ids = implode(',', $_POST['selectedIds']);
                    ob_clean();
                    $model->downloadCSVByIDs($order_ids);
                    ob_flush();
                    exit();
                }
            } else {
                Yii::app()->user->setFlash('premission_info', 'Please select at least one order.');
            }
        }





        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return OrderHeader the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = OrderHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param OrderHeader $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-header-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionReport($id) {
        $model = OrderLine::model()->findAllByAttributes(array('order_id' => $id));
        $modelOrder = $this->loadModel($id);
        $this->renderPartial('reportview', array(
            'model' => $model,
            'modelOrder' => $modelOrder,
        ));
        //$this->renderPartial("reportview");
    }

}