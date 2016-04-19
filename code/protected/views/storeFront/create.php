<?php
/* @var $this StoreController */
/* @var $model Store */
$issuperadmin = Yii::app()->session['is_super_admin'];
if ($issuperadmin == 1) {

    if (!(isset($_GET['store_id'])) || (empty($_GET['store_id']))) {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
    $store_id = $_GET['store_id'];

    if (Yii::app()->session['brand_admin_id'] != $store_id) {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
    $store_name = Store::model()->getstore_nameByid($store_id);
    $this->breadcrumbs = array(
        'Brand' => array('store/admin'),
        $store_name => array('store/update', "id" => $store_id),
        'Linesheet' => array('admin', 'store_id' => $store_id),
        'create',
    );
} else {
    if (!(isset($_GET['store_id'])) || (empty($_GET['store_id']))) {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
    $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_id'] != $store_id) {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
    $this->breadcrumbs = array(
        'Linesheet' => array('admin', 'store_id' => $store_id),
        'create',
    );
}
?>

<div class="" id="yw0">


    <div class="portlet-content">


        <div class="form">

            <?php
            $form = $this->beginWidget(
                    'CActiveForm', array(
                'id' => 'storefront-form',
                'focus' => '.error:first',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                    )
            );
            ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo CHtml::errorSummary($model); ?>
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="Csv" style="color:green;">
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php endif; ?>

            <div class="">
                <div class="row">
                    <?php echo $form->labelEx($model, 'store_front_name'); ?>
                    <?php echo $form->textField($model, 'store_front_name', array('size' => 40, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'store_front_name'); ?>
                </div>
                <div class="row">
                    <?php echo $form->labelEx($model, 'season'); ?>
                    <?php echo $form->textField($model, 'season', array('size' => 40, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'season'); ?>
                </div>
                <div class="row">
                    <?php //echo $form->labelEx($model, 'comment');  ?>
                    <?php //echo $form->textArea($model, 'comment', array('size' => 60, 'maxlength' => 555)); ?>
                    <?php //echo $form->error($model, 'comment'); ?>
                </div>
            </div>
            <div class="">

                <div class="row">
                    <?php echo $form->labelEx($model, 'start_date'); ?>
                    <?php
                    
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    // 'name' => 'order_placement_cut_off_date',
                    'attribute' => 'start_date',
                    // 'flat' => false, //remove to hide the datepicker
                    'options' => array(
                        'showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                        'minDate' => 0,
                        'dateFormat' => 'dd/mm/yy',
                    ),
                    'htmlOptions' => array(
                        'style' => ''
                    ),
                ));
                    
//                    $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
//                        'model' => $model,
//                        'attribute' => 'start_date',
//                        'options' => array(
//                            'dateFormat' => 'yy-mm-dd',
//                            'showAnim' => 'fold',
//                            'debug' => true,
//                           // 'minDate' => 0,
//                        ), //DateTimePicker options
//                        'htmlOptions' => array(),
//                    ));
                    ?>
                    <?php echo $form->error($model, 'start_date'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model, 'end_date'); ?>
                    <?php
//                    $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
//                        'model' => $model,
//                        'attribute' => 'end_date',
//                        'options' => array(
//                            'dateFormat' => 'yy-mm-dd',
//                            'showAnim' => 'fold',
//                            'debug' => true,
//                            'minDate' => 0,
//                        ), //DateTimePicker options
//                        'htmlOptions' => array(),
//                    ));
                    
                    
                     
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    // 'name' => 'order_placement_cut_off_date',
                    'attribute' => 'end_date',
                    // 'flat' => false, //remove to hide the datepicker
                    'options' => array(
                        'showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                        'minDate' => 0,
                        'dateFormat' => 'dd/mm/yy',
                    ),
                    'htmlOptions' => array(
                        'style' => ''
                    ),
                ));
                    
                    ?>
                    <?php echo $form->error($model, 'end_date'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model, 'Visibility'); ?>
                    <?php //echo $form->dropDownList($model, 'visibletoall', array("Select","1" => "Yes","0" => "No"),array('options' => array($model->visibletoall=>array('selected'=>true))));?>
                    <?php echo $form->error($model, 'visibletoall'); ?>

                    <div class="check-awesome" style="float: left;">
                        <input name="visibletoall" type="checkbox" id="check-three" onclick="chech_checkbox();" value="1" checked>
                        <label for="check-three">
                            <span class="check"></span>
                            <span class="box"></span>
                            Visible to all
                        </label>
                    </div>

                    <div style=" clear:both;"></div>

                    <div class="list_retailercheck"  id="check-div" style="display:none;" >
                        <h5>Select Retailers</h5>

                        <?php
                        $fileld_list = Retailer::model()->getRetailerNameId();
                        $retailer_model = new Retailer();
                        if (!empty($fileld_list) && !empty($retailer_model)) {
                            
                        } else {
                            $fileld_list = array();
                            $retailer_model = array();
                        }

                        $this->widget('ext.EchMultiSelect.EchMultiSelect', array(
                            'model' => $retailer_model,
                            'data' => $fileld_list,
                            'name' => 'retailerchecked[]',
                            'dropDownHtmlOptions' => array(
                                'style' => 'width:190px; height:300px;',
                                'multiple' => true,
                            ),
                            'options' => array(
                                'selectedList' => 3,
                                'filter' => true,
                                'header' => 'Select a Retailer', 'noneSelectedText' => 'file',
                            ),
                        ));
                        ?>
                        <?php
                        //$retailer=Retailer::model()->findAllByAttributes(array('status'=>1));
                        // $maxrecord= count($retailer);
                        // for($i=0;$i<$maxrecord;$i++){
                        ?>
<!--                <li><input name="retailerchecked[]" value="<?php //echo $retailer[$i]['id'];    ?>" type="checkbox"> <?php //echo $retailer[$i]['name']    ?></li>
   <li><input type="checkbox"> Check me out</li>
    <li><input type="checkbox"> Check me out</li>
    <li><input type="checkbox"> Check me out</li>
    <li><input type="checkbox"> Check me out</li>
    <li><input type="checkbox"> Check me out</li>
                        -->
                        <?php //}?>

                    </div>
                </div>

                <?php $pdfPath = CHtml::resolveValue($model, 'pdf'); ?>

                <div class="row">
                    <?php //echo $form->labelEx($model, 'pdf'); ?>
                    <?php //echo CHtml::image(STORE_LOGO_PATH."$model->pdf","$model->pdf",array('width'=>100,'height'=>100));?>
                    <?php //echo $form->fileField($model, 'pdf'); ?>
                    <?php //echo $form->error($model, 'pdf'); ?>
                </div>
                <?php //$imagePath = CHtml::resolveValue($model, 'image'); ?>

                <div class="row">
                    <?php //echo $form->labelEx($model, 'image'); ?>
                    <?php //echo CHtml::image(LINESHEET_PATH . "$model->image", "$model->image", array('width' => 100, 'height' => 100)); ?>
                    <?php //echo $form->fileField($model, 'image'); ?>
                    <?php //echo $form->error($model, 'image'); ?>
                    <div class="span12 buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<script >
    function chech_checkbox() {

        if (document.getElementById("check-three").checked) {

            document.getElementById("check-div").style.display = "none";
        } else {
            document.getElementById("check-div").style.display = "inline";
        }
    }
</script>

