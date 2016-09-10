<?php 

class SubscribedProductController extends Controller {
public function actionBulkUpload() {
        if (substr_count(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        set_time_limit(0);
        $logfile = '';
        $baseid = '';
        $model = new Bulk;
        $keycsv = 1;
        $csv_filename = '';
        $insert_base_csv_info = array();
        $insert_base_csv_info[$keycsv]['base_product_id'] = 'base_product_id';
        $insert_base_csv_info[$keycsv]['model_name'] = 'model_name';
        $insert_base_csv_info[$keycsv]['model_number'] = 'model_number';
        $keycsv++;

        if (isset($_POST['Bulk'])) {
            $model->action = $_POST['Bulk']['action'];
            $model->attributes = $_POST['Bulk'];
            if (!empty($_FILES['Bulk']['tmp_name']['csv_file'])) {
                $csv = CUploadedFile::getInstance($model, 'csv_file');
                if (!empty($csv)) {
                    if ($csv->size > 30 * 1024 * 1024) {
                        Yii::app()->user->setFlash('error', 'Cannot upload file greater than 30 MB.');
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
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                if ($ext != 'csv') {
                    Yii::app()->user->setFlash('error', 'Only .csv files allowed.');
                    $this->render('bulkupload', array('model' => $model));
                }
                $i = 0;
                $requiredFields = array('title', 'categoryId', 'Store Price', 'Store Offer Price','Pack Size');
                $defaultFields = array('title', 'categoryId', 'Pack Size', 'Pack Unit', 'store id', 'Store Price', 'Diameter', 'Grade', 'Store Offer Price', 'description', 'color', 'quantity');

                if ($model->action == 'update') {
                    $requiredFields = array('Base product id');
                    $defaultFields[] = 'Base product id';
                }
                if (($handle = fopen("$fileName", "r")) !== FALSE) {
                    $logDir = "log/";
                    $logfile = 'bulk_upload_log_' . Yii::app()->session['sessionId'] . '_' . time() . '.txt';
                    $handle1 = fopen($logDir . $logfile, "a");

                    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                        $fp = file($fileName);
//                  echo '<pre>';
//                print_r($fp);
//                print_r($_POST);die;
                        if (count($fp) == 1) {
                            Yii::app()->user->setFlash('error', 'Your CSV file is : ' . 'Blank');
                            break;
                        }
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
                                        $value = addslashes($value);
                                        $extraAttributes[$value] = $key;
                                    }
                                }
                            } else {

                                $row = array();

                                if (isset($cols['Base product id'])) {
                                    try {
                                        if (trim($data[$cols['Base product id']]) == null) {
                                            fwrite($handle1, "\nRow : " . $i . " Base product id is empty.");
                                            continue;
                                        }
                                        $model1 = $this->loadModel(trim($data[$cols['Base product id']]));
                                        // echo'<pre>';  print_r($model1);die;
                                    } catch (Exception $e) {
                                        fwrite($handle1, "\nRow : " . $i . " Base product {$data[$cols['Base product id']]} does not exist.");

                                        continue;
                                    }
                                } else {
                                    $model1 = new BaseProduct;
                                }

                                $model1->action = $model->action;
                                $store_id=1;
                                if ($store_id != 1) {
                                   Yii::app()->user->setFlash('error', 'Store ID does not match');
                                    break;
                                }
                           // echo '<pre>';
//                             print_r($cols);
                           // echo  $row['description'] = str_replace("’", "'", trim($data[$cols['description']]));die;
                              // print_r($cols);die;
                                if (isset($cols['Base product id']))
                                    $baseid = str_replace("’", "'", trim($data[$cols['Base product id']]));
                                if (isset($cols['title']))
                                    $row['title'] = str_replace("’", "'", trim($data[$cols['title']]));
                                if (isset($cols['Pack Size']))
                                    $row['pack_size'] = str_replace("’", "'", trim($data[$cols['Pack Size']]));
                                if (isset($cols['Pack Unit']))
                                    $row['pack_unit'] = str_replace("’", "'", trim($data[$cols['Pack Unit']]));
                                if (isset($cols['Diameter']))
                                    $row['diameter'] = str_replace("’", "'", trim($data[$cols['Diameter']]));
                                if (isset($cols['Grade']))
                                    $row['grade'] = str_replace("’", "'", trim($data[$cols['Grade']]));
                                if (isset($cols['description']))
                                    $row['description'] = str_replace("’", "'", trim($data[$cols['description']]));

                                if (isset($cols['color']))
                                    $row['color'] = trim($data[$cols['color']]);
                                /*if (isset($cols['quantity']))
                                    $row['quantity'] = trim($data[$cols['quantity']]);
                               if (isset($cols['store id']))
                                    $row['store_id'] = str_replace("’", "'", trim($data[$cols['store id']]));
                                if (isset($cols['status']))
                                    $row['status'] = 1;*/
                                 $row['store_id']=1;
                                $row['status']=1;
                                $row['quantity']=1;
                                if (isset($cols['Store Price']))
                                    $mrp = trim($data[$cols['Store Price']]);
                                if (isset($cols['Store Offer Price']))
                                    $wsp = trim($data[$cols['Store Offer Price']]);
                             //echo '<pre>';  print_r($cols);die;
                                $categories = explode(';', trim($data[$cols['categoryId']], ';'));
                                $cat_flag = 0;
                                foreach ($categories as $category) {

                                    if (!is_numeric($category)) {
                                        $cat_flag++;
                                    }
                                }
                                if ($cat_flag == 1) {
                                    Yii::app()->user->setFlash('error', 'Category Id is not valid : ' . implode(' , ', $categories));
                                    break;
                                }


                                $errorFlag = 0;
                                $model1->attributes = $row;

                                $error = array();
                                $action = $model->action == 'update' ? 'updated' : 'created';
                                $model_subscribe = new SubscribedProduct();
                                if ((is_numeric($wsp)) && is_numeric($data[$cols['Pack Size']]) && is_numeric($data[$cols['Diameter']]) && (is_numeric($mrp) && $mrp > $wsp)) {
                                    // echo $row['pack_unit'];die;
                                    $model_subscribe->store_offer_price = $wsp;
                                    $model_subscribe->diameter = $data[$cols['Diameter']];
                                    $model_subscribe->store_price = $mrp;
                                    $model_subscribe->quantity = 1;
                                    //$model1->Update_subscribed_product($model1->base_product_id, $model1->store_id, $model_subscribe->store_price, $model_subscribe->store_offer_price, $model_subscribe->grade, $model_subscribe->diameter, $model_subscribe->quantity);
                                    if (!$model1->save(true)) {

                                        foreach ($model1->getErrors() as $errors) {
                                            // echo "hello";die;
                                            $error[] = implode(' AND ', $errors);
                                        }
                                        fwrite($handle1, "\nRow : " . $i . " Product not $action. " . implode(' AND ', $error));
                                    } else {

                                        // print_r($cols]);die;
                                        //echo $data[$cols['Diameter']];die;
                                        if ($model1->action == 'create') { #................subscription...............#
                                             $model_subscribe = new SubscribedProduct();
                                            $model_subscribe->base_product_id = $model1->base_product_id;
                                            //$model1->Update_subscribed_product($model1->base_product_id, $model1->store_id, $mrp, $wsp, $data[$cols['Grade']], $data[$cols['Diameter']], $data[$cols['quantity']]);
                                            $model_subscribe->store_id = 1;
                                           $model_subscribe->quantity=1;
                                            if ($wsp != '') {
                                                $model_subscribe->store_offer_price = $wsp;
                                            } else {
                                                $model_subscribe->store_offer_price = 0;
                                            }
                                            if ($mrp != '') {
                                                $model_subscribe->store_price = $mrp;
                                            } else {
                                                //$model_subscribe->store_price = 0;
                                            }

                                            if ($data[$cols['Diameter']] != '') {
                                                $model_subscribe->diameter = $data[$cols['Diameter']];
                                            } else {
                                                $model_subscribe->diameter = 0;
                                            }
                                            if ($data[$cols['Grade']] != '') {
                                                $model_subscribe->grade = $data[$cols['Grade']];
                                            } else {
                                                $model_subscribe->grade = 0;
                                            }
                                           /* if ($data[$cols['quantity']] != '') {
                                                $model_subscribe->quantity = $data[$cols['quantity']];
                                            } else {
                                                $model_subscribe->quantity = 1;
                                            }*/

                                            //$model_subscribe->quantity = $data[$cols['quantity']];
                                            $model_subscribe->save();
                                            $model_subscribe->data_sub_csv($model1->base_product_id, $model1->store_id, $model_subscribe->store_price, $model_subscribe->store_offer_price, $model_subscribe->grade, $model_subscribe->diameter, $model_subscribe->quantity);
                                        }#...................end...................#
                                        if ($model1->action == 'update') {
                                            $model_subscribe = new SubscribedProduct();
                                            $model_subscribe->base_product_id = $model1->base_product_id;
                                            //$model1->Update_subscribed_product($model1->base_product_id, $model1->store_id, $mrp, $wsp, $data[$cols['Grade']], $data[$cols['Diameter']], $data[$cols['quantity']]);
                                            $model_subscribe->store_id = $model1->store_id;
                                            // $model_subscribe->store_price = $mrp;


                                          //  if ((is_numeric($wsp)) && is_numeric($data[$cols['Diameter']]) && (is_numeric($mrp))) {
                                                // echo "hello";die;
                                           echo'<pre>'; print_r($cols);die;
                                            if ((is_numeric($wsp)) && is_numeric($data[$cols['Pack Size']]) && is_numeric($data[$cols['Diameter']]) && (is_numeric($mrp) && $mrp > $wsp)) {
                                                $model_subscribe->store_offer_price = $wsp;
                                                $model_subscribe->diameter = $data[$cols['Diameter']];
                                                $model_subscribe->grade = $data[$cols['Grade']];
                                                $model_subscribe->store_price = $mrp;
                                                $model_subscribe->quantity = 1;
                                                $model1->Update_subscribed_product($model1->base_product_id, $model1->store_id, $model_subscribe->store_price, $model_subscribe->store_offer_price, $model_subscribe->grade, $model_subscribe->diameter, $model_subscribe->quantity);
                                            }
                                        }

                                        if (isset($row['media']) && !empty($row['media'])) {

                                            $images = $row['media'];
                                            $insertImages = array();
                                            if (isset($images) && $model1->base_product_id > 0) {
                                                if (!$model1->isNewRecord) {
                                                    $sql = "DELETE FROM media WHERE base_product_id = $model1->base_product_id";
                                                    $connection = Yii::app()->db;
                                                    $command = $connection->createCommand($sql);
                                                    $command->execute();
                                                }

                                                $images = explode(";", $images);
                                                $insertImages = $this->uploadImages($images, $i, $model1->base_product_id);
                                                if (!empty($insertImages['error'])) {
                                                    $model1->addError('csv_file', $insertImages['error']);
                                                }
                                            }
                                            /* save each uploaded media into database */
                                            if (!empty($insertImages['images'])) {
                                                $insertRows = array();
                                                foreach ($insertImages['images'] as $key => $value) {
                                                    $error = array();
                                                    $media_model = new Media;
                                                    if ($key !== 'error') {
                                                        $media_model->attributes = $value;
                                                        $media_model->save(true);
                                                    } else {
                                                        $error[] = $value;
                                                    }
                                                    foreach ($media_model->getErrors() as $errors) {
                                                        $error[] = implode(' AND ', $errors);
                                                    }
                                                    if (!empty($error)) {
                                                        $model1->addError('csv_file', implode(' AND ', $error));
                                                    }
                                                }
                                            }
                                        }
                                        fwrite($handle1, "\nRow : " . $i . " Product $model1->base_product_id $action. " . implode(' AND ', $error));
                                        //...............................................//
                                    }
                                } else {
                                    //$j=0
                                    foreach ($model1->getErrors() as $errors) {
                                        // echo "hello";die;
                                        $error[] = implode(' AND ', $errors);
                                    }
                                    // $J=1;
                                    fwrite($handle1, "\nRow : " . $i . " format not match id $model1->base_product_id . " . implode(' AND ', $error));
                                }

                                /* $error = array();
                                  foreach ($model1->getErrors() as $errors) {
                                  $error[] = implode(' AND ', $errors);
                                  } */

                                // fwrite($handle1, "\nRow : " . $i . " Product $model1->base_product_id $action. " . implode(' AND ', $error));

                                if ($model->action == 'create') {
                                    //.............................................//
                                    $insert_base_csv_info[$keycsv]['base_product_id'] = $model1->base_product_id;
                                    if (isset($row['model_name']))
                                        $insert_base_csv_info[$keycsv]['model_name'] = $row['model_name'];
                                    else
                                        $insert_base_csv_info[$keycsv]['model_name'] = '';
                                    if (isset($row['model_number']))
                                        $insert_base_csv_info[$keycsv]['model_number'] = $row['model_number'];
                                    else
                                        $insert_base_csv_info[$keycsv]['model_number'] = '';
                                    $keycsv++;

                                    //.................................................//

                                    $categories = '';
                                    //  is_numeric($data[$cols['categoryIds'])
                                    $categories = explode(';', trim($data[$cols['categoryId']], ';'));

                                    $category_obj = new Category();
                                    if (isset($categories) && !empty($categories)) {
                                        $connection = Yii::app()->db;
                                        $sql = "SELECT DISTINCT category_id
                                        FROM `category`
                                        WHERE category_id IN ( " . implode(',', $categories) . " )
                                        AND is_deleted = 0";
                                        $catinfo = '';
                                        $command = $connection->createCommand($sql);
                                        $catinfo = $command->queryAll();
                                        $catIds = array();
                                        if (isset($catinfo) && !empty($catinfo)) {
                                            foreach ($catinfo as $cat) {
                                                $catIds[] = $cat['category_id'];
                                            }

                                            $category_obj->insertCategoryMappings($model1->base_product_id, $catIds);
                                            $catDiff = array_diff($categories, $catIds);
                                            if (!empty($catDiff)) {

                                                Yii::app()->user->setFlash('error', 'Invalid Category ids :' . implode(' , ', $colDiff));

                                                break;
                                            }
                                        }
                                    }
                                }

                                if ($model->action == 'update') {
                                    if (isset($cols['categoryIds'])) {
                                        $categories = '';
                                        $categories = explode(';', trim($data[$cols['categoryIds']], ';'));
                                        if (isset($categories) && !empty($categories)) {
                                            $connection = Yii::app()->db;
                                            $sql = "SELECT DISTINCT category_id
                                        FROM `category`
                                        WHERE category_id IN ( " . implode(',', $categories) . " )
                                        AND is_deleted = 0";

                                            $catinfo = '';
                                            $command = $connection->createCommand($sql);
                                            $catinfo = $command->queryAll();
                                            $catIds = array();

                                            $category_obj = new Category();
                                            if (isset($catinfo) && !empty($catinfo)) {
                                                foreach ($catinfo as $cat) {
                                                    $catIds[] = $cat['category_id'];
                                                }

                                                $category_obj->insertCategoryMappings($baseid, $catIds);

                                                $catDiff = array_diff($categories, $catIds);
                                                if (!empty($catDiff)) {

                                                    Yii::app()->user->setFlash('error', 'Invalid Category ids :' . implode(' , ', $colDiff));

                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }
                              /*  if ($model->action == 'create' && !empty($baseid)) {
                                    //.......................solor backloag.................//
                                    $solrBackLog = new SolrBackLog();
                                    //$is_deleted =  ($model->status == 1) ? 0 : 1;
                                    $is_deleted = '0';
                                    $solrBackLog->insertByBaseProductId($baseid, $is_deleted);
                                    //.........................end.....................................//
                                }*/

                                if ($model->action == 'update' && !empty($baseid)) {
                                    //.......................solor backloag.................//
                                    $solrBackLog = new SolrBackLog();
                                    //$is_deleted =  ($model->status == 1) ? 0 : 1;
                                    $is_deleted = '0';
                                    $solrBackLog->insertByBaseProductId($baseid, $is_deleted);
                                    //.........................end.....................................//
                                }
                                Yii::app()->user->setFlash('success', 'Upload Successfully !.');
                            }
                        }
                    }
                }
            }

            if (isset($insert_base_csv_info) && !empty($insert_base_csv_info)) {
                $csv_filename = LOG_BASE_PDT_DIR . uniqid() . '.csv';
                $createFile = fopen($csv_filename, "a");

                foreach ($insert_base_csv_info as $row) {

                    fputcsv($createFile, $row);
                }
                fclose($createFile);
            }
        }


        // @unlink($fileName);
        $this->render('bulkupload', array(
            'model' => $model,
            'logfile' => $logfile,
            'csv_filename' => $csv_filename
        ));
    }
}
    ?>
