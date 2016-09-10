<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 9/9/16
 * Time: 2:26 PM
 */


?>

<div class="form">

    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'purchase-dropdown',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>


    <div <?php if($update != '') echo "style='display:none;'" ?> >
        <?php echo $form->labelEx($model, '<b>Select a retailer</b>'); ?>
        <?php
        $disabled = "";
        if($update != '') {
            $disabled = "disabled";
        }
        echo $form->dropDownList($model,
            'user_id',
            CHtml::listData(Retailer::model()->findAll(array('select'=>'id,name','order' => 'name')),'id','name'),
            array('empty' => 'Select a retailer', 'name' => 'retailer-dd', 'disabled'=>$disabled, 'options'=>array($retailerId=>array('selected'=>'selected')))
        );
        ?>

        <?php
        if($update == '') {
            echo CHtml::submitButton('Go', array('name' => 'select-vendor'));
        }?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->