<?
class VendorUploadController extends Controller{

    public $layout = '//layouts/column2';

    public function filters(){
        return array(
          'accessControl',
        );
    }

    public function loadModel($id)
    {
        $model = Vendor::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vendor-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}