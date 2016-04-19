<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'registration-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));

$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 1) {
    if (!(isset($_GET['store_id'])) || (empty($_GET['store_id']))) {
        $this->redirect(array('site/logout'));
    }
    $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_admin_id'] != $store_id) {
        $this->redirect(array('site/logout'));
    }
    $store_name = Store::model()->getstore_nameByid($store_id);
    $this->breadcrumbs = array(
        'Brand' => array('store/admin'),
        $store_name => array('store/update', "id" => $store_id),
        'Style' => array('admin', "store_id" => $store_id),
        'Bulk Upload Styles',
    );
} else {
    $store_id = Yii::app()->session['brand_id'];
    $this->breadcrumbs = array(
        'Styles' => array('admin'),
        'Bulk Upload Media',
    );
}


$this->menu = array(
        //array('label' => 'Manage Style', 'url' => array('baseProduct/admin', "store_id" => $store_id)),
);
?>

<div class="bulk_center" >

    <div class="portlet-content">

        <div >


            <div >
                <b>*Make folder "zips" and put images</b><br/>
                <b>*then compress folder</b><br/>
                <b>*Upload zip File only</b><br/>
                <b>*Upload zip File must be less than 30 MB </b><br/>
                <input id="media_zip_file" name="media_zip_file" type="file"/>
            </div>
            <div class="buttons">
                <?php echo CHtml::submitButton('Upload', array("class" => "Bulk btn")); ?>
            </div>
            <div class="Csv">
                <?php echo '<br />'; ?>
                <?php if (Yii::app()->user->hasFlash('success')): ?>
                    <div class="Csv" style="color:green">
                        <?php echo Yii::app()->user->getFlash('success'); ?>
                    </div>
                <?php endif; ?>
                <?php if (Yii::app()->user->hasFlash('error')): ?>
                    <div class="Csv" style="color:red">
                        <?php echo Yii::app()->user->getFlash('error'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->endWidget();
?>