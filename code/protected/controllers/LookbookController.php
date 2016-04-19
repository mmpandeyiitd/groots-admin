<?php

class LookbookController extends Controller {

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

    private $oldAttrs = array();

    protected function beforeAction($action) {

        $session = Yii::app()->session['user_id'];
        if ($session == '') {
            echo Yii::app()->controller->redirect("index.php?r=site/logout");
        }

        if (Yii::app()->session['premission_info']['menu_info']['lookbook_menu_info'] != "S") {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }



        if ((strstr(Yii::app()->session['premission_info']['module_info']['lookbook'], 'U')) && (Yii::app()->session['premission_info']['menu_info']['lookbook_menu_info'] != "S")) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        if ((strstr(Yii::app()->session['premission_info']['module_info']['lookbook'], 'D')) && (Yii::app()->session['premission_info']['menu_info']['lookbook_menu_info'] != "S")) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
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
                'actions' => array('index', 'view', 'photogallarycreate', 'photogallaryupdate', 'Adminphoto', 'admin'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'photogallarycreate', 'photogallaryupdate', 'Adminphoto', 'admin'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'photogallarycreate', 'photogallaryupdate', 'Adminphoto'),
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

        $model = new Lookbook;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (substr_count(Yii::app()->session['premission_info']['module_info']['lookbook'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        if (isset($_POST['Lookbook'])) {

            $model->attributes = $_POST['Lookbook'];
            $images = CUploadedFile::getInstancesByName('images');
            $pdf = CUploadedFile::getInstancesByName('base_pdf');
            $issuperadmin = Yii::app()->session['is_super_admin'];


            if ($issuperadmin == 1) {
                $model->store_id = $_GET['store_id'];
            } else {
                $model->store_id = Yii::app()->session['brand_id'];
            }
            $model->type = "lookbook";
            if (isset($_POST['status'])) {
                $model->status = $_POST['status'];
            } else {
                $model->status = 0;
            }
            if ($model->save()) {
                if (isset($images) && count($images) > 0) {
                    foreach ($images as $image => $pic) {
                        $pic->saveAs(UPLOAD_MEDIA_PATH . $pic->name);
                        $base_img_name = uniqid();
                        $file1 = $base_img_name;
                        $baseDir = ORG_BASE_MEDIA_LOOK_DIRPATH;
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
                        $success = file_put_contents($media_main, $content_medai_img);
                        //.................thumb...........................//
                        $baseThumbPath = THUMB_BASE_MEDIA_LOOK_DIRPATH;
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

                        @mkdir($thumb_url_dir, 0777, true);
                        $width = LOOKBOOK_THUMBIMAGE_WIDTH;
                        $height = LOOKBOOK_THUMBIMAGE_HEIGHT;
                        $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_thumb_url);
                        //...........................end.......................................//
                        //.................mainimage...........................//
                        $baseMianPath = MAIN_BASE_MEDAI_lOOK_DIRPATH;
                        @mkdir($baseMianPath, 0777, true);

                        $MianDir = $baseMianPath;
                        if ($file1[0]) {
                            $MianDir .= $file1[0] . '/';
                        }

                        if ($file1[1]) {
                            $MianDir .= $file1[1] . '/';
                        } else {
                            $MianDir .= '_/';
                        }
                        $Mains_url_dir = $MianDir;
                        $media_mains_url = $Mains_url_dir . $base_img_name . '.jpg';

                        @mkdir($Mains_url_dir, 0777, true);
                        $width = LOOKBOOK_BIGIMAGE_WIDTH;
                        $height = LOOKBOOK_BIGIMAGE_HEIGHT;
                        $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_mains_url);
                        //...........................end.......................................//
                        $midia_type = 'image';
                        $type_page = 'lookbook';
                        $lookbook_id = $model->id;
                        //$brand_id = Yii::app()->session['store_id'];
                        $model->image_main_url = $media_main;
                        $model->image_thumb_url = $media_thumb_url;
                        $model->save();

//                        $connection = Yii::app()->db;
//                        $sql = "INSERT INTO `media_linesheet`(media_url, thumb_url, lookbook_id, media_type,type_page) VALUES('$media_main', '$media_thumb_url', '$lookbook_id', '$midia_type','$type_page')";
//                        $command = $connection->createCommand($sql);
//                        $command->execute();
                    }
                    @unlink(UPLOAD_MEDIA_PATH . $pic->name);
                }
                if (isset($pdf) && count($pdf) > 0) {
                    foreach ($pdf as $pdfid => $pdfname) {
                        $midia_type = 'pdf';
                        $type_page = 'lookbook';
                        $filename = '';
                        $lookbook_id = $model->id;
                        $filename = $lookbook_id . uniqid() . $pdfname->name;
                        @mkdir(UPLOAD_PDF_PATH, 0777, true);
                        $path = UPLOAD_PDF_PATH . $filename;
                        $pdfname->saveAs($path);
                        $model->pdf_url = $path;
                        $model->save();
//                        $connection = Yii::app()->db;
//                        $sql = "INSERT INTO `media_linesheet`(media_url, thumb_url, lookbook_id, media_type,type_page) VALUES ('$path', '$path', '$lookbook_id', '$midia_type','$type_page')";
//                        $command = $connection->createCommand($sql);
//                        $command->execute();
                    }
                }

//            $newAttrs = json_encode($this->getAttributes());
//            $oldAttrs = json_encode($this->getOldAttributes());
//            $log = new Log();
//            $data = array('login_id' => '', 'user_id' => Yii::app()->session['user_id'], 'name' => 'Lookbook ', 'action' => 'update', 'oldAttrs' => $oldAttrs, 'newAttrs' => $newAttrs);             
//            $log->insertLookbookLog($data);
                Yii::app()->user->setFlash('success', 'Created Successfully');
                $this->redirect(array('admin', "store_id" => $_GET['store_id']));
            }
        }
        $this->render('create', array('model' => $model,));
    }

    public function actionUpdate($id) {

        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (substr_count(Yii::app()->session['premission_info']['module_info']['lookbook'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        if (isset($_POST['Lookbook'])) {

            $model->attributes = $_POST['Lookbook'];
            if (isset($_POST['yt1']) && ($_POST['yt1'] == 'Delete')) {
                if (substr_count(Yii::app()->session['premission_info']['module_info']['lookbook'], 'D') > 0 && Yii::app()->session['brand_admin_id'] == $_GET['store_id']) {
                    $obj = new Lookbook();
                    $remove = $obj->deletelookbook($id);
                    Yii::app()->user->setFlash('Delete', 'Look Book Deleted successfully.');
                    $this->redirect(array('admin', 'store_id' => $_GET['store_id']));
                } else {
                    Yii::app()->user->setFlash('premission', 'No permission to delete');
                    $this->redirect(array('update', 'id' => $model->id, 'store_id' => $_GET['store_id']));
                    exit;
                }
            }

            $issuperadmin = Yii::app()->session['is_super_admin'];

            if ($issuperadmin == 1) {
                $model->store_id = $_GET['store_id'];
            } else {
                $model->store_id = Yii::app()->session['brand_id'];
            }

            if (isset($_POST['media_remove'])) {
                $model_media = new MediaLinesheet();
                foreach ($_POST['media_remove'] as $keyrm => $valuerm) {
                    $mediaremove = $model_media->deleteMediaByMediaId($valuerm);
                }
            }

            if (isset($_POST['PDF_remove'])) {
                foreach ($_POST['PDF_remove'] as $keypdfrm => $valuepdfrm) {
                    $pdfremove = $model_media->deletePdfByPdfId($valuepdfrm);
                }
            }

            $images = CUploadedFile::getInstancesByName('images');
            $pdf = CUploadedFile::getInstancesByName('base_pdf');

            if (isset($_POST['status'])) {
                $model->status = $_POST['status'];
            } else {
                $model->status = 0;
            }

            if ($model->save()) {
                if (isset($images) && count($images) > 0) {
                    foreach ($images as $image => $pic) {
                        $pic->saveAs(UPLOAD_MEDIA_PATH . $pic->name);
                        $base_img_name = uniqid();
                        //$path  = pathinfo($media);
                        $file1 = $base_img_name;
                        $baseDir = ORG_BASE_MEDIA_LOOK_DIRPATH;
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
                        $success = file_put_contents($media_main, $content_medai_img);
                        //.................thumb...........................//
                        $baseThumbPath = THUMB_BASE_MEDIA_LOOK_DIRPATH;
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

                        @mkdir($thumb_url_dir, 0777, true);
                        $width = LOOKBOOK_THUMBIMAGE_WIDTH;
                        $height = LOOKBOOK_THUMBIMAGE_HEIGHT;
                        $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_thumb_url);
                        //...........................end.......................................//
                        //.................mainimag...........................//
                        $baseMianPath = MAIN_BASE_MEDAI_lOOK_DIRPATH;
                        @mkdir($baseMianPath, 0777, true);

                        $MianDir = $baseMianPath;
                        if ($file1[0]) {
                            $MianDir .= $file1[0] . '/';
                        }

                        if ($file1[1]) {
                            $MianDir .= $file1[1] . '/';
                        } else {
                            $MianDir .= '_/';
                        }
                        $Mains_url_dir = $MianDir;
                        $media_mains_url = $Mains_url_dir . $base_img_name . '.jpg';

                        @mkdir($Mains_url_dir, 0777, true);
                        $width = LOOKBOOK_BIGIMAGE_WIDTH;
                        $height = LOOKBOOK_BIGIMAGE_HEIGHT;
                        $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_mains_url);
                        //...........................end.......................................//

                        $midia_type = 'image';
                        $type_page = 'lookbook';
                        $lookbook_id = $model->id;
                        //$brand_id = Yii::app()->session['store_id'];
                        $model->image_main_url = $media_main;
                        $model->image_thumb_url = $media_thumb_url;
                        $model->save();
//                        $connection = Yii::app()->db;
//                        $sql = "INSERT INTO `media_linesheet`(media_url, thumb_url, lookbook_id, media_type,type_page) VALUES('$media_main', '$media_thumb_url', '$lookbook_id', '$midia_type','$type_page')";
//                        $command = $connection->createCommand($sql);
//                        $command->execute();
                    }
                    @unlink(UPLOAD_MEDIA_PATH . $pic->name);
                }
                if (isset($pdf) && count($pdf) > 0) {
                    foreach ($pdf as $pdfid => $pdfname) {

                        $midia_type = 'pdf';
                        $type_page = 'lookbook';
                        $filename = '';
                        $lookbook_id = $model->id;
                        $filename = $lookbook_id . uniqid() . $pdfname->name;

                        @mkdir(UPLOAD_PDF_PATH, 0777, true);

                        $path = UPLOAD_PDF_PATH . $filename;
                        $pdfname->saveAs($path);
                        $model->pdf_url = $path;
                        // $model->image_thumb_url=$media_thumb_url;
                        $model->save();
//                        $connection = Yii::app()->db;
//                        $sql = "INSERT INTO `media_linesheet`(media_url, thumb_url, lookbook_id, media_type,type_page) VALUES ('$path', '$path', '$lookbook_id', '$midia_type','$type_page')";
//                        $command = $connection->createCommand($sql);
//                        $command->execute();
                    }
                    @unlink(UPLOAD_PDF_PATH . $pdfname->name);
                }

                Yii::app()->user->setFlash('success', 'Updated Successfully');
                $this->redirect(array('update', "id" => $model->id, "store_id" => $_GET['store_id']));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionPhotogallarycreate() {

        $model = new Lookbook;

        if (substr_count(Yii::app()->session['premission_info']['module_info']['photogallery'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }


        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Lookbook'])) {
            $model->attributes = $_POST['Lookbook'];
            $images = CUploadedFile::getInstancesByName('images');
            //  $pdf = CUploadedFile::getInstancesByName('base_pdf');
            $issuperadmin = Yii::app()->session['is_super_admin'];
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

            $model->type = "photo";
            if ($model->save()) {
                if (isset($images) && count($images) > 0) {
                    foreach ($images as $image => $pic) {
                        $pic->saveAs(UPLOAD_MEDIA_PATH . $pic->name);
                        $base_img_name = uniqid();
                        //$path  = pathinfo($media);
                        $file1 = $base_img_name;
                        $baseDir = ORG_BASE_MEDIA_LOOK_DIRPATH;
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
                        $success = file_put_contents($media_main, $content_medai_img);
                        //.................thumb...........................//
                        $baseThumbPath = THUMB_BASE_MEDIA_LOOK_DIRPATH;
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

                        @mkdir($thumb_url_dir, 0777, true);
                        $width = 150;
                        $height = 150;
                        $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_thumb_url);
                        //...........................end.......................................//
                        //.................mainimag...........................//
                        $baseMianPath = MAIN_BASE_MEDAI_lOOK_DIRPATH;
                        @mkdir($baseMianPath, 0777, true);

                        $MianDir = $baseMianPath;
                        if ($file1[0]) {
                            $MianDir .= $file1[0] . '/';
                        }

                        if ($file1[1]) {
                            $MianDir .= $file1[1] . '/';
                        } else {
                            $MianDir .= '_/';
                        }
                        $Mains_url_dir = $MianDir;
                        $media_mains_url = $Mains_url_dir . $base_img_name . '.jpg';

                        @mkdir($Mains_url_dir, 0777, true);
                        $width = PHOTOGALLERY_BIGIMAGE_WIDTH;
                        $height = PHOTOGALLERY_BIGIMAGE_HEIGHT;
                        $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_mains_url);
                        //...........................end.......................................//

                        $midia_type = 'image';
                        $type_page = 'photo';
                        $lookbook_id = $model->id;
                        $model->image_main_url = $media_main;
                        $model->image_thumb_url = $media_thumb_url;
                        $model->save();
//                        $connection = Yii::app()->db;
//                        $sql = "INSERT INTO `media_linesheet`(media_url, thumb_url, lookbook_id, media_type,type_page) VALUES('$media_main', '$media_thumb_url', '$lookbook_id', '$midia_type','$type_page')";
//                        $command = $connection->createCommand($sql);
//                        $command->execute();
                    }
                }

                Yii::app()->user->setFlash('success', 'Created Successfully');
                $this->redirect(array('Photogallaryupdate', "id" => $model->id, "store_id" => $_GET['store_id']));
            }
        }

        $this->render('photog', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionPhotogallaryupdate($id) {

        if (substr_count(Yii::app()->session['premission_info']['module_info']['photogallery'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }


        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Lookbook'])) {
            // $media__line=new MediaLinesheet();
            if (isset($_POST['media_remove'])) {
                foreach ($_POST['media_remove'] as $keyrm => $valuerm) {
                    $mediaremove = $media__line->deleteMediaByMediaId($valuerm);
                }
            }

            if (isset($_POST['yt1']) && ($_POST['yt1'] == 'Delete')) {
                if (substr_count(Yii::app()->session['premission_info']['module_info']['photogallery'], 'D') > 0 && Yii::app()->session['brand_admin_id'] == $_GET['store_id']) {
                    $obj = new Lookbook();
                    $remove = $obj->deletelookbook($id);
                    Yii::app()->user->setFlash('Delete', 'Photogallery Deleted successfully.');
                    $this->redirect(array('Adminphoto', 'store_id' => $_GET['store_id']));
                } else {
                    Yii::app()->user->setFlash('premission', 'No permission to delete');
                    $this->redirect(array('updateg', 'id' => $model->id, 'store_id' => $_GET['store_id']));
                    exit;
                }
            }

            $model->attributes = $_POST['Lookbook'];

            if (isset($_POST['status'])) {
                $model->status = $_POST['status'];
            } else {
                $model->status = 0;
            }

            $images = CUploadedFile::getInstancesByName('images');
            $issuperadmin = Yii::app()->session['is_super_admin'];
            if ($issuperadmin == 1) {
                $store_id = $_GET['store_id'];
            } else {
                $store_id = Yii::app()->session['brand_id'];
            }


            if ($model->save()) {
                if (isset($images) && count($images) > 0) {
                    foreach ($images as $image => $pic) {
                        $pic->saveAs(UPLOAD_MEDIA_PATH . $pic->name);
                        $base_img_name = uniqid();
                        //$path  = pathinfo($media);
                        $file1 = $base_img_name;
                        $baseDir = ORG_BASE_MEDIA_LOOK_DIRPATH;
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
                        $success = file_put_contents($media_main, $content_medai_img);
                        //.................thumb...........................//
                        $baseThumbPath = THUMB_BASE_MEDIA_LOOK_DIRPATH;
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

                        @mkdir($thumb_url_dir, 0777, true);
                        $width = PHOTOGALLERY_THUMBIMAGE_WIDTH;
                        $height = PHOTOGALLERY_THUMBIMAGE_HEIGHT;
                        $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_thumb_url);
                        //...........................end.......................................//
                        //.................mainimag...........................//
                        $baseMianPath = MAIN_BASE_MEDAI_lOOK_DIRPATH;
                        @mkdir($baseMianPath, 0777, true);

                        $MianDir = $baseMianPath;
                        if ($file1[0]) {
                            $MianDir .= $file1[0] . '/';
                        }

                        if ($file1[1]) {
                            $MianDir .= $file1[1] . '/';
                        } else {
                            $MianDir .= '_/';
                        }
                        $Mains_url_dir = $MianDir;
                        $media_mains_url = $Mains_url_dir . $base_img_name . '.jpg';

                        @mkdir($Mains_url_dir, 0777, true);
                        $width = PHOTOGALLERY_BIGIMAGE_WIDTH;
                        $height = PHOTOGALLERY_BIGIMAGE_HEIGHT;
                        $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_mains_url);
                        //...........................end.......................................//

                        $midia_type = 'image';
                        $type_page = 'photo';
                        $lookbook_id = $model->id;
                        //$brand_id = Yii::app()->session['store_id'];
                        $model->image_main_url = $media_main;
                        $model->image_thumb_url = $media_thumb_url;
                        $model->save();
//                        $connection = Yii::app()->db;
//                        $sql = "INSERT INTO `media_linesheet`(media_url, thumb_url, lookbook_id, media_type,type_page) VALUES('$media_main', '$media_thumb_url', '$lookbook_id', '$midia_type','$type_page')";
//                        $command = $connection->createCommand($sql);
//                        $command->execute();
                    }
                    @unlink(UPLOAD_MEDIA_PATH . $pic->name);
                }
                Yii::app()->user->setFlash('success', 'Updated Successfully');
                $this->redirect(array('Photogallaryupdate', "id" => $model->id, "store_id" => $model->store_id));
            }
        }

        $this->render('updateg', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {

        if ((strstr(Yii::app()->session['premission_info']['module_info']['photogallery'], 'D')) && (Yii::app()->session['premission_info']['menu_info']['photogallery_menu_info'] != "S")) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access.');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Lookbook');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Lookbook('search');


        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Lookbook']))
            $model->attributes = $_GET['Lookbook'];
        $search = '';
        // if (isset($_POST['Lookbook'])){
        if (isset($_POST['searchsubmit'])) {
            // $model->attributes = $_GET['Lookbook'];
            $search = $_POST['searchtext'];
        }
        // }
        $this->render('admin', array(
            'model' => $model,
            'search' => $search,
        ));
    }

    public function actionAdminphoto() {
        $model = new Lookbook;

        if (substr_count(Yii::app()->session['premission_info']['module_info']['photogallery'], 'R') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Lookbook']))
            $model->attributes = $_GET['Lookbook'];

        $this->render('adminphog', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Lookbook the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Lookbook::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Lookbook $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'lookbook-form') {
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

    public function getOldAttributes() {
        return $this->oldAttrs;
    }

    public function setOldAttributes($attrs) {
        $this->oldAttrs = $attrs;
    }

}
