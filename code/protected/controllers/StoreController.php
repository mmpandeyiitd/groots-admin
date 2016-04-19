<?php

class StoreController extends Controller {

    public $status;
    public $store_model;

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

  /*  protected function beforeAction($action) {
        $session = Yii::app()->session['user_id'];
        if ($session == '') {
            echo Yii::app()->controller->redirect("index.php?r=site/logout");
        }

        if (Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] != "S") {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        if ((strstr(Yii::app()->session['premission_info']['module_info']['brand'], 'C')) && (Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] != "S")) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        if ((strstr(Yii::app()->session['premission_info']['module_info']['brand'], 'U')) && (Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] != "S")) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        if ((strstr(Yii::app()->session['premission_info']['module_info']['brand'], 'D')) && (Yii::app()->session['premission_info']['menu_info']['brand_menu_info'] != "S")) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        return true;
    }
*/
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'export', 'mapretailer', 'update', 'brandprofile'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'export', 'brandprofile'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'export'),
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
        $model = new Store;
        if (substr_count(Yii::app()->session['premission_info']['module_info']['brand'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $password = '';
        if (isset($_POST['Store'])) {
            $password = '';
            $model->attributes = $_POST['Store'];
            $model->store_logo = CUploadedFile::getInstance($model, 'store_logo');
            $model->image = CUploadedFile::getInstance($model, 'image');

            if (empty($model->store_logo))
                unset($model['store_logo']);
            $name = explode('@', $model->email);
            if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
            }
            if ($password != $confirm_password||empty($password)) {
                Yii::app()->user->setFlash('brand_adminuser', 'Password does not match!');
                $this->render('create', array('model' => $model, 'password' => $password));
                exit();
            }


            if (isset($_POST['status'])) {
                $model->status = $_POST['status'];
            } else {
                $model->status = 0;
            }
            if ($password != '') {
                if ($model->save()) {

                    #....Create User.......#
                    $model_user = new Users();
                    //$model_user->password = $password;
                    $name = $model->seller_name;
                    $email = $model->email;
                    $user_type = "BrandAdmin";
                    $brand_id = $model->store_id;
                    $user_name = $model->email;
                    $userarray['email'] = $model->email;
                    $userarray['user_type'] = "BrandAdmin";
                    $userarray['user_name'] = $model->email;
                    $userarray['name'] = $model->seller_name;;
                    $userarray['brand_id'] = $model->store_id;
                    $permition = $this->moduleinformatio($userarray);
                    $model_user->permission_info = $permition;
                    $saveuser =  $model_user->CreateByBrand($name,$email,$user_type,$user_name,$brand_id,$password,$permition);

                    if (empty($saveuser)) {
                        $store_model=new store();
                        $store_model->Deletebybrand($model->store_id);
                        Yii::app()->user->setFlash('brand_adminuser', 'Brand has not Created because brand admin user already exist!');
                        $this->render('create', array('model' => $model, 'password' => $password));
                        exit;
                    }
                    #....Create User END.......#

                    if (isset($model->store_logo)) {

                        $model->store_logo->saveAs(STORE_LOGO_PATH . $model->store_logo);

                        $base_img_name = uniqid();
                        //$path  = pathinfo($media);
                        $file1 = $base_img_name;
                        $baseDir = STORE_LOGO_PATH;
                        if ($file1[0]) {
                            $baseDir .= $file1[0] . '/';
                        }

                        if ($file1[1]) {
                            $baseDir .= $file1[1] . '/';
                        } else {
                            $baseDir .= '_/';
                        }
                        $media_url_dir = $baseDir;
                        $content_medai_img = @file_get_contents(STORE_LOGO_PATH . $model->store_logo);
                        $media_main = $media_url_dir . $base_img_name . '.jpg'; //name
                        @mkdir($media_url_dir, 0777, true);
                        $success = file_put_contents($media_main, $content_medai_img);

                        $baseThumbPath = STORE_LOGO_THUMB_PATH;
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
                       // $store_model='';
                         $store_model=new store();
                        $thumb_url_dir = $baseDir;
                        $media_thumb_url = $thumb_url_dir . $base_img_name . '.jpg';
                        $image = $base_img_name . '.jpg';
                        $store_id = $model->store_id;
                        $store_model->Update_brandLOGO($store_id, $image, $media_thumb_url);
                        @mkdir($thumb_url_dir, 0777, true);
                        $width = STORE_THUMBIMAGE_WIDTH;
                        $height = STORE_THUMBIMAGE_HEIGHT;
                        $image = $this->createImage(STORE_LOGO_PATH . $model->store_logo, $width, $height, $media_thumb_url);
                        @unlink(STORE_LOGO_PATH . $model->store_logo);
                    }

                    if (isset($model->image)) {

                        $model->image->saveAs(UPLOAD_BRAND_PATH . $model->image);
                        $base_img_name = uniqid();
                        $file1 = $base_img_name;

                        $baseDir = MAIN_BRAND_MEDAI_DIRPATH;
                        if ($file1[0]) {
                            $baseDir .= $file1[0] . '/';
                        }

                        if ($file1[1]) {
                            $baseDir .= $file1[1] . '/';
                        } else {
                            $baseDir .= '_/';
                        }
                        $media_url_dir = $baseDir;
                        $content_medai_img = @file_get_contents('images/' . $model->image);
                        $media_main = $media_url_dir . $base_img_name . '.jpg'; //name
                        @mkdir($media_url_dir, 0777, true);
                        // $success = file_put_contents($media_main, $content_medai_img);
                        $width = BRAND_BIGIMAGE_WIDTH;
                        $height = BRAND_BIGIMAGE_HEIGHT;
                        $image = $this->createImage(UPLOAD_BRAND_PATH . $model->image, $width, $height, $media_main);


                        $baseDir = UPLOAD_BRAND_ORIGINAL_PATH;
                        if ($file1[0]) {
                            $baseDir .= $file1[0] . '/';
                        }

                        if ($file1[1]) {
                            $baseDir .= $file1[1] . '/';
                        } else {
                            $baseDir .= '_/';
                        }
                        $media_url_dir = $baseDir;
                        $content_medai_img = @file_get_contents('images/' . $model->image);
                        $media_original = $media_url_dir . $base_img_name . '.jpg'; //name
                        @mkdir($media_url_dir, 0777, true);
                        $success = file_put_contents($media_original, $content_medai_img);

                        $baseThumbPath = THUMB_BRAND_MEDIA_DIRPATH;
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
                        $store_id = $model->store_id;
                        $image = $base_img_name . '.jpg';

                        @mkdir($thumb_url_dir, 0777, true);
                        $width = BRAND_THUMBIMAGE_WIDTH;
                        $height = BRAND_THUMBIMAGE_HEIGHT;
                        $image = $this->createImage(UPLOAD_BRAND_PATH . $model->image, $width, $height, $media_thumb_url);
                        $store_model->Update_brandImage($store_id, $image, $media_thumb_url);
                        @unlink(UPLOAD_BRAND_PATH . $model->image);
                    }

                    Yii::app()->user->setFlash('success', 'Store Created Successfully');
                    $this->redirect(array('update', 'id' => $model->store_id));
                }
            } else {
                Yii::app()->user->setFlash('password_error', 'Password can not be blank');
            }
        }

        $this->render('create', array(
            'model' => $model,
            'password' => $password,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        // $id = Yii::app()->session['store_id'];
        $model = $this->loadModel($id);
        $status = $model->status;
        if (substr_count(Yii::app()->session['premission_info']['module_info']['brand'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Store']) && isset($id)) {

            $model->attributes = $_POST['Store'];

            $model->store_logo = CUploadedFile::getInstance($model, 'store_logo');
            $model->image = CUploadedFile::getInstance($model, 'image');
            unset($model['password']);
            if (empty($model->store_logo))
                unset($model['store_logo']);

            if (isset($_POST['status'])) {
                $model->status = $_POST['status'];
            } else {
                $model->status = 0;
            }
            if ($model->save()) {
                if (isset($model->store_logo)) {

                    $model->store_logo->saveAs(STORE_LOGO_PATH . $model->store_logo);

                    $base_img_name = uniqid();
                    //$path  = pathinfo($media);
                    $file1 = $base_img_name;
                    $baseDir = STORE_LOGO_PATH;
                    if ($file1[0]) {
                        $baseDir .= $file1[0] . '/';
                    }

                    if ($file1[1]) {
                        $baseDir .= $file1[1] . '/';
                    } else {
                        $baseDir .= '_/';
                    }
                    $media_url_dir = $baseDir;
                    $content_medai_img = @file_get_contents(STORE_LOGO_PATH . $model->store_logo);
                    $media_main = $media_url_dir . $base_img_name . '.jpg'; //name
                    @mkdir($media_url_dir, 0777, true);
                    $success = file_put_contents($media_main, $content_medai_img);

                    $baseThumbPath = STORE_LOGO_THUMB_PATH;
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
                    $store_id = $model->store_id;
                    $model->Update_brandLOGO($store_id, $image, $media_thumb_url);
                    @mkdir($thumb_url_dir, 0777, true);
                    $width = STORE_THUMBIMAGE_WIDTH;
                    $height = STORE_THUMBIMAGE_HEIGHT;
                    $image = $this->createImage(STORE_LOGO_PATH . $model->store_logo, $width, $height, $media_thumb_url);
                    @unlink(STORE_LOGO_PATH . $model->store_logo);
                }
                if (isset($model->image)) {
                    $model->image->saveAs(UPLOAD_BRAND_PATH . $model->image);
                    $base_img_name = uniqid();
                    $file1 = $base_img_name;

                    $baseDir = MAIN_BRAND_MEDAI_DIRPATH;
                    if ($file1[0]) {
                        $baseDir .= $file1[0] . '/';
                    }

                    if ($file1[1]) {
                        $baseDir .= $file1[1] . '/';
                    } else {
                        $baseDir .= '_/';
                    }
                    $media_url_dir = $baseDir;
                    $content_medai_img = @file_get_contents('images/' . $model->image);
                    $media_main = $media_url_dir . $base_img_name . '.jpg'; //name
                    @mkdir($media_url_dir, 0777, true);
                    // $success = file_put_contents($media_main, $content_medai_img);
                    $width = BRAND_BIGIMAGE_WIDTH;
                    $height = BRAND_BIGIMAGE_HEIGHT;
                    $image = $this->createImage(UPLOAD_BRAND_PATH . $model->image, $width, $height, $media_main);


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
                    $content_medai_img = @file_get_contents('images/' . $model->image);
                    $media_original = $media_url_dir . $base_img_name . '.jpg'; //name
                    @mkdir($media_url_dir, 0777, true);
                    $success = file_put_contents($media_original, $content_medai_img);

                    $baseThumbPath = THUMB_BRAND_MEDIA_DIRPATH;
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
                    $store_id = $model->store_id;
                    $image = $base_img_name . '.jpg';

                    $sql = "update store set image='" . $image . "',image_url='" . $media_thumb_url . "' where store_id='" . $store_id . "'";
                    $connection = Yii::app()->db;
                    $command = $connection->createCommand($sql);
                    $command->execute();

                    @mkdir($thumb_url_dir, 0777, true);
                    $width = BRAND_THUMBIMAGE_WIDTH;
                    $height = BRAND_THUMBIMAGE_HEIGHT;
                    $image = $this->createImage(UPLOAD_BRAND_PATH . $model->image, $width, $height, $media_thumb_url);
                    @unlink(UPLOAD_BRAND_PATH . $model->image);
                }
                //.......................solor backloag.................//
                $solrBackLog = new SolrBackLog();
                //$is_deleted =  ($model->status == 1) ? 0 : 1;
                $is_deleted = '0';
                $solrBackLog->insertByStoreId($id, $is_deleted);
                //.........................end.....................................//

                Yii::app()->user->setFlash('success', 'Store Updated Successfully');
                $this->redirect(array('update', 'id' => $model->store_id));
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

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

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
        // $model = new BaseProduct('search');
      
        $model = new Store();
        // $model->unsetAttributes();
        //  $record = $model->getRecordById($id);
        //  $model->unsetAttributes();
        // $model->setAttribute('store_id','1');
        // $model->attributes = @$record[0];
        if (substr_count(Yii::app()->session['premission_info']['module_info']['brand'], 'R') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        $issuperadmin = Yii::app()->session['is_super_admin'];
        if ($issuperadmin != 1) {
           
            $brand_id = Yii::app()->session['brand_id'];
            $this->redirect(array('brandprofile', 'store_id' => $brand_id));
        } else {
            $model->unsetAttributes();
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Store']))
                $model->attributes = $_GET['Store'];
            $this->render('admin', array(
                'model' => $model,
            ));
        }
    }

    public function actionbrandprofile($store_id) {

        $this->render('brandprofile', array(
            'model' => $this->loadModel($store_id),));
    }

    public function actionmapretailer($id) {
        $model_load = $this->loadModel($id);
        $model = new Store('search');
        $model1 = new Retailer();
        $model1->unsetAttributes();
        if (isset($_GET['Store'])) {
            $model1->attributes = $_GET['Retailer'];
            $model1->setAttribute('is_deleted', '=0');
        }
        if (isset($_POST['save'])) {
            $retailesid = $_POST['retailesid'];
            $check = count($retailesid);
            if ($check > 0) {
                $model->updateConfigurationsretailers($retailesid, $id);
            }
        }

        $model_load = $this->loadModel($id);
        $model1 = new Retailer();
        $this->render('mapretailer', array(
            'model' => $model,
            'model1' => $model1,
            'model_load' => $model_load,
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

        $model = Store::model()->findByPk($id);

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

    public function createImage($url, $width = 150, $height = 150, $savePath) {
        // The file
        $filename = $url;
        $pathInfo = pathinfo($filename);

        $size = getimagesize($filename);

        // Get new dimensions
        list($width_orig, $height_orig) = getimagesize($filename);

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

        return true;
    }

    public function actionExport($id) {
        $connection = Yii::app()->db;
        $sqlchksubsid = "SELECT sp.`subscribed_product_id`,sp.`base_product_id`,sp.`store_id`,s.store_name,bs.title,bs.color,sp.`store_price`,sp.`store_offer_price`,sp.`weight`,sp.`length`,sp.`width`,sp.`height`,sp.`status`,sp.sku,sp.`quantity`,sp.`is_cod`,sp.`created_date`,sp.`modified_date` FROM `subscribed_product` sp join store as s on s.store_id=sp.`store_id` join base_product as bs on bs.`base_product_id`=sp.`base_product_id` WHERE sp.`store_id`=" . $id . " group by sp.`base_product_id`";
        $command1 = $connection->createCommand($sqlchksubsid);
        $command1->execute();
        $assocDataArray = $command1->queryAll();
        $fileName = "Store_id_" . $id . ".csv";
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

    public function moduleinformatio($userarray) {
        //echo "'" . $userarray['name'] . "','" . $userarray['email'] . "','" . $userarray['name'] . "','" . $userarray['user_type'] . "','" . $userarray['brand_id'] . "',0"; die;
        
        $array_up['module_info']['Users'] = $userarray['name'].",".$userarray['email'].",".$userarray['name'].",".$userarray['user_type'].",".$userarray['brand_id'];
        $array_up['module_info']['retailers'] = 'R,C,U,D';
        $array_up['module_info']['retailerrequest'] = 'R,C,U,D';
        $array_up['module_info']['brand'] = 'R,C,U,D';
        $array_up['module_info']['linesheet'] = 'R,C,U,D';
        $array_up['module_info']['baseproduct'] = 'R,C,U,D';
        $array_up['module_info']['pressrelease'] = 'R,C,U,D';
        $array_up['module_info']['photogallery'] = 'R,C,U,D';
        $array_up['module_info']['lookbook'] = 'R,C,U,D';
        $array_up['module_info']['orderinfo'] = 'R,C,U,D';

        $array_up['menu_info']['users_menu_info'] = 'H';
        $array_up['menu_info']['category_menu_info'] = 'H';
        $array_up['menu_info']['retailers_menu_info'] = 'S';
        $array_up['menu_info']['retailerrequest_menu_info'] = 'S';
        $array_up['menu_info']['brand_menu_info'] = 'S';
        $array_up['menu_info']['linesheet_menu_info'] = 'S';
        $array_up['menu_info']['baseproduct_menu_info'] = 'S';
        $array_up['menu_info']['pressrelease_menu_info'] = 'S';
        $array_up['menu_info']['photogallery_menu_info'] = 'S';
        $array_up['menu_info']['lookbook_menu_info'] = 'S';
        $array_up['menu_info']['orderinfo_menu_info'] = 'S';
        $array_json = json_encode($array_up);
        return $array_json;
    }

}
