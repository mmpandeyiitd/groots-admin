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
        $model->store_front_name => array('update', 'id' => $model->store_front_id, "store_id" => $store_id),
        'Update',
    );
} else {
    $store_id = $_GET['store_id'];
    if (Yii::app()->session['brand_id'] != $store_id) {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
    $this->breadcrumbs = array(
        'Linesheet' => array('admin', "store_id" => $store_id),
        $model->store_front_name => array('update', 'id' => $model->store_front_id, "store_id" => $store_id),
        'Update',
    );
}
?>        

<?php if (Yii::app()->user->hasFlash('error')): ?><div class="flash-error" style="color: red;"><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>
<div class="form">
    <?php
    $form = $this->beginWidget(
            'CActiveForm', array(
        'id' => 'upload-form',
        'focus' => '.error:first',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
            )
    );
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo CHtml::errorSummary($model); ?>

    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="flash-error label label-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>
    <?php //if(Yii::app()->session['is_super_admin']==1){  ?>
    <div class="">
        <div class="row">
            <?php //echo $form->labelEx($model, 'store_id');   ?>
            <?php
            //$opts = CHtml::listData(Store::model()->findAll(),'store_id','store_name');
            //echo $form->dropDownList($model,'store_id',$opts,array('empty'=>'select brand'),array('options' => array($model->store_id=>array('selected'=>true))));     
            ?>  
            <?php //echo $form->error($model, 'store_id');  ?>
        </div>
        <?php //}  ?>
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
            <?php //echo $form->labelEx($model, 'comment');   ?>
            <?php //echo $form->textField($model, 'comment', array('size' => 40, 'maxlength' => 255));  ?>
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
               
            
//            $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
//                'model' => $model,
//                'attribute' => 'start_date',
//                'options' => array(
//                    'dateFormat' => 'yy-mm-dd',
//                    'showAnim' => 'fold',
//                    'debug' => true,
//                    'minDate' => 0,
//                // 'id'=>'terwwe'
//                ), //DateTimePicker options
//                'htmlOptions' => array(),
//            ));
            ?>
            <?php echo $form->error($model, 'start_date'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'end_date'); ?>
            <?php
//            $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
//                'model' => $model,
//                'attribute' => 'end_date',
//                'options' => array(
//                    'showAnim' => 'slide',
//                    'dateFormat' => 'yy-mm-dd',
//                    //'showAnim' => 'fold',
//                    'debug' => true,
//                    'minDate' => 0,
//                     'hourGrid'=>2,
//                'minuteGrid'=>10,
//                // 'id'=>'tere'
//                ), //DateTimePicker options
//                'htmlOptions' => array(),
//                    // 'value'=>$model->end_date,
//            ));
            
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
            <?php echo $form->error($model, 'end_date');
            ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'Visibility'); ?>
            <!--  <?php echo $form->dropDownList($model, 'visibletoall', array("Select", "1" => "Yes", "0" => "No"), array('options' => array($model->visibletoall => array('selected' => true)))); ?>  
            <?php echo $form->error($model, 'visibletoall'); ?> -->
            <div class="check-awesome" style="float: left;">  
                <input type="checkbox" id="check-three" name="visibletoall"  value="1"
                <?php
                if ($model->visibletoall == 1) {
                    echo "checked";
                }
                ?> onclick="chech_checkbox();">  
                <label for="check-three">
                    <span class="check"></span>
                    <span class="box"></span>
                    Visible to all
                </label>
            </div>
            <div style=" clear:both;"></div>

            <?php $display = "inline";
            if ($model->visibletoall == 1) {
                $display = "none";
            } ?>
            <div class="list_retailercheck" id="check-div" style="display:<?php echo $display; ?>;">
                <h5>Select Retailers</h5>
                <?php
                $mapped_retailer = StoreFront::model()->getMappedRetailersbystorefront($model->store_front_id);
                $fileld_list = Retailer::model()->getRetailerNameId();
                //print_r($mapped_retailer);die;
                $selected_days = array();
                $base_array = array_keys($mapped_retailer);
                foreach ($base_array as $dy) {
                    $selected_days[$dy] = array('selected' => 'selected');
                }

                $retailer_model = new Retailer();
                $this->widget('ext.EchMultiSelect.EchMultiSelect', array(
                    'model' => $retailer_model,
                    'data' => $fileld_list,
                    'name' => 'retailerchecked[]',
                    'dropDownHtmlOptions' => array(
                        'style' => 'width:190px; height:100px;',
                        'multiple' => true,
                        'options' => $selected_days,
                    ),
                    'options' => array(
                        'selectedList' => 3,
                        'header' => true,
                        'filter' => true,
                        'header' => 'Select a Retailer',
                        'noneSelectedText' => 'Search Retailer',
                        'selectedText' => Yii::t('application', '# selected'),
                        'selectedList' => true,
                        'value' => array($mapped_retailer, 'id'),
                    ),
                ));
                ?>
                <input type="hidden" id="selected" value="<?php echo implode(',', $mapped_retailer) ?>"/>
            </div>

            <div style=" clear:both;"></div>
            <div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
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
