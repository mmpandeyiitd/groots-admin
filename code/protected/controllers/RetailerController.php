<?php

class RetailerController extends Controller {

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

    protected function beforeAction($action) {

        $session = Yii::app()->session['user_id'];
        if ($session == '') {
            echo Yii::app()->controller->redirect("index.php?r=site/logout");
        }
        if (isset(Yii::app()->session['premission_info']['menu_info']['retailers'])) {
            if (Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] != "S") {
                Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
                Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
            }
        }

        if (isset(Yii::app()->session['premission_info']['module_info']['retailers'])) {
            if ((strstr(Yii::app()->session['premission_info']['module_info']['retailers'], 'C')) && (Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] != "S")) {
                Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
                Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
            }

            if ((strstr(Yii::app()->session['premission_info']['module_info']['retailers'], 'U')) && (Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] != "S")) {
                Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
                Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
            }

            if ((strstr(Yii::app()->session['premission_info']['module_info']['retailers'], 'D')) && (Yii::app()->session['premission_info']['menu_info']['retailers_menu_info'] != "S")) {
                Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
                Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
            }
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
                'actions' => array('index', 'view', 'admin', 'update', 'delete', 'retailerinfo'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'delete', 'retailerinfo'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'retailerinfo'),
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

    public function actionretailerinfo($id) {
        $this->render('retailerinfo', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
       // echo '<pre>';print_r($_POST);die;
        $model = new Retailer;
         
        // echo Yii::app()->session['premission_info']['module_info']['retialers'];die;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if ((substr_count(Yii::app()->session['premission_info']['module_info']['retailers'], 'C') == 0)) {
            Yii::app()->user->setFlash('permissio_error', 'You have Not Permission to Create');
            $this->redirect(array('retailer/admin'));
            return;
        }
        if (isset($_POST['Retailer'])) {
            $data_pass= $_POST['Retailer']['password'];
            $model->attributes = $_POST['Retailer'];
            $model->modified_date = date('Y-m-d H:i:s');
            
            $images = CUploadedFile::getInstancesByName('images');
            // echo count($images);die;
            if (isset($_POST['status'])) {
                $model->status = $_POST['status'];
            } else {
                $model->status = 1;
            }
             if ($_POST['Retailer']['date_of_onboarding']!='') {
                $model->date_of_onboarding = date("Y-m-d H:i:s", strtotime($_POST['Retailer']['date_of_onboarding']));
            } else {
                $model->date_of_onboarding = date('Y-m-d H:i:s');
            }
         
//            if($_POST['Retailer']['password'] !='' && strlen($_POST['Retailer']['password'])<12){
//                  
//                $pass = md5($model->password);
//                $model->password = $pass;
//                }
//               
            if ($model->save()) {
              $from_email = 'grootsadmin@groots.in';
            $from_name = 'Groots Dashboard Admin';
            $subject = 'Groots Buyer Account';
            $urldata = Yii::app()->params['target_app_url'];
            $emailurldata = Yii::app()->params['email_app_url1'];
            $body_html = '<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Email Verification </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,600,300italic,700,700italic" rel="stylesheet" type="text/css">
	</head>
	<body style="margin: 0; padding: 0; font-family: sans-serif;">
	 <table align="center"  cellpadding="0" border="0" cellspacing="0" width="600" style="border-collapse: collapse; display: block; border:0; background:#fff; ">
    <tbody>
    <tr style="display: block; ">
      <td style="padding:0px; width: 150px; background-color: #444;" >
        <a href="javascript:void(0);" style="display:block; height:63px; "><img src="'.$emailurldata .'emailimage/logo.png" alt="" style="    width: 50px;
    margin: 8px 20px;"></a>
      </td>
      <td style="padding: 5px 10px; width:450px; background-color:#444;color: #fff;font-size: 24px; text-transform: uppercase; text-align:right;">
        <span style="float:right;">+91 99999 99999</span>
        <img src="'.$emailurldata .'emailimage/callIco-head.png" alt="call" width="25" style="float:right; margin:0 10px;"> 
      </td>
    </tr>
    <tr>
      <td colspan="2" style="text-align:center;padding:20px 0; background:#fff url('.$emailurldata .'emailimage/bg-repeat.jpg) repeat-x;">
        <img src="'.$emailurldata .'emailimage/check-shadow.png" alt="call" width="100" style=" margin:20px auto;"> 
      </td>
    </tr>
    <tr style="display: block;">
      <td colspan="2" style="display: block; padding: 10px;border: 1px solid #f7f7f7;border-width: 1px 2px 0;">
        <p style="font-size:20px;">
          <strong>Hi ' . $model->name . '</strong>
          <br> 
          <span style="margin-top:15px; display:block; font-size:14px; line-height:30px;">
            Your account created successfully.<br>
            <strong >Email:</strong>   ' . $model->email . '<br>
            <strong >Password:</strong> ' . $data_pass . '
          </span>
          <br>

        <a href="'.$urldata.'">
             <img src="'.$emailurldata .'emailimage/android.png" alt="call" width="225" style= text-indent:-2000px; display:block;"> 
            </a>
        <br> <br> 
      </p>
     </td>          
   </tr>
    <tr style="display: block; margin-top:0px;background: #444; padding: 15px 0;">
      <td colspan="2" style="width: 600px;">
        <ul style="display:block; width:100%; list-style-type:none;overflow: hidden;margin: 0;padding: 10px 0;">
          <li style="display:block; width:200px; float:left; text-align:center;">
            <a href="#!" style="display:block;color:#a9a9a9; text-transform:uppercase;text-decoration:none; font-size:14px; border-right:1px solid #676767;">Visit Website</a>
          </li>
          <li style="display:block; width:200px; float:left; text-align:center;">
            <a href="#!" style="display:block;color:#a9a9a9; text-transform:uppercase;text-decoration:none; font-size:14px;">Terms &amp; Conditions</a>
          </li>
          <li style="display:block; width:200px; float:left; text-align:center;">
            <a href="#!" style="display:block;color:#a9a9a9; text-transform:uppercase;text-decoration:none; font-size:14px; border-left:1px solid #676767;">Privacy Policy</a>
          </li>
        </ul>
      </td> 
    </tr>
	</tbody></table>
	</body>
</html>';
            
            
            
            $body_text = '';

            $mailArray = array(
                'to' => array(
                    '0' => array(
                        'email' => "$model->email",
                    )
                ),
                'from' => $from_email,
                'fromname' => $from_name,
                'subject' => $subject,
                'html' => $body_html,
                'text' => $body_text,
                'replyto' => $from_email,
            );
            $mailsend = new Store();
            $resp = $model->sgSendMail($mailArray);
                if (isset($images) && count($images) > 0) {
                    foreach ($images as $image => $pic) {
                        $pic->saveAs(UPLOAD_MEDIA_PATH . $pic->name);
                        $base_img_name = uniqid();
                        $file1 = $base_img_name;

                        $baseDir = MAIN_RETAILER_DIRPATH;
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
                        // $success = file_put_contents($media_main, $content_medai_img);
                        $width = RETAILER_BIGIMAGE_WIDTH;
                        $height = RETAILER_BIGIMAGE_HEIGHT;
                        $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_main);


                        $baseDir = UPLOAD_RETAILER_ORIGINAL_PATH;
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

                        $baseThumbPath = THUMB_RETAILER_DIRPATH;
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
                        $retailer_id = $model->id;

                        $model->insertMediaretailer($media_main, $media_thumb_url, $retailer_id);
                        @mkdir($thumb_url_dir, 0777, true);
                        $width = RETAILER_THUMBIMAGE_WIDTH;
                        $height = RETAILER_THUMBIMAGE_HEIGHT;
                        $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_thumb_url);
                    }
                }
                  $model->mdpassword($model->email,$data_pass);
                @unlink(UPLOAD_MEDIA_PATH . $pic->name);
                Yii::app()->user->setFlash('success', 'Created Successfully');
                $this->redirect(array('update', 'id' => $model->id));
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

        //echo $_REQUEST['r'];die;
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset(Yii::app()->session['premission_info']->module_info->retailers) && (strpos(Yii::app()->session['premission_info']->module_info->retailers, 'C') == false )) {
            Yii::app()->user->setFlash('error', 'You have Not Permission to Update');
            $this->redirect(array('retailer/update'));
            return;
        }
        if (isset($_POST['Retailer'])) {
            $model->attributes = $_POST['Retailer'];
            $model->modified_date = date('Y-m-d H:i:s');
            $images = CUploadedFile::getInstancesByName('images');
            $model_media = new MediaRetailer();
            if (isset($_POST['media_remove'])) {
                foreach ($_POST['media_remove'] as $keyrm => $valuerm) {
                    $mediaremove = $model_media->deleteMediaByMediaId($valuerm);
                }
            }
            if ($model->save()) {
                if (isset($images) && count($images) > 0) {
                    foreach ($images as $image => $pic) {
                        $pic->saveAs(UPLOAD_MEDIA_PATH . $pic->name);
                        $base_img_name = uniqid();
                        $file1 = $base_img_name;

                        $baseDir = MAIN_RETAILER_DIRPATH;
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
                        // $success = file_put_contents($media_main, $content_medai_img);
                        $width = RETAILER_BIGIMAGE_WIDTH;
                        $height = RETAILER_BIGIMAGE_HEIGHT;
                        $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_main);


                        $baseDir = UPLOAD_RETAILER_ORIGINAL_PATH;
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

                        $baseThumbPath = THUMB_RETAILER_DIRPATH;
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
                        $retailer_id = $model->id;

                        $model->insertMediaretailer($media_main, $media_thumb_url, $retailer_id);
                        @mkdir($thumb_url_dir, 0777, true);
                        $width = RETAILER_THUMBIMAGE_WIDTH;
                        $height = RETAILER_THUMBIMAGE_HEIGHT;
                        $image = $this->createImage(UPLOAD_MEDIA_PATH . $pic->name, $width, $height, $media_thumb_url);
                    }
                }
              
                @unlink(UPLOAD_MEDIA_PATH . $pic->name);
                Yii::app()->user->setFlash('success', 'Updated Successfully');
                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
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
        $dataProvider = new CActiveDataProvider('Retailer');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin1() {
        $model = new Retailer('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Retailer']))
            $model->attributes = $_GET['Retailer'];
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAdmin() {
        // $model = new BaseProduct('search');

        $model = new Retailer();
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
            if (isset($_GET['Retailer']))
                $model->attributes = $_GET['Retailer'];
            $this->render('admin', array(
                'model' => $model,
            ));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Retailer the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Retailer::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Retailer $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'retailer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
