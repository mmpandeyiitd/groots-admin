<?php

class BaseProductController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $image;
    public $base_product_id;

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /* protected function beforeAction($action) {
      $session = Yii::app()->session['user_id'];
      if ($session == '') {
      echo Yii::app()->controller->redirect("index.php?r=site/logout");
      }

      if (Yii::app()->session['premission_info']['menu_info']['baseproduct_menu_info'] != "S") {
      Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
      Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
      }

      return true;
      } */

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'reportviewcontent', 'Ajax', 'report', 'view', 'Admin_1', 'Admin_2', 'addedstyle', 'load_first_1', 'export', 'media', 'MediaFileDownload', 'reportviewcontent', 'create', 'configurablegrid', 'createconfigurable', 'configurable_group'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'report', 'Ajax', 'update', 'Admin_1', 'Admin_2', 'addedstyle', 'subscribegrid', 'bulkupload', 'CreateFileDownload', 'UpdateFileDownload', 'export', 'media', 'MediaFileDownload', 'configurablegrid', 'createconfigurable'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'report', 'delete', 'CreateFileDownload', 'UpdateFileDownload', 'export', 'media', 'MediaFileDownload', 'create', 'configurablegrid', 'createconfigurable'),
                'users' => array('admin', '*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * generate report
     */
    public function actionreport() {
        $model = new BaseProduct();
        $this->render('reportview', array(
            'model' => $model,
        ));
    }

    /**
     * Displays a particular model.
     * generate report
     */
    public function actionreportviewcontent() {
        $model = new BaseProduct();
        $this->render('reportviewcontent', array(
            'model' => $model,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('example', array(
                //'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        if (substr_count(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        set_time_limit(0);
        $model = new BaseProduct;
        $mrp = '';
        $wsp = '';
        $diameter = '';
        $grade = '';
        $qunt = '';
        $a = '';
        $new_data = '';

        $images = array();
        $specific_keyfield = '';
        if (isset($_POST['BaseProduct'])) {

            $model->attributes = $_POST['BaseProduct'];
            $specific_key = array();
            $specific_value = array();
            $specific_key11 = array();
            if (isset($_POST['kye_field']) && isset($_POST['kye_value'])) {
                $kye_field = $_POST['kye_field'];
                $kye_value = $_POST['kye_value'];

                foreach ($kye_field as $key) {
                    if (!empty($key)) {
                        $specific_key[] = $key;
                    }
                }
                foreach ($kye_value as $kye_value1) {
                    if (!empty($kye_value1)) {
                        $specific_value[] = $kye_value1;
                    }
                }
                $specific_key11['specific_key'] = array_combine($specific_key, $specific_value);
                $specific_keyfield = json_encode($specific_key11);
                $model->specofic_keys = $specific_keyfield;
            }

            $issuperadmin = Yii::app()->session['is_super_admin'];
            if ($issuperadmin == 1) {
                $model->store_id = $_GET['store_id'];
            } else {
                $model->store_id = Yii::app()->session['brand_id'];
            }
            $model->modified_date = date("Y-m-d H:i:s");
            $images = CUploadedFile::getInstancesByName('images');
            //print_r($_POST);die;
            if (isset($_POST['color'])) {
                $model->color = $_POST['color'];
            }
            if (isset($_POST['MRP'])) {
                $mrp = $_POST['MRP'];
            }
            if (isset($_POST['WSP'])) {
                $wsp = $_POST['WSP'];
            }
            if (isset($_POST['a'])) {
                $a = $_POST['a'];
            }
            if (isset($_POST['new_data'])) {
                $new_data = $_POST['new_data'];
            }
            if (isset($_POST['qunt'])) {
                $qunt = $_POST['qunt'];
            }
            if (isset($_POST['status'])) {
                $model->status = $_POST['status'];
            } else {
                $model->status = 0;
            }


            if (isset($_POST['aiotree']['category_id'])) {

                if (!is_numeric($_POST['MRP'])) {
                    Yii::app()->user->setFlash('MRP', 'store price must be a number.');
                    $this->render('create', array(
                        'model' => $model,
                        'mrp' => $mrp,
                        'wsp' => $wsp,
                        'specific_keyfield' => $specific_keyfield,
                        'diameter' => $diameter,
                        'grade' => $grade,
                        'qunt' => $qunt,
                    ));
                    exit();
                }
                if (!is_numeric($_POST['WSP'])) {
                    Yii::app()->user->setFlash('WSP', 'WSP must be a number.');
                    $this->render('create', array(
                        'model' => $model,
                        'mrp' => $mrp,
                        'wsp' => $wsp,
                        'diameter' => $diameter,
                        'grade' => $grade,
                        'qunt' => $qunt,
                        'specific_keyfield' => $specific_keyfield,
                    ));
                    exit();
                }
                if (isset($mrp) && isset($wsp) && $mrp < $wsp) {
                    Yii::app()->user->setFlash('WSP', 'store price must be Greater than or equal to store offer price.');
                    $this->render('create', array(
                        'model' => $model,
                        'mrp' => $mrp,
                        'wsp' => $wsp,
                        'diameter' => $diameter,
                        'grade' => $grade,
                        'qunt' => $qunt,
                        'specific_keyfield' => $specific_keyfield,
                    ));
                    exit();
                }


//                if ((empty($model->size_brand) && !empty($model->size) || (!empty($model->size_brand) && empty($model->size)))) {
//                    Yii::app()->user->setFlash('WSP', 'Size and Size Brand both fill');
//                    $this->render('create', array(
//                        'model' => $model,
//                        'mrp' => $mrp,
//                        'wsp' => $wsp,
//                        'specific_keyfield' => $specific_keyfield,
//                    ));
//                    exit();
//                }
                /* if ((empty($model->color_index) && !empty($model->color) || (!empty($model->color_index) && empty($model->color)))) {
                  Yii::app()->user->setFlash('WSP', 'Color and Color Index both fill');
                  $this->render('create', array(
                  'model' => $model,
                  'mrp' => $mrp,
                  'wsp' => $wsp,
                  'specific_keyfield' => $specific_keyfield,
                  'diameter' => $diameter,
                  ));
                  exit();
                  } */

//echo '<pre>';print_r(model);die;
                if ($model->save()) {
//               echo'<pre>';
//               
//               echo $_POST['MRP'];die;
//                 print_r($_POST);die;
                    //  echo $diameter;die;
                    #................subscription...............#

                    $model_subscribe = new SubscribedProduct();
                    $model_subscribe->base_product_id = $model->base_product_id;
                    $model_subscribe->store_id = $model->store_id;
                    $model_subscribe->store_price = $_POST['MRP'];
                    $model_subscribe->diameter = $new_data;
                    $model_subscribe->grade = $a;
                    $model_subscribe->quantity = $qunt;
                    $model_subscribe->store_offer_price = $_POST['WSP'];
                    $model_subscribe->data_sub($model->base_product_id, $model->store_id, $_POST['MRP'], $new_data, $a, $qunt, $_POST['WSP']);
//                   if($model_subscribe->save())
//                   {
//                       echo "hello";die;
//                   }else
//                   {
//                       echo "hello111";die;
//                   }
                    #...................end...................#
                    $cat_object = new Category();
                    $base_product_id = $model->base_product_id;
                    foreach ($_POST['aiotree']['category_id'] as $key => $value) {
                        $val = explode("-", $value);
                        $cat_object->createBaseproductMappings($base_product_id, $val[3]);
                    }
                    if (isset($images) && count($images) > 0) {
                        foreach ($images as $image => $pic) {
                            $flag_set_default = 0;
                            $pic->saveAs(UPLOAD_MEDIA_PATH . $pic->name);
                            $base_img_name = uniqid();
                            $file1 = $base_img_name;

                            $baseDir = MAIN_BASE_MEDAI_DIRPATH;
                            if ($file1[0]) {
                                $baseDir .= $file1[0] . '/';
                            }

                            if ($file1[1]) {
                                $baseDir .= $file1[1] . '/';
                            } else {
                                $baseDir .= '_/';
                            }
                            $media_url_dir = $baseDir;
                            $content_medai_img = @file_get_contents('images/' . $pic->name);
                            $media_main = $media_url_dir . $base_img_name . '.jpg'; //name
                            @mkdir($media_url_dir, 0777, true);
                            // $success = file_put_contents($media_main, $content_medai_img);
                            $width = BASEPRODUCT_BIGIMAGE_WIDTH;
                            $height = BASEPRODUCT_BIGIMAGE_HEIGHT;
                            $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_main);


                            $baseDir = UPLOAD_MEDIA_ORIGINAL_PATH;
                            if ($file1[0]) {
                                $baseDir .= $file1[0] . '/';
                            }

                            if ($file1[1]) {
                                $baseDir .= $file1[1] . '/';
                            } else {
                                $baseDir .= '_/';
                            }
                            $media_url_dir = $baseDir;
                            $content_medai_img = @file_get_contents('images/' . $pic->name);
                            $media_original = $media_url_dir . $base_img_name . '.jpg'; //name
                            @mkdir($media_url_dir, 0777, true);
                            $success = file_put_contents($media_original, $content_medai_img);

                            $baseThumbPath = THUMB_BASE_MEDIA_DIRPATH;
                            @mkdir($baseThumbPath, 0777, true);


                            $baseDir = $baseThumbPath;
                            if ($file1[0]) {
                                $baseDir .= $file1[0] . '/';
                            }

                            if ($file1[1]) {
                                $baseDir .= $file1[1] . '/';
                            } else {
                                $baseDir .= '_/';
                            }
                            $thumb_url_dir = $baseDir;
                            $media_thumb_url = $thumb_url_dir . $base_img_name . '.jpg';
                            $midia_type = 'image';
                            $base_product_id = $model->base_product_id;

                            if ($flag_set_default == 0) {
                                $is_default = 1;
                            } else {
                                $is_default = 0;
                            }
                            $model->insertMedia($media_main, $media_thumb_url, $base_product_id, $midia_type, $is_default);
                            @mkdir($thumb_url_dir, 0777, true);
                            $width = BASEPRODUCT_THUMBIMAGE_WIDTH;
                            $height = BASEPRODUCT_THUMBIMAGE_HEIGHT;
                            $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_thumb_url);
                            $flag_set_default++;
                        }
                    }
                    @unlink(UPLOAD_MEDIA_PATH . $pic->name);

                    Yii::app()->user->setFlash('success', 'Product created Sucessfully');
                    // $this->redirect(array('update', 'id' => $model->base_product_id, "store_id" => $_GET['store_id']));
                }
            } else {
                Yii::app()->user->setFlash('error', 'Product not save,Please select at least one category');
            }
        }
        $this->render('create', array(
            'model' => $model,
            'mrp' => $mrp,
            'wsp' => $wsp,
            'diameter' => $diameter,
            'grade' => $grade,
            'qunt' => $qunt,
            'specific_keyfield' => $specific_keyfield,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //   echo Yii::app()->session['premission_info']['module_info']['baseproduct'];die;
        if (substr_count(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        set_time_limit(0);
        $getrecord = new ProductCategoryMapping();
        $record = $getrecord->getRecordById($id);
        $imageinfo = $getrecord->getImageById($id);
        // $model_subscribe = new SubscribedProduct();
        //echo '<pre>';
        //  print_r($model_subscribe['diameter']);
//die;
        $mrp = '';
        $wsp = '';
        $specific_keyfield = '';
        $model_subscribe = new SubscribedProduct();
        $a = $model_subscribe->getdatarecords($id);
        $new_data = $model_subscribe->getdatarecords_new($id);
        $qunt = $model_subscribe->getdatarecords_new1($id);
        // echo $id;die;
        $model = $this->loadModel($id);
        // echo $_POST['BaseProduct'];die;
        if (isset($_POST['BaseProduct'])) {
            // echo "hello";die;
            $model->attributes = $_POST['BaseProduct'];

            $specific_key = array();
            $specific_value = array();
            $specific_key11 = array();
            if (isset($_POST['kye_field']) && isset($_POST['kye_value'])) {
                $kye_field = $_POST['kye_field'];
                $kye_value = $_POST['kye_value'];
                foreach ($kye_field as $key) {
                    if (!empty($key)) {
                        $specific_key[] = $key;
                    }
                }
                foreach ($kye_value as $kye_value1) {
                    if (!empty($kye_value1)) {
                        $specific_value[] = $kye_value1;
                    }
                }
                $specific_key11['specific_key'] = array_combine($specific_key, $specific_value);
                $specific_keyfield = json_encode($specific_key11);
                $model->specofic_keys = $specific_keyfield;
            }
            //echo "hello";die;

            $images = CUploadedFile::getInstancesByName('images');
            $model->modified_date = date("Y-m-d H:i:s");
            $issuperadmin = Yii::app()->session['is_super_admin'];
            if ($issuperadmin == 1) {
                $model->store_id = $_GET['store_id'];
            } else {
                $model->store_id = Yii::app()->session['brand_id'];
            }

            if (isset($_POST['media_remove'])) {
                foreach ($_POST['media_remove'] as $keyrm => $valuerm) {
                    $mediaremove = Media::model()->deleteMediaByMediaId($valuerm);
                }
            }
            $media_object = new Media();
            if (isset($_POST['media_is_default'])) {
                $media_object->updateDefaultMediaByBaseProductId($_POST['media_is_default'], $id);
            }

            $baseProductId = $model->base_product_id;
            $category_obj = new Category();
            if (isset($_POST['aiotree']['category_id'])) {
                foreach ($_POST['aiotree']['category_id'] as $key => $value) {
                    $val = explode("-", $value);
                    //   $sql = "INSERT INTO product_category_mapping(base_product_id, category_id) VALUES('$id', '$val[3]')";
                    $category_obj->createBaseproductMappings($baseProductId, $val[3]);
                }
            }
            //echo '<pre>'; print_r($_POST);die;
            if (isset($_POST['color'])) {
                $model->color = $_POST['color'];
            }
            if (isset($_POST['status'])) {
                $model->status = $_POST['status'];
            } else {
                $model->status = 0;
            }

            if (isset($_POST['gender'])) {
                $model->gender = $_POST['gender'];
            }

            if (isset($_POST['MRP'])) {
                $mrp = $_POST['MRP'];
            }
            if (isset($_POST['WSP'])) {
                $wsp = $_POST['WSP'];
            }

            if (isset($mrp) && isset($wsp) && $mrp < $wsp) {
                Yii::app()->user->setFlash('WSP', 'MRP must be Greater than or equal to WSP.');
                $this->render('create', array(
                    'model' => $model,
                    'mrp' => $mrp,
                    'wsp' => $wsp,
                    'specific_keyfield' => $specific_keyfield,
                ));
                exit();
            }

//            if ((empty($model->size_brand) && !empty($model->size) || (!empty($model->size_brand) && empty($model->size)))) {
//                Yii::app()->user->setFlash('WSP', 'Size and Size Brand both fill');
//                $this->render('create', array(
//                    'model' => $model,
//                    'mrp' => $mrp,
//                    'wsp' => $wsp,
//                    'specific_keyfield' => $specific_keyfield,
//                ));
//                exit();
//            }
            /* if ((empty($model->color_index) && !empty($model->color) || (!empty($model->color_index) && empty($model->color)))) {
              Yii::app()->user->setFlash('WSP', 'Color and Color Index both fill');
              $this->render('create', array(
              'model' => $model,
              'mrp' => $mrp,
              'wsp' => $wsp,
              //'diameter' => $diameter,
              //'grade' => $grade,
              'specific_keyfield' => $specific_keyfield,
              ));
              exit();
              } */
            $model->size_chart = CUploadedFile::getInstance($model, 'size_chart');
            if ($model->save()) {
                #................subscription...............#
                $model_subscribe = new SubscribedProduct();
                $a = $model_subscribe->getdatarecords($id);

                $base_product_id = $model->base_product_id;
                $store_id = $model->store_id;
                //$mrp = $_POST['MRP'];
                //$wsp = $_POST['WSP'];
                /* if($_POST['a']==''){
                  $grade = $_POST['a'];
                  }
                  else
                  {
                  $grade=$a['0']['grade'];

                  }
                  if($_POST['new_data']==''){

                  $diameter= $_POST['new'];
                  }
                  else
                  {
                  $diameter=$diameter['0']['diameter'];

                  } */
               // echo '<pre>';
             //   print_r($_POST);die;
                if ($a == Array()) {
                    $grade = $_POST['a'];
                } else {
                    // $grade = $_POST['a'];
                    $grade = $a['0']['grade'];
                }
                if ($new_data == Array()) {
                    $diameter = $_POST['new_data'];
                } else {
                    //echo '<pre>';  print_r($_POST);die;
                    //echo $new_data['0']['new_data'];die;
                    // $diameter = $_POST['new_data'];
                    $diameter = $new_data['0']['diameter'];
                }
                if ($_POST['qunt'] == '' ) {
                     $quantity = $qunt['0']['quantity'];
                    //  $quantity=
                } else {
                   
                   $quantity = $_POST['qunt'];
                    // $quantity=$qunt['0']['quantity'];
                }

                $model_subscribe->update_mrp_wsp($mrp, $wsp, $diameter, $grade, $store_id, $base_product_id, $quantity);
                #...................end...................#


                if (isset($images) && count($images) > 0) {
                    foreach ($images as $image => $pic) {
                        $flag_set_default = 0;
                        $pic->saveAs(UPLOAD_MEDIA_PATH . $pic->name);
                        $base_img_name = uniqid();
                        //$path  = pathinfo($media);
                        $file1 = $base_img_name;
                        $baseDir = MAIN_BASE_MEDAI_DIRPATH;
                        if ($file1[0]) {
                            $baseDir .= $file1[0] . '/';
                        }

                        if ($file1[1]) {
                            $baseDir .= $file1[1] . '/';
                        } else {
                            $baseDir .= '_/';
                        }
                        $media_url_dir = $baseDir;
                        $content_medai_img = @file_get_contents(UPLOAD_MEDIA_PATH . $pic->name);
                        $media_main = $media_url_dir . $base_img_name . '.jpg'; //name
                        @mkdir($media_url_dir, 0777, true);
//                        $success = file_put_contents($media_main, $content_medai_img);
                        $width = BASEPRODUCT_BIGIMAGE_WIDTH;
                        $height = BASEPRODUCT_BIGIMAGE_HEIGHT;
                        $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_main);


                        $baseDir = UPLOAD_MEDIA_ORIGINAL_PATH;
                        if ($file1[0]) {
                            $baseDir .= $file1[0] . '/';
                        }

                        if ($file1[1]) {
                            $baseDir .= $file1[1] . '/';
                        } else {
                            $baseDir .= '_/';
                        }
                        $media_url_dir = $baseDir;
                        $content_medai_img = @file_get_contents(UPLOAD_MEDIA_PATH . $pic->name);
                        $media_original = $media_url_dir . $base_img_name . '.jpg'; //name
                        @mkdir($media_url_dir, 0777, true);
                        $success = file_put_contents($media_original, $content_medai_img);

                        $baseThumbPath = THUMB_BASE_MEDIA_DIRPATH;
                        @mkdir($baseThumbPath, 0777, true);

                        $baseDir = $baseThumbPath;
                        if ($file1[0]) {
                            $baseDir .= $file1[0] . '/';
                        }

                        if ($file1[1]) {
                            $baseDir .= $file1[1] . '/';
                        } else {
                            $baseDir .= '_/';
                        }
                        $thumb_url_dir = $baseDir;
                        $media_thumb_url = $thumb_url_dir . $base_img_name . '.jpg';
                        $midia_type = 'image';
                        $is_default = 0;
                        $model->insertMedia($media_main, $media_thumb_url, $base_product_id, $midia_type, $is_default);
                        @mkdir($thumb_url_dir, 0777, true);
                        $width = BASEPRODUCT_THUMBIMAGE_WIDTH;
                        $height = BASEPRODUCT_THUMBIMAGE_HEIGHT;
                        $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_thumb_url);
                        @unlink(UPLOAD_MEDIA_PATH . $pic->name);
                        $flag_set_default++;
                    }
                }
                //.......................solor backloag.................//
                $solrBackLog = new SolrBackLog();
                //$is_deleted =  ($model->status == 1) ? 0 : 1;
                $is_deleted = '0';
                $solrBackLog->insertByBaseProductId($model->base_product_id, $is_deleted);
                //.........................end.....................................//

                if (isset($model->size_chart)) {

                    $model->size_chart->saveAs(UPLOAD_SIZE_CHART_PATH . $model->size_chart);

                    $base_img_name = uniqid();
                    //$path  = pathinfo($media);
                    $file1 = $base_img_name;
                    $baseDir = UPLOAD_SIZE_CHART_PATH;
                    if ($file1[0]) {
                        $baseDir .= $file1[0] . '/';
                    }

                    if ($file1[1]) {
                        $baseDir .= $file1[1] . '/';
                    } else {
                        $baseDir .= '_/';
                    }
                    $media_url_dir = $baseDir;
                    $content_medai_img = @file_get_contents(UPLOAD_SIZE_CHART_PATH . $model->size_chart);
                    $media_main = $media_url_dir . $base_img_name . '.jpg'; //name
                    @mkdir($media_url_dir, 0777, true);
                    $success = file_put_contents($media_main, $content_medai_img);

                    $baseThumbPath = UPLOAD_SIZE_CHART_PATH;
                    @mkdir($baseThumbPath, 0777, true);

                    $baseDir = $baseThumbPath;
                    if ($file1[0]) {
                        $baseDir .= $file1[0] . '/';
                    }

                    if ($file1[1]) {
                        $baseDir .= $file1[1] . '/';
                    } else {
                        $baseDir .= '_/';
                    }

                    $thumb_url_dir = $baseDir;
                    $media_thumb_url = $thumb_url_dir . $base_img_name . '.jpg';
                    $image = $base_img_name . '.jpg';
                    $base_product_id = $model->base_product_id;
                    $model->Update_sizechart($base_product_id, $image, $media_thumb_url);
                    @mkdir($thumb_url_dir, 0777, true);
                    $width = SIZECHART_THUMBIMAGE_WIDTH;
                    $height = SIZECHART_THUMBIMAGE_HEIGHT;
                    $image = $this->createImage(UPLOAD_SIZE_CHART_PATH . $model->size_chart, $width, $height, $media_thumb_url);
                    @unlink(UPLOAD_SIZE_CHART_PATH . $model->size_chart);
                }


                Yii::app()->user->setFlash('success', 'Style updated successfully');
                $this->redirect(array('update', 'id' => $model->base_product_id, "store_id" => $_GET['store_id']));
            }
        }
//        else{echo "bye";die;}
        if ($a == Array() && $new_data != Array() && $qunt != Array()) {
            $this->render('update', array(
                'a' => '',
                'new_data' => $new_data['0']['diameter'],
                'qunt' => $qunt['0']['quantity'],
                'model' => $model,
                'record' => $record,
                'imageinfo' => $imageinfo,
                'mrp' => $mrp,
                'wsp' => $wsp,
                'specific_keyfield' => $specific_keyfield,
            ));
        } else if ($new_data == Array() && $a != Array() && $qunt != Array()) {
            $this->render('update', array(
                'a' => $a['0']['grade'],
                'new_data' => '',
                'qunt' => $qunt['0']['quantity'],
                'model' => $model,
                'record' => $record,
                'imageinfo' => $imageinfo,
                'mrp' => $mrp,
                'wsp' => $wsp,
                'specific_keyfield' => $specific_keyfield,
            ));
        } else if ($qunt == Array() && $new_data != Array() && $a != Array()) {
            $this->render('update', array(
                'a' => $a['0']['grade'],
                'new_data' => $new_data['0']['diameter'],
                'qunt' => '',
                'model' => $model,
                'record' => $record,
                'imageinfo' => $imageinfo,
                'mrp' => $mrp,
                'wsp' => $wsp,
                'specific_keyfield' => $specific_keyfield,
            ));
        } else if ($qunt != Array() && $new_data != Array() && $a != Array()) {
            $this->render('update', array(
                'a' => $a['0']['grade'],
                'new_data' => $new_data['0']['diameter'],
                'qunt' => $qunt['0']['quantity'],
                'model' => $model,
                'record' => $record,
                'imageinfo' => $imageinfo,
                'mrp' => $mrp,
                'wsp' => $wsp,
                'specific_keyfield' => $specific_keyfield,
            ));
        } else {
            $this->render('update', array(
                'a' => '',
                'new_data' => '',
                'qunt' => '',
                'model' => $model,
                'record' => $record,
                'imageinfo' => $imageinfo,
                'mrp' => $mrp,
                'wsp' => $wsp,
                'specific_keyfield' => $specific_keyfield,
            ));
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
        $dataProvider = new CActiveDataProvider('BaseProduct');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

//public function actionIndex()
//{
//$criteria = new CDbCriteria();
//
//if(isset($_GET['q']))
//{
//$q = $_GET['q'];
//$criteria->compare('title', $q, true, 'OR');
////$criteria->compare('attribute2', $q, true, 'OR');
//}
//
//$dataProvider=new CActiveDataProvider('BaseProduct',array('criteria'=>$criteria));
//
//$this->render('index',array(
//'dataProvider'=>$dataProvider,
//));
//}

    /**
     * Manages all models.
     */
    public function actionAdmin() {
//        echo '<pre>';
//        print_r($_SESSION);die;

        if (substr_count(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'R') == 0) {
            // echo "hello";die;

            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        $model = new BaseProduct();
        $model_grid = new ProductGridview('search');
        $model_grid->unsetAttributes();  // clear any default values

        /*  if (isset($_GET['ProductGridview']))
          $model_grid->attributes = $_GET['ProductGridview'];
         */

        if (isset($_POST['pdfbutton'])) {


            if (isset($_POST['selectedIds'])) {
                $no_of_selectedIds = count($_POST['selectedIds']);
                if ($no_of_selectedIds > 0) {
                    $base_product_ids = implode(',', $_POST['selectedIds']);
                    // $response = $model->getStyleReport($base_product_ids);
                    $this->render('admin', array(
                        'model_grid' => $model_grid,
                        '$base_product_ids' => $base_product_ids,
                    ));
                    $this->redirect(array('reportview', 'base_product_ids' => $base_product_ids,));
                    exit();
                }
            } else {

                Yii::app()->user->setFlash('premission_info', 'Please select at least one Product.');
            }
        }


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
                Yii::app()->user->setFlash('premission_info', 'Please select at least one Product.');
            }
        }


        $this->render('admin', array(
            'model_grid' => $model_grid,
                // 'model'=>$model,
                 //'search' => $search,
        ));
    }

    public function actionload_first_1() {
        $criteria = new CDbCriteria;
        $base_object = new BaseProduct();
        $total = $base_object->count();

        $pages = new CPagination($total);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);

        $posts = $base_object->findAll($criteria);

        $this->render('load_first_1', array(
            'model' => $posts,
            'pages' => $pages,
        ));
    }

    public function actionAdmin_1() {
        $base_object = new BaseProduct();
        $criteria = new CDbCriteria;
        $total = $base_object->count();

        $pages = new CPagination($total);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);

        $posts = $base_object->findAll($criteria);

        $this->render('admin_1', array(
            'model' => $posts,
            'pages' => $pages,
        ));
    }

    public function actionAdmin_2() {
        $base_object = new BaseProduct();
        $criteria = new CDbCriteria;
        $total = $base_object->count();

        $pages = new CPagination($total);
        $pages->pageSize = 20;
        $pages->applyLimit($criteria);

        $posts = $base_object->findAll($criteria);

        $this->render('admin_2', array(
            'posts' => $posts,
            'pages' => $pages,
        ));
    }

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

                // print_r($model);die;
//description,color,size,,status,categoryIds,MRP,WSP,image
                $requiredFields = array('title', 'categoryIds', 'store id', 'Store Price', 'Store Offer Price');
                $defaultFields = array('title', 'categoryIds', 'Pack Size', 'Pack Unit', 'store id', 'Store Price', 'Diameter', 'Grade', 'Store Offer Price', 'description', 'color', 'quantity');

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
                                if (trim($data[$cols['store id']]) != 1) {
                                    Yii::app()->user->setFlash('error', 'Store ID does not match');
                                    break;
                                }
//                             echo '<pre>';
//                             print_r($cols);
//                               print_r($data);die;
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
                                if (isset($cols['quantity']))
                                    $row['quantity'] = trim($data[$cols['quantity']]);
                                if (isset($cols['store id']))
                                    $row['store_id'] = str_replace("’", "'", trim($data[$cols['store id']]));
                                if (isset($cols['status']))
                                    $row['status'] = 1;


                                if (isset($cols['Store Price']))
                                    $mrp = trim($data[$cols['Store Price']]);
                                if (isset($cols['Store Offer Price']))
                                    $wsp = trim($data[$cols['Store Offer Price']]);
                                $categories = explode(';', trim($data[$cols['categoryIds']], ';'));
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

                                if (!$model1->save(true)) {

                                    foreach ($model1->getErrors() as $errors) {
                                       // echo "hello";die;
                                        $error[] = implode(' AND ', $errors);
                                    }
                                    fwrite($handle1, "\nRow : " . $i . " Product not $action. " . implode(' AND ', $error));
                                } else {

                                    // print_r($cols]);die;
                                    //echo $model1->action;die;
                                   if($model1->action=='create')
                                   { #................subscription...............#
                                    $model_subscribe = new SubscribedProduct();
                                    $model_subscribe->base_product_id = $model1->base_product_id;
                                    //$model1->Update_subscribed_product($model1->base_product_id, $model1->store_id, $mrp, $wsp, $data[$cols['Grade']], $data[$cols['Diameter']], $data[$cols['quantity']]);
                                    $model_subscribe->store_id = $model1->store_id;
                                    $model_subscribe->store_price = $mrp;
                                    $model_subscribe->diameter = $data[$cols['Diameter']];
                                    $model_subscribe->grade = $data[$cols['Grade']];
                                    $model_subscribe->store_offer_price = $wsp;
                                    $model_subscribe->quantity = $data[$cols['quantity']];
                                    $model_subscribe->save();
                                    $model_subscribe->data_sub_csv($model1->base_product_id, $model1->store_id, $mrp, $wsp, $data[$cols['Grade']], $data[$cols['Diameter']], $data[$cols['quantity']]);
                                   }#...................end...................#
                                   if($model1->action=='update')
                                   {
                                       $model1->Update_subscribed_product($model1->base_product_id, $model1->store_id, $mrp, $wsp, $data[$cols['Grade']], $data[$cols['Diameter']], $data[$cols['quantity']]);
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
                                    //...............................................//
                                }

                                $error = array();
                                foreach ($model1->getErrors() as $errors) {
                                    $error[] = implode(' AND ', $errors);
                                }

                                fwrite($handle1, "\nRow : " . $i . " Product $model1->base_product_id $action. " . implode(' AND ', $error));

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
                                    $categories = explode(';', trim($data[$cols['categoryIds']], ';'));

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

    public function actionMedia() {

        if (substr_count(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        $oldfilename = '';
        if (isset($_FILES["media_zip_file"]["name"])) {
            if ($_FILES["media_zip_file"]["size"] > 30 * 1024 * 1024) {
                throw new Exception('Cannot upload file greater than 30 MB');
            }
            $oldfilename = $_FILES["media_zip_file"]["name"];
            $filename = $_FILES["media_zip_file"]["name"];
            //die;
            $filenameArr = explode('.', $filename);
            $filename = $filenameArr[0] . '-' . Yii::app()->session['sessionId'] . '-' . time() . '.' . end($filenameArr);

            $source = $_FILES["media_zip_file"]["tmp_name"];
            $type = $_FILES["media_zip_file"]["type"];

            $target_path = 'zips/' . $filename;  // change this to the correct site path

            if (move_uploaded_file($source, $target_path)) {

                $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
                $okay = false;

                $file_info = new finfo(FILEINFO_MIME);  // object oriented approach!
                $file_mime_type = $file_info->buffer(@file_get_contents($target_path));  // e.g. gives "image/jpeg"

                foreach ($accepted_types as $mime_type) {
                    if (strpos($file_mime_type, $mime_type) !== FALSE) {
                        $okay = true;
                        break;
                    }
                }

                $name = explode(".", $filename);
                $continue = strtolower($name[1]) == 'zip' ? true : false;
                if (!$okay OR ! $continue) {
                    Yii::app()->user->setFlash('error', 'The file you are trying to upload not a .zip file. Please try again.');
                    $this->render('media');
                }

                $zip = new ZipArchive();
                $x = $zip->open($target_path);
                if ($x === true) {
                    $zip->extractTo('images/'); // change this to the correct site path
                    $zip->close();
                    @system('chmod -R 0777 ' . 'images/');


                    #  ******
                    $files = glob("images/zips/*.*");
                    foreach ($files as $file) {
                        $file_to_go = rename($file, str_replace('zips/', '', $file));
                        echo $file_mak = str_replace('zips/', '', $file);
                        // die;
                    }
                    #**********


                    $response['status'] = 'success';
                    $response['message'] = "Your $oldfilename file was uploaded and unpacked.";
                    @unlink($target_path);
                    Yii::app()->user->setFlash('success', "Your " . $oldfilename . " file was uploaded and unpacked.");
                    $this->render('media');
                    die;
                } else {
                    Yii::app()->user->setFlash('error', 'Unable to read zip file. Please check file type & try again.');
                    $this->render('media');
                    die;
                }
            } else {


                Yii::app()->user->setFlash('error', 'There was a problem with the upload. Please try again.');
                $this->render('media');
            }
        }




        // @unlink($fileName);
        $this->render('media');
    }

    public function actionSubscribegrid($store_id) {

        $id = $store_id;
        $model = new BaseProduct('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BaseProduct']))
            $model->attributes = $_GET['BaseProduct'];

        $this->render('subscribegrid', array(
            'model' => $model,
            'store_id' => $id,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return BaseProduct the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $condition = null) {
        $model = BaseProduct::model()->findByPk($id, $condition);
        //print_r($model1);die;
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param BaseProduct $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'base-product-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public static function createImage($url, $width = 150, $height = 150, $savePath) {
        // The file
        if (file_exists($url)) {
            $filename = $url;
            $pathInfo = pathinfo($filename);
            $size = getimagesize($filename);
            list($width_orig, $height_orig) = getimagesize($filename);

            // Get new dimensions

            $ratio_orig = $width_orig / $height_orig;

            if ($width / $height > $ratio_orig) {
                $width = $height * $ratio_orig;
            } else {
                $height = $width / $ratio_orig;
            }
            // Resample
            $image_p = imagecreatetruecolor($width, $height);

            if ($size['mime'] == "image/jpeg")
                $image = imagecreatefromjpeg($filename);
            elseif ($size['mime'] == "image/png")
                $image = imagecreatefrompng($filename);
            elseif ($size['mime'] == "image/gif")
                $image = imagecreatefromgif($filename);
            else
                $image = imagecreatefromjpeg($filename);

            /* handle transparency for gif and png images */
            if ($size['mime'] == "image/png") {
                imagesavealpha($image_p, true);
                $color = imagecolorallocatealpha($image_p, 0, 0, 0, 127);
                imagefill($image_p, 0, 0, $color);
            }

            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

            if ($size['mime'] == "image/jpeg")
                imagejpeg($image_p, $savePath, 100);
            elseif ($size['mime'] == "image/png")
                imagepng($image_p, $savePath, 9);
            elseif ($size['mime'] == "image/gif")
                imagegif($image_p, $savePath);
            else
                imagejpeg($image_p, $savePath, 100);

            // Free up memory
            imagedestroy($image_p);
        }

        return true;
    }

    public function actionCreateFileDownload() {
        $file_name = 'Bulk_Upload_product_create.csv';
        $file_data = 'title,description,categoryIds,store id,color,Grade,Diameter,Pack Size,Pack Unit,Store Price,Store Offer Price,quantity,Status';
        $size_of_file = strlen($file_data);
        $this->renderPartial('fileDownload', array(
            'file_name' => $file_name,
            'file_data' => $file_data,
            'size_of_file' => $size_of_file
        ));
    }

    public function actionUpdateFileDownload() {
        $file_name = 'Bulk_Upload_product_Update.csv';
        $file_data = 'Base product id,title,description,categoryIds,store id,color,Grade,Diameter,Pack Size,Pack Unit,Store Price,Store Offer Price,quantity,Status';
        $size_of_file = strlen($file_data);
        $this->renderPartial('fileDownload', array(
            'file_name' => $file_name,
            'file_data' => $file_data,
            'size_of_file' => $size_of_file
        ));
    }

    public function actionExport($id) {
        $connection = Yii::app()->db;
        $sqlchksubsid = "SELECT sp.`subscribed_product_id`,sp.`base_product_id`,sp.`store_id`,s.store_name,bs.title,bs.color,sp.`store_price`,sp.`store_offer_price`,sp.`weight`,sp.`length`,sp.`width`,sp.`height`,sp.`status`,sp.sku,sp.`quantity`,sp.`is_cod`,sp.`created_date`,sp.`modified_date` FROM `subscribed_product` sp join store as s on s.store_id=sp.`store_id` join base_product as bs on bs.`base_product_id`=sp.`base_product_id` WHERE sp.`base_product_id`=" . $id . " group by sp.`base_product_id`";
        $command1 = $connection->createCommand($sqlchksubsid);
        $command1->execute();
        $assocDataArray = $command1->queryAll();
        $fileName = "Base_product_id_" . $id . ".csv";
        ob_clean();
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);
        if (isset($assocDataArray['0'])) {
            $fp = fopen('php://output', 'w');
            fputcsv($fp, array_keys($assocDataArray['0']));
            foreach ($assocDataArray AS $values) {
                fputcsv($fp, $values);
            }
            fclose($fp);
        }
        ob_flush();
    }

    public function uploadImages($images, $i, $id) {

        set_time_limit(0);
        $insertImages = $error = array();
        $width = BASEPRODUCT_BIGIMAGE_WIDTH;
        $height = BASEPRODUCT_BIGIMAGE_HEIGHT;
        foreach ($images as $key => $image) {
            if (!empty($image)) {
                $base_img_name = uniqid();

                $file1 = $base_img_name;
                $baseDir = MAIN_BASE_MEDAI_DIRPATH;
                if ($file1[0]) {
                    $baseDir .= $file1[0] . '/';
                }

                if ($file1[1]) {
                    $baseDir .= $file1[1] . '/';
                } else {
                    $baseDir .= '_/';
                }
                $media_url_dir = $baseDir;
                $content_medai_img = @file_get_contents(UPLOAD_MEDIA_PATH . $image);
                $media_main = $media_url_dir . $base_img_name . '.jpg'; //name
                @mkdir($media_url_dir, 0777, true);
                $success = file_put_contents($media_main, $content_medai_img);


                $baseDir = UPLOAD_MEDIA_ORIGINAL_PATH;
                if ($file1[0]) {
                    $baseDir .= $file1[0] . '/';
                }

                if ($file1[1]) {
                    $baseDir .= $file1[1] . '/';
                } else {
                    $baseDir .= '_/';
                }
                $media_url_dir = $baseDir;
                $content_medai_img = @file_get_contents(UPLOAD_MEDIA_PATH . $image);
                $media_original = $media_url_dir . $base_img_name . '.jpg'; //name
                @mkdir($media_url_dir, 0777, true);
                $success = file_put_contents($media_original, $content_medai_img);

                $baseThumbPath = THUMB_BASE_MEDIA_DIRPATH;
                @mkdir($baseThumbPath, 0777, true);

                $baseDir = $baseThumbPath;
                if ($file1[0]) {
                    $baseDir .= $file1[0] . '/';
                }

                if ($file1[1]) {
                    $baseDir .= $file1[1] . '/';
                } else {
                    $baseDir .= '_/';
                }
                $thumb_url_dir = $baseDir;
                $media_thumb_url = $thumb_url_dir . $base_img_name . '.jpg';
                $midia_type = 'image';
                @mkdir($thumb_url_dir, 0777, true);
                $width = BASEPRODUCT_THUMBIMAGE_WIDTH;
                $height = BASEPRODUCT_THUMBIMAGE_HEIGHT;
                $image = $this->createImage(UPLOAD_MEDIA_PATH . $image, $width, $height, $media_thumb_url);
                @unlink(UPLOAD_MEDIA_PATH . $image);
                $media1['media_url'] = $media_main;
                $media1['thumb_url'] = $media_thumb_url;
                $media1['is_default'] = ($key == 0) ? 1 : 0;
                $media1['base_product_id'] = $id;
                $insertImages['images'][] = $media1;
            }
        }
        return $insertImages;
    }

    public function actionMediaFileDownload() {
        $file_name = 'bulk_upload_Media_File.csv';
        $file_data = 'base_product_id,media';
        $size_of_file = strlen($file_data);
        $this->renderPartial('fileDownload', array(
            'file_name' => $file_name,
            'file_data' => $file_data,
            'size_of_file' => $size_of_file
        ));
    }

    public function actionConfigurablegrid() {

        if (substr_count(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        $category_obj = new Category();
        $cat_base_product_ids = null;
        $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
        if (!empty($category_id)) {
            //get base product ids by category filter
            $cat_base_product_ids = $category_obj->getBaseProductIdsByCategory($category_id);
        }

        $model = new BaseProduct('configurablegrid');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BaseProduct'])) {
            $model->attributes = $_GET['BaseProduct'];
            $model->base_product_id = $_GET['BaseProduct']['base_product_id'];
        }

        $model->setAttribute('is_deleted', '=0');
        if (!((isset($model->status) AND $model->status != '' AND $model->status == 0) OR $model->status == 1)) {
            $model->setAttribute('status', '<2');
        }

        $this->render('configurablegrid', array(
            'model' => $model,
            'category_id' => $category_id,
            'cat_base_product_ids' => $cat_base_product_ids,
        ));
    }

    public function actionCreateconfigurable($id = null, $category_id = null) {

        if (substr_count(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        if (!empty($id)) {

            $cat_base_product_ids = '';
            if (!empty($category_id)) {
                $category_obj = new Category();
                //get base product ids by category filter
                $cat_base_product_ids = $category_obj->getBaseProductIdsByCategoryone($category_id, $id);
            }

            $model = $this->loadModel($id, 'is_deleted = 0 AND (status = 0 OR status = 1)');
            if (!empty($model)) {
                $reset = 0;
                if (isset($_POST['BaseProduct'])) {
                    try {
                        $oldConfigurableIds = trim($_POST['oldIds'], ',');
                        $newConfigurableIds = trim($_POST['selectedIds'], ',');
                        if ($model->updateConfigurations($newConfigurableIds, $oldConfigurableIds)) {

                            Yii::app()->user->setFlash('success', 'Changes Saved Successfully');
                        } else {

                            Yii::app()->user->setFlash('error', 'Changes Not Saved');
                        }
                    } catch (Exception $e) {
                        Yii::app()->user->setFlash('error', 'Changes Not Saved. ' . $e->getMessage());
                    }

                    $this->redirect(array('createconfigurable', 'id' => $id, 'category_id' => $category_id));
                    return;
                }

                $baseProductModel = new BaseProduct();
                $baseProductModel->unsetAttributes();
                $baseProductModel->setAttribute('is_deleted', '=0');
                $baseProductModel->setAttribute('status', '<2');
                //$baseProductModel->setAttribute('base_product_id','<>'.$id);
                if (isset($_GET['BaseProduct'])) {
                    $baseProductModel->attributes = $_GET['BaseProduct'];
                    $baseProductModel->base_product_id = $_GET['BaseProduct']['base_product_id'];
                }

                $this->render('createconfigurable', array(
                    'model' => $model,
                    'base_product_model' => $baseProductModel,
                    'cat_base_product_ids' => $cat_base_product_ids,
                    'base_product_id' => $id,
                    'reset' => $reset,
                    'category_id' => $category_id,
                ));
            } else {
                throw new CHttpException(401, 'Invalid Base Product');
            }
        } else {
            throw new CHttpException(401, 'Invalid Base Product');
        }
    }

    public function actionconfigurable_group($id = null) {
        if (substr_count(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        if (!empty($id)) {
            if (isset($_GET['category_id'])) {
                $category_id = $_GET['category_id'];
            }
            $category_id = '';
            $category_obj = new Category();
            $cat_base_product_ids = '';
            if (!empty($category_id)) {
                //get base product ids by category filter
                $cat_base_product_ids = $category_obj->getBaseProductIdsByCategoryone($category_id, $id);
            }


            $model = $this->loadModel($id, 'is_deleted = 0 AND (status = 0 OR status = 1)');
            if (!empty($model)) {
                $reset = 0;

                //  if (isset($_POST['BaseProduct'])) {
                if (isset($_POST['Save'])) {

                    try {
                        $oldConfigurableIds = trim($_POST['oldIds'], ',');
                        $newConfigurableIds = trim($_POST['selectedIds'], ',');
                        $baseproductids = array();
                        $category = $_POST['category_id'];
                        $store_id = $_POST['store_id'];
                        if (isset($_POST['userids'])) {
                            $baseproductids = $_POST['userids'];
                        }
                        if (count($baseproductids) == 0) {
                            Yii::app()->user->setFlash('error', 'Please Select Atleast one style. ');
                            $this->redirect(array('configurable_group', 'id' => $id, 'store_id' => $store_id, 'category_id' => $category));
                            die;
                        }
                        // print_R($baseproductids);die;
                        array_push($baseproductids, $_GET['id']);
                        if (isset($_POST['configureed_style']) && !empty($_POST['configureed_style'])) {
                            $configureed_style = explode(',', $_POST['configureed_style']);
                            $style_count = count($configureed_style);
                            $baseproductids = array_merge($baseproductids, $configureed_style);
                        }

                        if ($model->updateConfigurations_Group($newConfigurableIds, $oldConfigurableIds, $baseproductids)) {

                            Yii::app()->user->setFlash('success', 'Changes Saved Successfully');
                        } else {

                            Yii::app()->user->setFlash('error', 'Changes Not Saved');
                        }
                    } catch (Exception $e) {
                        Yii::app()->user->setFlash('error', 'Changes Not Saved. ' . $e->getMessage());
                    }

                    $this->redirect(array('addedstyle', 'id' => $id, 'store_id' => $store_id, 'category_id' => $category));
                    //$this->redirect(array('configurable_group','id'=>$id,'category_id'=>$category_id));
                    return;
                } else {
                    Yii::app()->user->setFlash('error_empty', 'Please Select Try Again. ');
                }
                //   }


                $baseProductModel = new BaseProduct();
                $baseProductModel->unsetAttributes();
                $baseProductModel->setAttribute('is_deleted', '=0');
                $baseProductModel->setAttribute('status', '<2');
                // $baseProductModel->setAttribute('base_product_id','<>'.$id);
                if (isset($_GET['BaseProduct'])) {
                    $baseProductModel->attributes = $_GET['BaseProduct'];
                    $baseProductModel->base_product_id = $_GET['BaseProduct']['base_product_id'];
                }


                $this->render('configurable_group', array(
                    'model' => $model,
                    'base_product_model' => $baseProductModel,
                    'cat_base_product_ids' => $cat_base_product_ids,
                    'base_product_id' => $id,
                    'reset' => $reset,
                    'category_id' => $category_id,
                ));
            } else {
                throw new CHttpException(401, 'Invalid Base Product');
            }
        } else {
            throw new CHttpException(401, 'Invalid Base Product');
        }
    }

    public function actionaddedstyle($id = null) {
        if (substr_count(Yii::app()->session['premission_info']['module_info']['baseproduct'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        if (!empty($id)) {
            if (isset($_GET['category_id'])) {
                $category_id = $_GET['category_id'];
            }
            $category_id = '';
            $cat_base_product_ids = '';
            $category_obj = new Category();
            if (!empty($category_id)) {
                //get base product ids by category filter
                $cat_base_product_ids = $category_obj->getBaseProductIdsByCategoryone($category_id, $id);
            }


            $model = $this->loadModel($id, 'is_deleted = 0 AND (status = 0 OR status = 1)');
            //print_r($model);die;
            if (!empty($model)) {
                $reset = 0;

                //  if (isset($_POST['BaseProduct'])) {
                if (isset($_POST['remove'])) {

                    try {
                        $oldConfigurableIds = trim($_POST['oldIds'], ',');
                        $newConfigurableIds = trim($_POST['selectedIds'], ',');
                        $baseproductids = array();
                        $category = $_POST['category_id'];
                        $store_id = $_POST['store_id'];
                        if (isset($_POST['baseproduct'])) {
                            $baseproductids = $_POST['baseproduct'];
                            // print_r($baseproductids);
                        }
                        if (count($baseproductids) == 0) {
                            Yii::app()->user->setFlash('error', 'Please Select Atleast one style. ');
                            $this->redirect(array('addedstyle', 'id' => $id, 'store_id' => $store_id, 'category_id' => $category));
                            die;
                        }
                        array_push($baseproductids, $_GET['id']);
                        //print_r($baseproductids);die;
                        if ($model->RemovefromConfigureIds($newConfigurableIds, $oldConfigurableIds, $baseproductids)) {

                            Yii::app()->user->setFlash('success', 'Changes Saved Successfully');
                        } else {

                            Yii::app()->user->setFlash('error', 'Changes Not Saved');
                        }
                    } catch (Exception $e) {
                        Yii::app()->user->setFlash('error', 'Changes Not Saved. ' . $e->getMessage());
                    }

                    $this->redirect(array('addedstyle', 'id' => $id, 'store_id' => $store_id, 'category_id' => $category));
                    //$this->redirect(array('configurable_group','id'=>$id,'category_id'=>$category_id));
                    return;
                } else {
                    Yii::app()->user->setFlash('error_empty', 'Please Select Try Again. ');
                }
                //   }


                $baseProductModel = new BaseProduct();
                $baseProductModel->unsetAttributes();
                $baseProductModel->setAttribute('is_deleted', '=0');
                $baseProductModel->setAttribute('status', '<2');
                // $baseProductModel->setAttribute('base_product_id','<>'.$id);
                if (isset($_GET['BaseProduct'])) {
                    $baseProductModel->attributes = $_GET['BaseProduct'];
                    $baseProductModel->base_product_id = $_GET['BaseProduct']['base_product_id'];
                }


                $this->render('addedstyle', array(
                    'model' => $model,
                    'base_product_model' => $baseProductModel,
                    'cat_base_product_ids' => $cat_base_product_ids,
                    'base_product_id' => $id,
                    'reset' => $reset,
                    'category_id' => $category_id,
                ));
            } else {
                throw new CHttpException(401, 'Invalid Base Product');
            }
        } else {
            throw new CHttpException(401, 'Invalid Base Product');
        }
    }

    public static function actionAjax() {
        $request = trim($_GET['term']);
        $store_id = trim($_REQUEST['store_id']);

        if ($request != '') {
            $model = BaseProduct::model()->findAll(array("condition" => "title like '$request%' AND store_id='$store_id'"));
            $data = array();

            $i = 0;
            foreach ($model as $get) {
                $data[] = array('value' => trim($get->title), 'label' => trim($get->title), 'id' => $get->base_product_id, 'title' => trim($get->title), 'description' => trim($get->description), 'season' => trim($get->season), 'color' => trim($get->color), 'minimum_order_quantity' => trim($get->minimum_order_quantity), 'available_quantity' => trim($get->available_quantity), 'fabric' => trim($get->fabric), 'order_placement_cut_off_date' => trim($get->order_placement_cut_off_date), 'delevry_date' => trim($get->delevry_date), 'size' => trim($get->size), 'size_brand' => trim($get->size_brand), 'tags' => trim($get->tags), 'specofic_keys' => trim($get->specofic_keys));
            }

            // season,color,minimum_order_quantity,available_quantity,fabric,order_placement_cut_off_date,tags,delevry_date

            echo CJSON::encode($data);
        }
    }

}
