<?php

class PressReleaseController extends Controller {

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

    protected function beforeAction($action) {
        $session = Yii::app()->session['user_id'];
        if ($session == '') {
            echo Yii::app()->controller->redirect("index.php?r=site/logout");
        }

        if (Yii::app()->session['premission_info']['menu_info']['pressrelease_menu_info'] != "S") {
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
                'actions' => array('index', 'view', 'admin', 'delete'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'delete'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
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
        $model = new PressRelease;
        if (substr_count(Yii::app()->session['premission_info']['module_info']['pressrelease'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['PressRelease'])) {
            $model->attributes = $_POST['PressRelease'];

            $issuperadmin = Yii::app()->session['is_super_admin'];
            if ($issuperadmin == 1) {
                $model->brand_id = $_GET['store_id'];
            } else {
                $model->brand_id = Yii::app()->session['brand_id'];
            }
            if (isset($_POST['status'])) {
                $model->status = $_POST['status'];
            } else {
                $model->status = 0;
            }
            $model->image = CUploadedFile::getInstance($model, 'image');

            if ($model->save()) {


                if (isset($model->image)) {

                    $model->image->saveAs(UPLOAD_PRESSRELEASE_PATH . $model->image);
                    $base_img_name = uniqid();
                    $file1 = $base_img_name;

                    $baseDir = MAIN_PRESSRELEASE_DIRPATH;
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
                    $image = $this->createImage(UPLOAD_PRESSRELEASE_PATH . $model->image, $width, $height, $media_main);


                    $baseDir = UPLOAD_PRESSRELEASE_ORIGINAL_PATH;
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

                    $baseThumbPath = THUMB_PRESSRELEASE_DIRPATH;
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

                    @mkdir($thumb_url_dir, 0777, true);
                    $width = BRAND_THUMBIMAGE_WIDTH;
                    $height = BRAND_THUMBIMAGE_HEIGHT;
                    $image = $this->createImage(UPLOAD_PRESSRELEASE_PATH . $model->image, $width, $height, $media_thumb_url);
                    $press_obj= new PressRelease();
                    $press_obj->Update_image($media_thumb_url, $media_main, $image, $model->id);
                    @unlink(UPLOAD_PRESSRELEASE_PATH . $model->image);
                }
                Yii::app()->user->setFlash('success', 'Press Release Created successfully');
                $this->redirect(array('update', 'id' => $model->id, 'store_id' => $_GET['store_id']));
            }
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
        $model_press=new PressRelease();
        if (substr_count(Yii::app()->session['premission_info']['module_info']['pressrelease'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['yt1']) && ($_POST['yt1'] == 'Delete')) {
            if (substr_count(Yii::app()->session['premission_info']['module_info']['pressrelease'], 'D') > 0 && Yii::app()->session['brand_admin_id']==$_GET['store_id']) {
                $mediaremove = $model_press->deletePresrelease($id);
                Yii::app()->user->setFlash('Delete', 'Press Release Deleted successfully.');
                $this->redirect(array('admin', 'store_id' => $_GET['store_id']));
            } else {
                 Yii::app()->user->setFlash('premission', 'No permission to delete');
                $this->redirect(array('update', 'id' => $model->id, 'store_id' => $_GET['store_id']));
                exit;
            }
        }
        if (isset($_POST['PressRelease'])) {
            $model->attributes = $_POST['PressRelease'];
            $model->image = CUploadedFile::getInstance($model, 'image');
            if (empty($model->image))
                unset($model['image']);
            if (isset($_POST['status'])) {
                $model->status = $_POST['status'];
            } else {
                $model->status = 0;
            }
            if ($model->save()) {

                if (isset($model->image)) {

                    $model->image->saveAs(UPLOAD_PRESSRELEASE_PATH . $model->image);
                    $base_img_name = uniqid();
                    $file1 = $base_img_name;

                    $baseDir = MAIN_PRESSRELEASE_DIRPATH;
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
                    $image = $this->createImage(UPLOAD_PRESSRELEASE_PATH . $model->image, $width, $height, $media_main);


                    $baseDir = UPLOAD_PRESSRELEASE_ORIGINAL_PATH;
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

                    $baseThumbPath = THUMB_PRESSRELEASE_DIRPATH;
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
                    $image_name = $base_img_name . '.jpg';

                    @mkdir($thumb_url_dir, 0777, true);
                    $width = BRAND_THUMBIMAGE_WIDTH;
                    $height = BRAND_THUMBIMAGE_HEIGHT;
                    $image = $this->createImage(UPLOAD_PRESSRELEASE_PATH . $model->image, $width, $height, $media_thumb_url);
                   $model_press=new PressRelease();
                    $model_press->Update_image($media_thumb_url, $media_main, $image_name, $model->id);
                    @unlink(UPLOAD_PRESSRELEASE_PATH . $model->image);
                }
                Yii::app()->user->setFlash('success', 'Press Release Updated successfully');
                $this->redirect(array('update', 'id' => $model->id, 'store_id' => $_GET['store_id']));
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
        echo $id;
        die;
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('PressRelease');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new PressRelease('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PressRelease']))
            $model->attributes = $_GET['PressRelease'];

        $this->render('admin', array(
            'model' => $model,
                // 'store_id'=>$_GET['store_id'],
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PressRelease the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = PressRelease::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param PressRelease $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'press-release-form') {
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

}
