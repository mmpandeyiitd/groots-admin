<?php

class UsersController extends Controller {

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
                //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all Userss to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'create', 'delete'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated Users to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'delete'),
                'users' => array('@'),
            ),
            array('allow', // allow admin Users to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'create'),
            //'Admin'=>array('admin'),
            ),
            array('deny', // deny all Userss
            //'Users'=>array('*'),
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

//    protected function beforeAction($action) {
//
//        $session = Yii::app()->session['user_id'];
//        if ($session == '') {
//            echo Yii::app()->controller->redirect("index.php?r=site/logout");
//        }
//
//        if (Yii::app()->session['premission_info']['menu_info']['users_menu_info'] != "S") {
//            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
//
//            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
//        }
//
//        return true;
//    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new Users;
        $confirm_password = '';
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (substr_count(Yii::app()->session['premission_info']['module_info']['Users'], 'C') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        if (isset(Yii::app()->session['premission_info']['module_info']['Users']) && (strstr(Yii::app()->session['premission_info']['module_info']['Users'], 'C') == false )) {
            Yii::app()->user->setFlash('error', 'You have Not Permission to Create');
            $this->redirect(array('users/admin'));
        } else {

            if (isset($_POST['Users'])) {
                $model->attributes = $_POST['Users'];

                if ((empty($_POST['Users']) && empty($_POST['brand']) && empty($_POST['linesheet']) && empty($_POST['photogallery']) && empty($_POST['orderinfo']) && empty($_POST['retailerrequest']) && empty($_POST['retailers']) && empty($_POST['category']) && empty($_POST['baseproduct']) && empty($_POST['pressrelease']) && empty($_POST['lookbook'])) || (empty($_POST['users_menu_info']) && empty($_POST['brand_menu_info']) && empty($_POST['lookbook_menu_info']) && empty($_POST['orderinfo_menu_info']) && empty($_POST['photogallery_menu_info']) && empty($_POST['linesheet_menu_info']) && empty($_POST['baseproduct_menu_info']) && empty($_POST['pressrelease_menu_info']) && empty($_POST['retailerrequest_menu_info']) && empty($_POST['retailers_menu_info']) && empty($_POST['retailerProductQuotation_menu_info']) && empty($_POST['subscribedProduct_menu_info']))) {
                    Yii::app()->user->setFlash('error', 'Atleast One module Should be Selected');
                    $this->render('create', array('model' => $model, 'confirm_password' => $confirm_password));
                    exit();
                } else {


                    if (isset($_POST['confirm_password'])) {
                        $confirm_password = $_POST['confirm_password'];
                    }
                    if ($confirm_password != $model->password) {
                        Yii::app()->user->setFlash('error', 'Password does not match!');
                        $this->render('create', array('model' => $model, 'confirm_password' => $confirm_password));
                        exit();
                    }

                    if ($model->user_type != "SuperAdmin" && $model->user_type != "BrandAdmin") {
                        Yii::app()->user->setFlash('error', 'Please select user type');
                        $this->render('create', array('model' => $model, 'confirm_password' => $confirm_password));
                        exit();
                    } else {

                        if ($model->user_type == "SuperAdmin") {
                            $model->is_superadmin = 1;
                        } elseif ($model->user_type == "BrandAdmin") {
                            $model->is_superadmin = 0;
                            if (empty($model->brand_id)) {
                                Yii::app()->user->setFlash('error', 'Brand Should be selected for brand admin');
                                $this->render('create', array('model' => $model, 'confirm_password' => $confirm_password));
                                exit();
                            }
                        }
                    }

                    if ($model->save()) {

                        $id = $model->id;
                        $array_up = array();
                        $array_up['Users_id'] = $id;

                        if (isset($_POST['Users'])) {
                            $array_up['module_info']['Users'] = implode(",", $_POST['Users']);
                        } else {
                            $array_up['module_info']['Users'] = '';
                        }

                        if (isset($_POST['retailers'])) {
                            $array_up['module_info']['retailers'] = implode(",", $_POST['retailers']);
                        } else {
                            $array_up['module_info']['retailers'] = '';
                        }


                        if (isset($_POST['brand'])) {
                            $array_up['module_info']['brand'] = implode(",", $_POST['brand']);
                        } else {
                            $array_up['module_info']['brand'] = '';
                        }

                        if (isset($_POST['linesheet'])) {
                            $array_up['module_info']['linesheet'] = implode(",", $_POST['linesheet']);
                        } else {
                            $array_up['module_info']['linesheet'] = '';
                        }

                        if (isset($_POST['baseproduct'])) {
                            $array_up['module_info']['baseproduct'] = implode(",", $_POST['baseproduct']);
                        } else {
                            $array_up['module_info']['baseproduct'] = '';
                        }

                        if (isset($_POST['pressrelease'])) {
                            $array_up['module_info']['pressrelease'] = implode(",", $_POST['pressrelease']);
                        } else {
                            $array_up['module_info']['pressrelease'] = '';
                        }

                        if (isset($_POST['photogallery'])) {
                            $array_up['module_info']['photogallery'] = implode(",", $_POST['photogallery']);
                        } else {
                            $array_up['module_info']['photogallery'] = '';
                        }

                        if (isset($_POST['orderiinfo'])) {
                            $array_up['module_info']['orderiinfo'] = implode(",", $_POST['orderiinfo']);
                        } else {
                            $array_up['module_info']['orderiinfo'] = '';
                        }

                        if (isset($_POST['lookbook'])) {
                            $array_up['module_info']['lookbook'] = implode(",", $_POST['lookbook']);
                        } else {
                            $array_up['module_info']['lookbook'] = '';
                        }

                        if (isset($_POST['category'])) {
                            $array_up['module_info']['category'] = implode(",", $_POST['category']);
                        } else {
                            $array_up['module_info']['category'] = '';
                        }

                        if (isset($_POST['retailerrequest'])) {
                            $array_up['module_info']['retailerrequest'] = implode(",", $_POST['retailerrequest']);
                        } else {
                            $array_up['module_info']['retailerrequest'] = '';
                        }
                        if (isset($_POST['retailerProductQuotation'])) {
                            $array_up['module_info']['retailerProductQuotation'] = implode(",", $_POST['retailerProductQuotation']);
                        } else {
                            $array_up['module_info']['retailerProductQuotation'] = '';
                        }
                        if (isset($_POST['subscribedProduct'])) {
                            $array_up['module_info']['subscribedProduct'] = implode(",", $_POST['subscribedProduct']);
                        } else {
                            $array_up['module_info']['subscribedProduct'] = '';
                        }



                        // Code Edited And Added By Kuldeep KD Bagwari   // Menu Permission
                        if (isset($_POST['users_menu_info'])) {
                            $array_up['menu_info']['users_menu_info'] = $_POST['users_menu_info'];
                        } else {
                            $array_up['menu_info']['users_menu_info'] = 'H';
                        }

                        if (isset($_POST['retailers_menu_info'])) {
                            $array_up['menu_info']['retailers_menu_info'] = $_POST['retailers_menu_info'];
                        } else {
                            $array_up['menu_info']['retailers_menu_info'] = 'H';
                        }

                        if (isset($_POST['brand_menu_info'])) {
                            $array_up['menu_info']['brand_menu_info'] = $_POST['brand_menu_info'];
                        } else {
                            $array_up['menu_info']['brand_menu_info'] = 'H';
                        }
                        //Users brand linesheet baseproduct pressrelease photogallery  orderiinfo
                        if (isset($_POST['linesheet_menu_info'])) {
                            $array_up['menu_info']['linesheet_menu_info'] = $_POST['linesheet_menu_info'];
                        } else {
                            $array_up['menu_info']['linesheet_menu_info'] = 'H';
                        }

                        if (isset($_POST['baseproduct_menu_info'])) {
                            $array_up['menu_info']['baseproduct_menu_info'] = $_POST['baseproduct_menu_info'];
                        } else {
                            $array_up['menu_info']['baseproduct_menu_info'] = 'H';
                        }

                        if (isset($_POST['pressrelease_menu_info'])) {
                            $array_up['menu_info']['pressrelease_menu_info'] = $_POST['pressrelease_menu_info'];
                        } else {
                            $array_up['menu_info']['pressrelease_menu_info'] = 'H';
                        }

                        if (isset($_POST['photogallery_menu_info'])) {
                            $array_up['menu_info']['photogallery_menu_info'] = $_POST['photogallery_menu_info'];
                        } else {
                            $array_up['menu_info']['photogallery_menu_info'] = 'H';
                        }

                        if (isset($_POST['orderinfo_menu_info'])) {
                            $array_up['menu_info']['orderinfo_menu_info'] = $_POST['orderinfo_menu_info'];
                        } else {
                            $array_up['menu_info']['orderinfo_menu_info'] = 'H';
                        }

                        if (isset($_POST['lookbook_menu_info'])) {
                            $array_up['menu_info']['lookbook_menu_info'] = $_POST['lookbook_menu_info'];
                        } else {
                            $array_up['menu_info']['lookbook_menu_info'] = 'H';
                        }

                        if (isset($_POST['category_menu_info'])) {
                            $array_up['menu_info']['category_menu_info'] = $_POST['category_menu_info'];
                        } else {
                            $array_up['menu_info']['category_menu_info'] = 'H';
                        }

                        if (isset($_POST['retailerrequest_menu_info'])) {
                            $array_up['menu_info']['retailerrequest_menu_info'] = $_POST['retailerrequest_menu_info'];
                        } else {
                            $array_up['menu_info']['retailerrequest_menu_info'] = 'H';
                        }
                        if (isset($_POST['retailerProductQuotation_menu_info'])) {
                            $array_up['menu_info']['retailerProductQuotation_menu_info'] = $_POST['retailerProductQuotation_menu_info'];
                        } else {
                            $array_up['menu_info']['retailerProductQuotation_menu_info'] = 'H';
                        }
                         if (isset($_POST['subscribedProduct_menu_info'])) {
                            $array_up['menu_info']['subscribedProduct_menu_info'] = $_POST['subscribedProduct_menu_info'];
                        } else {
                            $array_up['menu_info']['subscribedProduct_menu_info'] = 'H';
                        }

                        $permission_json = json_encode($array_up);
                       
                        Yii::app()->session['oldjson'] = json_encode(array());
                        Yii::app()->session['newjson'] = $permission_json;

                        $model->updateUsers($id, $permission_json);
                        Yii::app()->user->setFlash('error11', 'Created Successfully');

                        $this->redirect(array('update', 'id' => $model->id, 'confirm_password' => $confirm_password));
                        //return ;
                    }
                }
            }
        }
        $this->render('create', array(
            'model' => $model,
            'confirm_password' => $confirm_password,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {

        $confirm_password = '';
        if (substr_count(Yii::app()->session['premission_info']['module_info']['Users'], 'U') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }

        if (Yii::app()->session['checkPermission'] == '1') {
            $this->redirect(array('UsersController/update', 'id' => 1));
        }
        $model = $this->loadModel($id);

        Yii::app()->session['oldjson'] = $model->permission_info;


        if (isset(Yii::app()->session['premission_info']->module_info->Users) && strpos(Yii::app()->session['premission_info']->module_info->Users, 'U') == false) {

            Yii::app()->user->setFlash('error', 'You have Not Permission to Update');
        } else {
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if (isset($_POST['Users'])) {
                if (isset($_POST['confirm_password'])) {
                    $confirm_password = $_POST['confirm_password'];
                } else {
                    $confirm_password = $model->password;
                }
                if ($confirm_password != $model->password) {
                    Yii::app()->user->setFlash('error', 'Password does not match!');
                    $this->render('create', array('model' => $model, 'confirm_password' => $confirm_password));
                    exit();
                }

                $model->attributes = $_POST['Users'];
                if (strstr(Yii::app()->session['premission_info']['module_info']['Users'], 'U')) {


                    if ($model->save()) {
                       // if ((empty($_POST['Users']) && empty($_POST['brand']) && empty($_POST['linesheet']) && empty($_POST['photogallery']) && empty($_POST['orderinfo'])) || (empty($_POST['users_menu_info']) && empty($_POST['brand_menu_info']) && empty($_POST['lookbook']))) {
                      if ((empty($_POST['Users']) && empty($_POST['brand']) && empty($_POST['linesheet']) && empty($_POST['photogallery']) && empty($_POST['orderinfo']) && empty($_POST['retailerrequest']) && empty($_POST['retailers']) && empty($_POST['category']) && empty($_POST['baseproduct']) && empty($_POST['pressrelease']) && empty($_POST['lookbook'])) || (empty($_POST['users_menu_info']) && empty($_POST['brand_menu_info']) && empty($_POST['lookbook_menu_info']) && empty($_POST['orderinfo_menu_info']) && empty($_POST['photogallery_menu_info']) && empty($_POST['linesheet_menu_info']) && empty($_POST['baseproduct_menu_info']) && empty($_POST['pressrelease_menu_info']) && empty($_POST['retailerrequest_menu_info']) && empty($_POST['retailers_menu_info']) && empty($_POST['retailerProductQuotation_menu_info'])&& empty($_POST['subscribedProduct_menu_info']))) {
                            Yii::app()->user->setFlash('error', 'Atleast One module Should be Selected.');
                            $this->redirect(array('update', 'id' => $model->id, 'confirm_password' => $confirm_password));
                        }

                        if (isset($_POST['Users'])) {
                            $array_up['module_info']['Users'] = implode(",", $_POST['Users']);
                        } else {
                            $array_up['module_info']['Users'] = '';
                        }
                        if (isset($_POST['retailers'])) {
                            $array_up['module_info']['retailers'] = implode(",", $_POST['retailers']);
                        } else {
                            $array_up['module_info']['retailers'] = '';
                        }

                        if (isset($_POST['retailerrequest'])) {
                            $array_up['module_info']['retailerrequest'] = implode(",", $_POST['retailerrequest']);
                        } else {
                            $array_up['module_info']['retailerrequest'] = '';
                        }

                        if (isset($_POST['brand'])) {
                            $array_up['module_info']['brand'] = implode(",", $_POST['brand']);
                        } else {
                            $array_up['module_info']['brand'] = '';
                        }

                        if (isset($_POST['category'])) {
                            $array_up['module_info']['category'] = implode(",", $_POST['category']);
                        } else {
                            $array_up['module_info']['category'] = '';
                        }

                        if (isset($_POST['linesheet'])) {
                            $array_up['module_info']['linesheet'] = implode(",", $_POST['linesheet']);
                        } else {
                            $array_up['module_info']['linesheet'] = '';
                        }

                        if (isset($_POST['baseproduct'])) {
                            $array_up['module_info']['baseproduct'] = implode(",", $_POST['baseproduct']);
                        } else {
                            $array_up['module_info']['baseproduct'] = '';
                        }
                        if (isset($_POST['pressrelease'])) {
                            $array_up['module_info']['pressrelease'] = implode(",", $_POST['pressrelease']);
                        } else {
                            $array_up['module_info']['pressrelease'] = '';
                        }
                        if (isset($_POST['photogallery'])) {
                            $array_up['module_info']['photogallery'] = implode(",", $_POST['photogallery']);
                        } else {
                            $array_up['module_info']['photogallery'] = '';
                        }
                        if (isset($_POST['orderinfo'])) {
                            $array_up['module_info']['orderinfo'] = implode(",", $_POST['orderinfo']);
                        } else {
                            $array_up['module_info']['orderinfo'] = '';
                        }
                        if (isset($_POST['lookbook'])) {
                            $array_up['module_info']['lookbook'] = implode(",", $_POST['lookbook']);
                        } else {
                            $array_up['module_info']['lookbook'] = '';
                        }
                        if (isset($_POST['retailerProductQuotation'])) {
                            $array_up['module_info']['retailerProductQuotation'] = implode(",", $_POST['retailerProductQuotation']);
                        } else {
                            $array_up['module_info']['retailerProductQuotation'] = '';
                        }
                         if (isset($_POST['subscribedProduct'])) {
                            $array_up['module_info']['subscribedProduct'] = implode(",", $_POST['subscribedProduct']);
                        } else {
                            $array_up['module_info']['subscribedProduct'] = '';
                        }
                        



                        // Code Edited And Added By Kuldeep KD Bagwari   // Menu Permission 
                        if (isset($_POST['users_menu_info'])) {
                            $array_up['menu_info']['users_menu_info'] = $_POST['users_menu_info'];
                        } else {
                            $array_up['menu_info']['users_menu_info'] = 'H';
                        }

                        if (isset($_POST['retailers_menu_info'])) {

                            $array_up['menu_info']['retailers_menu_info'] = $_POST['retailers_menu_info'];
                        } else {
                            $array_up['menu_info']['retailers_menu_info'] = 'H';
                        }

                        if (isset($_POST['brand_menu_info'])) {
                            $array_up['menu_info']['brand_menu_info'] = $_POST['brand_menu_info'];
                        } else {
                           $array_up['menu_info']['brand_menu_info'] = 'H';
                        }

                        if (isset($_POST['linesheet_menu_info'])) {
                            $array_up['menu_info']['linesheet_menu_info'] = $_POST['linesheet_menu_info'];
                        } else {
                            $array_up['menu_info']['linesheet_menu_info'] = 'H';
                        }

                        if (isset($_POST['baseproduct_menu_info'])) {
                            $array_up['menu_info']['baseproduct_menu_info'] = $_POST['baseproduct_menu_info'];
                        } else {
                            $array_up['menu_info']['baseproduct_menu_info'] = 'H';
                        }

                        if (isset($_POST['pressrelease_menu_info'])) {
                            $array_up['menu_info']['pressrelease_menu_info'] = $_POST['pressrelease_menu_info'];
                        } else {
                            $array_up['menu_info']['pressrelease_menu_info'] = 'H';
                        }

                        if (isset($_POST['photogallery_menu_info'])) {
                            $array_up['menu_info']['photogallery_menu_info'] = $_POST['photogallery_menu_info'];
                        } else {
                            $array_up['menu_info']['photogallery_menu_info'] = 'H';
                        }

                        if (isset($_POST['orderinfo_menu_info'])) {
                            $array_up['menu_info']['orderinfo_menu_info'] = $_POST['orderinfo_menu_info'];
                        } else {
                            $array_up['menu_info']['orderinfo_menu_info'] = 'H';
                        }

                        if (isset($_POST['lookbook_menu_info'])) {
                            $array_up['menu_info']['lookbook_menu_info'] = $_POST['lookbook_menu_info'];
                        } else {
                            $array_up['menu_info']['lookbook_menu_info'] = 'H';
                        }

                        if (isset($_POST['category_menu_info'])) {
                            $array_up['menu_info']['category_menu_info'] = $_POST['category_menu_info'];
                        } else {
                            $array_up['menu_info']['category_menu_info'] = 'H';
                        }

                        // echo $_POST['retailerrequest_menu_info'];die; retailerProductQuotation
                        if (isset($_POST['retailerrequest_menu_info'])) {
                            $array_up['menu_info']['retailerrequest_menu_info'] = $_POST['retailerrequest_menu_info'];
                        } else {
                            $array_up['menu_info']['retailerrequest_menu_info'] = 'H';
                        }
                        if (isset($_POST['retailerProductQuotation_menu_info'])) {
                            $array_up['menu_info']['retailerProductQuotation_menu_info'] = $_POST['retailerProductQuotation_menu_info'];
                        } else {
                            $array_up['menu_info']['retailerProductQuotation_menu_info'] = 'H';
                        }
                         if (isset($_POST['subscribedProduct_menu_info'])) {
                            $array_up['menu_info']['subscribedProduct_menu_info'] = $_POST['subscribedProduct_menu_info'];
                        } else {
                            $array_up['menu_info']['subscribedProduct_menu_info'] = 'H';
                        }
                         $permission_json = json_encode($array_up);
                          //echo $permission_json;die;subscribedProduct_menu_info
                        Yii::app()->session['oldjson'] = Yii::app()->session['premission_info'];
                        Yii::app()->session['oldjson'] = $permission_json;

                        $model->updateUsers($id, $permission_json);
                        Yii::app()->user->setFlash('error11', 'Updated Successfully');
                        //  $this->redirect(array('update', 'model' => $model,));
                        //  Yii::app()->controller->refresh();
                        #.........................Start Update session...................#
                        if (Yii::app()->session['user_id'] == $model->id) {
                            $model = $this->loadModel($id);
                            $permission_info = json_decode($model->permission_info, true);
                            Yii::app()->session['last_json'] = $model->permission_info;
                            Yii::app()->session['premission_info'] = $permission_info;
                        }
                        #.........................Start Update session...................#
                    }
                } else {
                    Yii::app()->user->setFlash('permissio_error', 'You have no permission to update');
                }
            }
        }
        $this->render('update', array(
            'model' => $model, 'confirm_password' => $confirm_password,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if (strstr(Yii::app()->session['premission_info']['module_info']['Users'], 'D')) {
            Yii::app()->user->setFlash('error', 'You have Not Permission to Delete');
            $this->redirect(array('admin'));
        } else {
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {

        $dataProvider = new CActiveDataProvider('Users');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        if (substr_count(Yii::app()->session['premission_info']['module_info']['Users'], 'R') == 0) {
            Yii::app()->user->setFlash('permission_error', 'You have not permission to access');
            Yii::app()->controller->redirect("index.php?r=DashboardPage/index");
        }
        $model = new Users('search');
        if (isset(Yii::app()->session['premission_info']->module_info->Users) && (@strpos(Yii::app()->session['premission_info']->module_info->Users, 'R') == false)) {
            // if(false)
            Yii::app()->user->setFlash('error', 'You have Not Permission to Read');
            $this->redirect(array('site/index'));
        } else {
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Users']))
                $model->attributes = $_GET['Users'];

            $this->render('admin', array(
                'model' => $model,
            ));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Users the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Users::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Users $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ympdm-Users-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
