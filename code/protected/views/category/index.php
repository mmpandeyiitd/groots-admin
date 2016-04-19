<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Categories',
);
$visible_action_delete = FALSE;
if (array_key_exists('category', Yii::app()->session['premission_info']['module_info'])) {
       
    if (strstr(Yii::app()->session['premission_info']['module_info']['category'], 'D')) {
        $visible_action_delete = strstr(Yii::app()->session['premission_info']['module_info']['category'], 'D');
    } else {
        $visible_action_delete = FALSE;
    }
}

?>

<?php if (Yii::app()->user->hasFlash('error')): ?><div class="flash-error" style="color: red;"><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>
<div class="portlet" id="yw0" style=" margin: 20px;">

    <div class="portlet-content">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'category-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>

        <div class="span3 pull-right" >
            <?php $this->renderPartial('category_tree', array('category_id' => $category_id)); ?>
        </div>
        <div class="form tree_right bulk_center span8" style="margin-left:0; padding-left:0;">
            <?php if (Yii::app()->user->hasFlash('success')): ?><div class="flash-error label label-success" style="margin-left: 15px;"><?php echo Yii::app()->user->getFlash('success'); ?></div><?php endif; ?>
            <?php if (Yii::app()->user->hasFlash('error')): ?><div class="flash-error label label-important" style="margin-left: 15px;"  ><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>

            <?php if (!empty($model->path)): ?>
                <p class="note" style="margin-left: 15px;">Category Path : 
                    <?php
                    $pathIds = explode('/', $model->path);
                    if (count($pathIds) > 2) {
                        $catUrl = array();
                        for ($i = 2; $i < count($pathIds); $i++) {
                            $cat = $this->loadModel($pathIds[$i]);
                            if (!empty($cat->category_name)) {
                                $url = Yii::app()->controller->createUrl("category/index", array("category_id" => $cat->category_id));
                                $catUrl[] = "<a href='$url'>$cat->category_name($cat->category_id)</a>";
                            }
                        }
                        echo implode(' / ', $catUrl);
                    }
                    ?>
    <!--<a id='loglink'  href='index.php?r=category/export&id=<?php echo $category_id; ?>'> || Download Base_Prodouct</a>-->
                </p>
            <?php endif; ?>
            <p class="note" style="margin-left: 15px;">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($model); ?>

            <div class="">
                <?php echo $form->labelEx($model, 'category_name'); ?>
                <?php echo $form->textField($model, 'category_name', array('size' => 60, 'maxlength' => 255)); ?>
                <?php echo $form->error($model, 'category_name'); ?>
            </div>
            <div style="clear:both;"></div>

            <div class="">
                <?php echo $form->labelEx($model, 'category_shipping_charge'); ?>
                <?php echo $form->textField($model, 'category_shipping_charge', array('size' => 60, 'maxlength' => 255)); ?>
                <?php echo $form->error($model, 'category_shipping_charge'); ?>
            </div>

            <div style="clear:both;"></div>

            <div class="">
                <?php echo $form->labelEx($model, 'status'); ?>
                <?php echo $form->dropDownList($model, 'status', array('0' => 'Disable', '1' => 'Enable')); ?>       
                <?php echo $form->error($model, 'status'); ?>
            </div>
            <div style="clear:both;"></div>

            <div class="span12 caregory_btn">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update'); ?>
                <?php if($visible_action_delete){ echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Delete');} ?>
            </div>

        </div>
    </div>	

    <div class="row buttons">
    <?php /* echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); */ ?>
    </div>
</div>
        <?php $this->endWidget(); ?>

<script type="text/javascript">

    function resetFilter() {
        var url = '<?php echo Yii::app()->controller->createUrl("category/index", array("category_id" => $category_id)); ?>';
        window.location = url + '&reset=1';
    }


    function reloadCategory(cat) {


<?php if (Yii::app()->controller->action->id == 'index'): ?>
            var cat_id = cat.substring(cat.search('---') + 3, cat.length);
            var url = '<?php echo Yii::app()->controller->createUrl("category/index"); ?>';
            window.location = url + "&category_id=" + cat_id;
<?php endif; ?>
    }
</script>
<style type="text/css">
    .bulk_center {  border: 0;}
    .bulk_center select { width: 312px;}
    .caregory_btn { margin-left: 0px !important;}
    .caregory_btn input {     width: 140px;
                              float: left;
                              padding: 10px 30px;
                              border: 1px solid #324287;
                              color: #FFFFFF;
                              text-transform: uppercase;
                              border-radius: 4px !important;
                              background: #521042;
                              border-color: #521042 !important;
                              margin-right: 15px;}
</style>