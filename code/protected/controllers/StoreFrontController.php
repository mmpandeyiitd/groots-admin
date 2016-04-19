<?php

class StoreFrontController extends Controller {

    public $status;

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
                // 'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('index', 'delete', 'view', 'bulkupload', 'admin', 'StyleAddInLinesheet', 'CreateFileDownload', 'UpdateFileDownload', 'Export', 'addedStyleInLinesheet'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'delete', 'update', 'bulkupload', 'StyleAddInLinesheet', 'addedStyleInLinesheet', 'admin', 'CreateFileDownload', 'UpdateFileDownload', 'map_linesheet_retailers', 'Export'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'bulkupload', 'CreateFileDownload', 'UpdateFileDownload', 'Export', 'map_linesheet_retailers'),
                'users' => array('admin', '*'),
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
    public function actionView() {
        $this->render('view', array(
            'model' => $this->loadModel(),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $id = Yii::app()->session['store_id'];
        $getrecord = new UserStore();
        $record = $getrecord->getRecordById($id);
        $this->render('_view', array(
            'myVariable' => $record,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {

        $model = new StoreFront('search');
        $store_id = 0;
        $issuperadmin = Yii::app()->session['is_super_admin'];
        if ($issuperadmin == 1) {
            $store_id = Yii::app()->session['brand_admin_id'];
        } else {
            $store_id = Yii::app()->session['brand_id'];
        }

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StoreFront']))
            $model->attributes = $_GET['StoreFront'];


        if (isset($_POST['inactivebutton'])) {
            if (isset($_POST['selectedIds'])) {
                $no_of_selectedIds = count($_POST['selectedIds']);
                if ($no_of_selectedIds > 0) {
                    $store_front_ids = implode(',', $_POST['selectedIds']);
                    $active_record = $model->doInActiveLinsheetByID($store_front_ids, $store_id);
                    if ($active_record) {
                        Yii::app()->user->setFlash('premission_info', 'Selected line sheet updated Successfully.');
                    } else {
                        Yii::app()->user->setFlash('premission_info', 'Please Try again.');
                    }
                }
            } else {
                Yii::app()->user->setFlash('premission_info', 'Please select at least one Line Sheet.');
            }
        }

        if (isset($_POST['activebutton'])) {
            if (isset($_POST['selectedIds'])) {
                $no_of_selectedIds = count($_POST['selectedIds']);

                if ($no_of_selectedIds > 0) {
                    $store_front_ids = implode(',', $_POST['selectedIds']);
                    $active_record = $model->doActiveLinsheetByID($store_front_ids, $store_id);
                    // echo $no_of_selectedIds;die;
                    if ($active_record) {
                        Yii::app()->user->setFlash('premission_info', 'Selected line sheet updated Successfully.');
                    } else {
                        Yii::app()->user->setFlash('premission_info', 'Please Try again.');
                    }
                }
            } else {
                Yii::app()->user->setFlash('premission_info', 'Please select at least one Line Sheet.');
            }
        }
        if (isset($_POST['downloadbutton'])) {
            if (isset($_POST['selectedIds'])) {
                $no_of_selectedIds = count($_POST['selectedIds']);
                if ($no_of_selectedIds > 0) {
                    $store_front_ids = implode(',', $_POST['selectedIds']);
                    ob_clean();
                    $model->downloadCSVByIDs($store_front_ids, $store_id);
                    ob_flush();
                    exit();
                }
            } else {
                Yii::app()->user->setFlash('premission', 'Please select at least one Line Sheet.');
            }
        }

        $this->render('admin', array(
            'model' => $model,
                //  'store_id'=>$_GET['store_id']
        ));
    }

    public function actionmap_linesheet_retailers($id) {

        if (substr_count(Yii::app()->session['premission_info']['module_info']['linesheet'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        $model = new StoreFront('search');
        $model_retailers = new Retailer();

        if (isset($_GET['StoreFront'])) {
            $model->attributes = $_GET['StoreFront'];
            $model_retailers->unsetAttributes();
        }// clear any default values

        if (isset($_POST['Retailer'])) {

            if (isset($_POST['save']) && isset($_POST['retailers'])) {

                if (count($_POST['retailers']) > 0) {
                    $retailers = $_POST['retailers'];
                    $model->storefrnt_retailer_mapping($id, $retailers);
                    Yii::app()->user->setFlash('success', 'Updated Successfully.');
                }
            }
        }
        $model_retailers->unsetAttributes();
        $this->render('map_linesheet_retailers', array(
            'model' => $model,
            'model_retailers' => $model_retailers,
        ));
    }

    public function actionaddedStyleInLinesheet($id) {
        if (substr_count(Yii::app()->session['premission_info']['module_info']['linesheet'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        $model = new StoreFront('search');
        $model_base = new BaseProduct();

        if (isset($_GET['StoreFront'])) {
            $model->attributes = $_GET['StoreFront'];
            $model_base->unsetAttributes();
        }// clear any default values


        if (isset($_POST['delete']) && isset($_POST['productsids'])) {

            if (count($_POST['productsids']) > 0) {
                $products = implode(',', $_POST['productsids']);
                $check_execution = $model->Deletebaseproductfromstorefront($id, $products);
                if ($check_execution && isset($_GET['store_id']) && is_numeric($_GET['store_id'])) {
                    #.......................solor backloag.................//
                    $solrBackLog = new SolrBackLog();
                    //$is_deleted =  ($model->status == 1) ? 0 : 1;
                    $is_deleted = '0';
                    $solrBackLog->insertByStoreId($_GET['store_id'], $is_deleted);
                    //.........................end.....................................//
                }

                Yii::app()->user->setFlash('success', 'Line Sheet Updated Successfully.');
            }
        }

        $model_base->unsetAttributes();
        $this->render('addedStyleInLinesheet', array(
            'model' => $model,
            'model_base' => $model_base,
        ));
    }

    public function actionStyleAddInLinesheet($id) {
        if (substr_count(Yii::app()->session['premission_info']['module_info']['linesheet'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        $model = new StoreFront('search');
        $model_base = new BaseProduct();

        if (isset($_GET['StoreFront'])) {
            $model->attributes = $_GET['StoreFront'];
            $model_base->unsetAttributes();
        }// clear any default values


        $search = '';
        if (isset($_POST['searchsubmit'])) {
            $search = $_POST['searchtext'];
        }

        if (isset($_POST['save']) && isset($_POST['productsids'])) {

            if (count($_POST['productsids']) > 0) {
                $products = $_POST['productsids'];
                $check_execution = $model->storefrnt_products_mapping($id, $products);

                if ($check_execution && isset($_GET['store_id']) && is_numeric($_GET['store_id'])) {
                    #.......................solor backloag.................//
                    $solrBackLog = new SolrBackLog();
                    //$is_deleted =  ($model->status == 1) ? 0 : 1;
                    $is_deleted = '0';
                    $solrBackLog->insertByStoreId($_GET['store_id'], $is_deleted);
                    //.........................end.....................................//
                }
                Yii::app()->user->setFlash('success', 'Style Added in Linesheet Successfully.');
                $this->render('addedStyleInLinesheet', array(
                    'model' => $model,
                    'model_base' => $model_base,
                    'search' => $search,
                ));
                exit();
            }
        } else if (isset($_POST['save'])) {
            Yii::app()->user->setFlash('error_error', 'Select at least one Style.');
        }
        $model_base->unsetAttributes();
        $this->render('StyleAddInLinesheet', array(
            'model' => $model,
            'model_base' => $model_base,
            'search' => $search,
        ));
    }

    public function actionCreate() {
        if (substr_count(Yii::app()->session['premission_info']['module_info']['linesheet'], 'C') == 0) {

            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        $model = new StoreFront();
        if (isset($_POST['StoreFront'])) {
            $issuperadmin = Yii::app()->session['is_super_admin'];
            // $chk = $model->ChkStoreFront($_POST['StoreFront']);
            if ($issuperadmin == 1) {
                $model->store_id = $_GET['store_id'];
            } else {
                $model->store_id = Yii::app()->session['brand_id'];
            }
            if (isset($_POST['status'])) {
                $model->status = $_POST['status'];
            } else {
                $model->status = 0;
            }
            //  if ($chk) {
            $retailers = array();
            $model->attributes = $_POST['StoreFront'];
            if (isset($_POST['retailerchecked'])) {
                $retailers = $_POST['retailerchecked'];
            }
            $model->image = CUploadedFile::getInstance($model, 'image');
            $model->pdf = CUploadedFile::getInstance($model, 'pdf');
            if (isset($_POST['visibletoall'])) {
                $model->visibletoall = $_POST['visibletoall'];
            } else {
                $model->visibletoall = 0;
            }
            if ($model->save()) {

                $storefront_id = $model->store_front_id;
                $retailer_mapped = $retailers;
                if ((count($retailers) > 0) && ($model->visibletoall != 1)) {
                    $model->storefrnt_retailer_mapping($storefront_id, $retailer_mapped);
                }

                Yii::app()->user->setFlash('success', 'Line Sheet Created Successfully');
                $this->redirect(array('update', 'id' => $model->store_front_id, 'store_id' => $_GET['store_id']));
            }
//            } else {
//                Yii::app()->user->setFlash('success', 'StoreFront already Created !');
//            }
        }
        $model_retailer = new Retailer();
        $this->render('create', array(
            'model' => $model,
            'model_retailer' => $model_retailer
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {

        if (substr_count(Yii::app()->session['premission_info']['module_info']['linesheet'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        $model = $this->loadModel($id);
        $issuperadmin = Yii::app()->session['is_super_admin'];
        if (isset($_POST['StoreFront']) && isset($id)) {
            $model->attributes = $_POST['StoreFront'];

            if (isset($_POST['yt1']) && ($_POST['yt1'] == 'Delete')) {
                if (substr_count(Yii::app()->session['premission_info']['module_info']['linesheet'], 'D') > 0 && Yii::app()->session['brand_admin_id'] == $_GET['store_id']) {
                    $tremove = $model->deleteSTOREFRONT($id);
                    Yii::app()->user->setFlash('Delete', 'Press Release Deleted successfully.');
                    $this->redirect(array('admin', 'store_id' => $_GET['store_id']));
                } else {
                    Yii::app()->user->setFlash('premission', 'No permission to delete');
                    $this->redirect(array('update', 'id' => $model->id, 'store_id' => $_GET['store_id']));
                    exit;
                }
            }

            $retailers = array();

            if (isset($_POST['retailerchecked'])) {
                $retailers = $_POST['retailerchecked'];
            }
            //  print_r($retailers);die;
            if ($issuperadmin == 1) {
                $model->store_id = $_GET['store_id'];
            } else {
                $model->store_id = Yii::app()->session['brand_id'];
            }
            $model->image = CUploadedFile::getInstance($model, 'image');
            $model->pdf = CUploadedFile::getInstance($model, 'pdf');
            if (empty($model->pdf))
                unset($model['pdf']);
            if (empty($model->image))
                unset($model['image']);
            if (isset($_POST['visibletoall'])) {
                $model->visibletoall = $_POST['visibletoall'];
            } else {
                $model->visibletoall = 0;
            }
            if ($model->save()) {
                $retailer_mapped = $retailers;
                if ((count($retailers) > 0) && ($model->visibletoall != 1)) {
                    $model->storefrnt_retailer_mapping($id, $retailer_mapped);
                }

                #.......................solor backloag.................//
                $solrBackLog = new SolrBackLog();
                //$is_deleted =  ($model->status == 1) ? 0 : 1;
                $is_deleted = '0';
                $solrBackLog->insertByStoreId($model->store_id, $is_deleted);
                //.........................end.....................................//

                Yii::app()->user->setFlash('success', 'Updated Successfully.');
                $this->redirect(array('update', 'id' => $model->store_front_id, 'store_id' => $_GET['store_id']));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'id' => $model->store_front_id,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Store the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = StoreFront::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Store $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'store-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionBulkUpload() {

        $model = new FrontCSV;
        //$file = CUploadedFile::getInstance($model,'csv_file');
        $logfile = '';

        if (isset($_POST['FrontCSV'])) {
            $log_db = Yii::app()->db_log;
            // inserting log
            $model->attributes = $_POST['FrontCSV'];
            $oldAttrs = json_encode($model->attributes);

            $sql = "INSERT INTO log_master_stores_front(user_id,login_id,name,action,work_info,work_info_after_save,created_at,ip_address)VALUES('" . Yii::app()->session['user_id'] . "','" . @$login_id . "','store front bulk upload','upload','','" . $oldAttrs . "','" . date('Y:m:d h-i-s') . "','" . $_SERVER['REMOTE_ADDR'] . "')";
            $command = $log_db->createCommand($sql);
            $command->execute();


            $model->attributes = $_POST['FrontCSV'];
            if (!empty($_FILES['FrontCSV']['tmp_name']['csv_file'])) {
                $csv = CUploadedFile::getInstance($model, 'csv_file');
                if (!empty($csv)) {
                    if ($csv->size > 25 * 1024 * 1024) {

                        Yii::app()->user->setFlash('error', 'Cannot upload file greater than 25MB');
                        $this->render('bulkupload', array('model' => $model));
                    }
                    $fileName = 'csvupload/' . $csv->name;

                    $filenameArr = explode('.', $fileName);
                    $fileName = $filenameArr[0] . '-' . Yii::app()->session['sessionId'] . '-' . time() . '.' . end($filenameArr);
                    $csv->saveAs($fileName);
                } else {
                    Yii::app()->user->setFlash('error', 'Please browse a CSV file to upload.');
                    $this->render('bulkupload', array('model' => $model));
                }

                // $fileName = $model->csv_file;


                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                if ($ext != 'csv') {
                    Yii::app()->user->setFlash('error', 'Only .csv files allowed.');
                    $this->render('bulkupload', array('model' => $model));
                }

                $i = 0;
                $requiredFields = array('subscribed_product_id', 'store_front_id');
                $defaultFields = array('subscribed_product_id', 'store_front_id', 'is_deleted');

                if (($handle = fopen("$fileName", "r")) !== FALSE) {
                    $logDir = "log/";
                    $logfile = 'bulk_upload_log_' . Yii::app()->session['sessionId'] . '_' . time() . '.txt';
                    $handle1 = fopen($logDir . $logfile, "a");
                    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                        if ($i >= 0 && count($data) > 0) {
                            $i++;
                            /* header */
                            if ($i == 1) {



                                $colDiff = array_diff($requiredFields, $data);


                                if (!empty($colDiff)) {
                                    Yii::app()->user->setFlash('error', 'Required columns missing : ' . implode(' , ', $colDiff));


                                    break;
                                }

                                foreach ($data as $key => $value) {
                                    $data[$key] = trim($value);
                                    if (in_array($value, $defaultFields)) {
                                        $cols[$value] = $key;
                                    } elseif ($value != "") {
                                        $originalExtraAttrs[$value] = $key;
                                        $value = mysql_real_escape_string($value);
                                        $extraAttributes[$value] = $key;
                                    }
                                }
                            } else {
                                $row = array();


                                if (isset($cols['subscribed_product_id']))
                                    $row['subscribed_product_id'] = trim($data[$cols['subscribed_product_id']]);
                                else
                                    $row['subscribed_product_id'] = '';
                                if (isset($cols['store_front_id']))
                                    $row['store_front_id'] = trim($data[$cols['store_front_id']]);
                                else
                                    $row['store_front_id'] = '';
                                if (isset($cols['is_deleted']))
                                    $row['is_deleted'] = trim($data[$cols['is_deleted']]);
                                else
                                    $row['is_deleted'] = '';



                                if (!empty($row['store_front_id']) && !empty($row['subscribed_product_id']) && $row['is_deleted'] != '') {
                                    $connection = Yii::app()->db;
                                    $sqlchk = "SELECT `store_front_id` FROM `store_front` WHERE `store_front_id`='" . $row['store_front_id'] . "'";

                                    $command = $connection->createCommand($sqlchk);
                                    $command->execute();
                                    $rs = $command->queryAll();



                                    $sqlchksubsid = "SELECT `subscribed_product_id` FROM `subscribed_product` WHERE `subscribed_product_id`='" . $row['subscribed_product_id'] . "'";
                                    $command1 = $connection->createCommand($sqlchksubsid);
                                    $command1->execute();
                                    $rssubs = $command1->queryAll();


                                    if (isset($rs[0]['store_front_id']) && isset($rssubs[0]['subscribed_product_id'])) {


                                        //.............storeFront..................//

                                        $sqlDeletesf = "Delete From `product_frontend_mapping` Where subscribed_product_id='" . $row['subscribed_product_id'] . "' And store_front_id='" . $row['store_front_id'] . "'";
                                        $command = $connection->createCommand($sqlDeletesf);
                                        $command->execute();

                                        if ($row['is_deleted'] == 0) {
                                            $sqlInsertsf = "INSERT INTO `product_frontend_mapping`(`subscribed_product_id`,`store_front_id`) VALUES ('" . $row['subscribed_product_id'] . "','" . $row['store_front_id'] . "')";
                                            $command = $connection->createCommand($sqlInsertsf);
                                            $command->execute();
                                        }
                                        //..........................end.........................//
                                        //...............solor backlog.................//

                                        $sqlDeletesbl = "Delete From `solr_back_log` Where subscribed_product_id='" . $row['subscribed_product_id'] . "'";
                                        $command = $connection->createCommand($sqlDeletesbl);
                                        $command->execute();

                                        $sqlInsertsbl = "INSERT INTO `solr_back_log`(`subscribed_product_id`) VALUES ('" . $row['subscribed_product_id'] . "')";
                                        $command = $connection->createCommand($sqlInsertsbl);
                                        $command->execute();
                                        //..........................end...........................//
                                        if ($row['is_deleted'] == 0) {
                                            fwrite($handle1, "\nRow :  Store Front id is '" . $row['store_front_id'] . "' mapping with subscribed_product_id '" . $row['subscribed_product_id'] . "' ");
                                        } else {
                                            fwrite($handle1, "\nRow :  Store Front id is '" . $row['store_front_id'] . "' Not mapping with subscribed_product_id '" . $row['subscribed_product_id'] . "' ");
                                        }
                                    } else {
                                        fwrite($handle1, "\nRow :  Store Front ID ('" . $row['store_front_id'] . "')  Or  Subscribed_product_id ('" . $row['subscribed_product_id'] . "') Not Found.");
                                    }
                                } else {
                                    fwrite($handle1, "\nRow :  Store Front ID Or Subscribed_product_id May be Blank.");
                                }
                            }
                        }
                    }
                    Yii::app()->user->setFlash('success', 'Upload Successfully.');
                }
            }
        }



        @unlink($fileName);
        $this->render('bulkupload', array(
            'model' => $model,
            'logfile' => $logfile
        ));
    }

    public function actionExport($id) {
        $store_front_model = new StoreFront();
        $baseproduct = $store_front_model->getMappedbaseproductbystorefront($id);
        $connection = Yii::app()->db;
        if (count($baseproduct) > 0) {
            $base_productids = implode(',', $baseproduct);
            $sqlchksubsid = "select base_product_id as Style_ID,style_no as Style_No ,title as Style_Name,title as Style_Name,season as Season,description as Description,color as Color ,color_name as Color_Name ,size as Size,tags as Tags,delevry_date as Delivery_Date , CASE gender   WHEN 1 THEN 'Men'  WHEN 2 THEN 'Women'  WHEN 3 THEN 'Unisex' ELSE 'Not Define' END as Gender,CASE status   WHEN 1 THEN 'Enable'  ELSE 'Disable'END as Status  from `base_product` where base_product_id in(" . $base_productids . ")";
            //$sqlchksubsid
            $command1 = $connection->createCommand($sqlchksubsid);
            $command1->execute();
            $assocDataArray = $command1->queryAll();
            $fileName = "Linesheet_" . $id . "Products" . ".csv";
            ob_clean();
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);
            if (isset($assocDataArray['0'])) {
                $fp = fopen('php://output', 'w');
                $columnstring = implode(',', array_keys($assocDataArray['0']));
                $updatecolumn = str_replace('_', ' ', $columnstring);

                $updatecolumn = explode(',', $updatecolumn);
                fputcsv($fp, $updatecolumn);
                foreach ($assocDataArray AS $values) {
                    fputcsv($fp, $values);
                }
                fclose($fp);
            }
            ob_flush();
        }
    }

    public function actionUpdateFileDownload() {
        $file_name = 'StoreFront_update.csv';
        $file_data = 'subscribed_product_id,store_front_id,is_deleted';
        $size_of_file = strlen($file_data);
        $this->renderPartial('fileDownload', array(
            'file_name' => $file_name,
            'file_data' => $file_data,
            'size_of_file' => $size_of_file
        ));
    }

    public function actionDelete($id, $store_id) {
//echo $store_id.$id;die;
        if (substr_count(Yii::app()->session['premission_info']['module_info']['linesheet'], 'D') > 0) {
            $obj = new StoreFront();
            $datat = $obj->deleteSTOREFRONT($id);
        } else {
            Yii::app()->user->setFlash('permission_error', 'You have no permission');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin', 'store_id' => $store_id));
    }

    protected function beforeAction($action) {

        $session = Yii::app()->session['user_id'];
        if ($session == '') {
            echo Yii::app()->controller->redirect("index.php?r=site/logout");
        }

        if (Yii::app()->session['premission_info']['menu_info']['linesheet_menu_info'] != "S") {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        return true;
    }

}
