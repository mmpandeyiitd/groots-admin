<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 17/9/16
 * Time: 12:28 PM
 */

?>

<?php
/*if(isset($update) && $update==true){
    $update=true;
}
else{
    $update = false;
}*/
$update = true;

function getIfExist($quantitiesMap, $key, $data){
    if(isset($quantitiesMap[$key][$data->base_product_id]))
        return $quantitiesMap[$key][$data->base_product_id];
    else
        return 0;
}

?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'inv-date',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model->errors); ?>

    <!--<div class="row" style="display: inline;">
        <?php /*echo $form->labelEx($model,'source_warehouse_id'); */?>
        <?php /*echo $form->dropDownList($model,
            'source_warehouse_id',
            CHtml::listData(Warehouse::model()->findAllByAttributes(array('status' => 1), array('select'=>'id,name', 'condition'=>'id !='.$w_id, 'order' => 'name')),'id','name'),
            array('empty' => 'Select a warehouse', 'options'=>array($model->source_warehouse_id=>array('selected'=>'selected')))
        );
        */?>
        <?php /*echo $form->error($model,'source_warehouse_id'); */?>
    </div>-->


    <div class="row">
        <?php echo $form->labelEx($model,'date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'attribute'=>'date',
            'id'=>'date',
            //'value'=> date('Y-m-d'),
            'options'=>array(
                'dateFormat' => 'yy-mm-dd',
                'showAnim'=>'fold',
            ),
            'htmlOptions'=>array(
                'style'=>'height:20px;'
            ),
        )); ?>
        <?php echo $form->error($model,'date'); ?>

            <?php

                echo CHtml::submitButton('submit', array('name'=>'inventory-date'));

            ?>

    </div>
    <?php $this->endWidget(); ?>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'purchase-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>
    <!--<div class="row">
        <?php /*echo $form->labelEx($model,'end_date'); */?>
        <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'attribute'=>'end_date',

            'id'=>'end_date',
            //'value'=> date('Y-m-d'),
            'options'=>array(
                'dateFormat' => 'yy-mm-dd',
                'showAnim'=>'fold',
            ),
            'htmlOptions'=>array(
                'style'=>'height:20px;'
            ),
        )); */?>
        <?php /*echo $form->error($model,'end_date'); */?>
    </div>-->


    <!--<div class="row">
        <?php /*echo $form->labelEx($model,'status'); */?>
        <?php /*echo $form->dropDownList($model,'status',
            CHtml::listData(TransferHeader::status(),'value', 'value'));

        */?>
        <?php /*echo $form->error($model,'status'); */?>
    </div>

    <div class="row">
        <?php /*echo $form->label($model,'comment'); */?>
        <?php /*echo $form->textArea($model,'comment', array('cols'=>200, 'rows'=>4, 'style'=>'width:400px;')); */?>
        <?php /*echo $form->error($model,'comment'); */?>
    </div>-->
    <!--<div>
        <?php
    /*        echo CHtml::button("Add Items for Purchase", array("onclick" => "showAddItemBox()"));
            */?>
    </div>
    <div id="alpha-nav-div" style="display:none;">
        <ul id="alphabetical-nav" style="list-style: none;">
            <?php /*foreach ($otherItems as $item){
                */?>
                <li style="" >

                    <?php /*echo CHtml::CheckBox('cb_'.$item['bp_id'],'', array (
                        'value'=>'on',
                        'class'=>'cb_item',
                        'id' => 'cb_'.$item['bp_id'],
                    )); */?>

                    <span class="title" id="title_<?php /*echo $item['bp_id']; */?>"><?php /*echo $item['title']; */?><span>

                </li>
                <?php
    /*            }
                */?>

        </ul>
        <?php
    /*        echo CHtml::button("Add", array("onclick" => "addItemToOrder()"));
            */?>
    </div>-->

    <?php

    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'purchase-header-grid',
        'itemsCssClass' => 'table table-striped table-bordered table-hover',
        'dataProvider'=>$dataProvider,
        'filter'=>$model,
        'columns'=>array(
            array(
                'header' => 'id',
                'name' => 'base_product_id[]',
                'value' => function ($data) {
                    return CHtml::textField('base_product_id[]', $data->base_product_id, array('class'=>'id-field', 'readonly'=>'readonly'));
                },
                'type' => 'raw',
            ),
            array(
                'header' => 'date',
                'name' => 'date',
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'value' => function ($data) {
                    return CHtml::textField('date[]', $data->date, array('class'=>'id-field', 'readonly'=>'readonly'));
                },
                'type' => 'raw',
            ),
            array(
                'header' => 'title',
                'name' => 'item_title',
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;'),
                'value' => '$data->BaseProduct->title',
                /*'value' => function ($data) {
                    return CHtml::label($data->BaseProduct->title, $data->BaseProduct->title,array('class'=>'title'));
                },*/
                'type' => 'raw',
            ),
            array(
                'header' => 'Schd Inv',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;'),
                'value' => function ($data) use ($quantitiesMap) {
                    $sch_inv_kg = '';
                    if($data->base_product_id == 264){
                        //echo $data->InvHeader->schedule_inv;
                        //echo "bpid-".$quantitiesMap['avgOrder'][$data->base_product_id];die;
                    }
                    if (isset($quantitiesMap['avgOrder'][$data->base_product_id]) && isset($data->InvHeader->schedule_inv)){
                        $sch_inv = $quantitiesMap['avgOrder'][$data->base_product_id];
                        $sch_inv_type = $data->InvHeader->schedule_inv_type;
                        $sch_inv_no = $data->InvHeader->schedule_inv;
                        $avgOrderInKg = Utility::convertOrderToKg($sch_inv['qty'], $sch_inv['pack_size'], $sch_inv['pack_unit']);

                        if($sch_inv_type == 'days'){
                            $sch_inv_kg = $sch_inv_no * $avgOrderInKg;
                        }
                        elseif($sch_inv_type == 'percents'){
                            $sch_inv_kg = $sch_inv_no * $avgOrderInKg/100;
                        }

                    }
                    $data->schedule_inv = $sch_inv_kg;
                    if(empty($data->schedule_inv)){
                        $data->schedule_inv=0;
                    }
                    return CHtml::textField('schedule_inv[]', $data->schedule_inv, array('class'=>'inv-input id-field', 'id'=>'sch-inv_'.$data->base_product_id, 'readonly'=>'readonly'));
                },
            ),

            array(
                'header' => 'Prev Day Inv',
                'type' => 'raw',
                'class'=>'DataColumn',
                'evaluateHtmlOptions'=>true,
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;', 'id'=> '"prev-day-inv_{$data->base_product_id}"'),
                'value'=>function($data) use ($quantitiesMap){
                    if(isset($quantitiesMap['prevDayInv'][$data->base_product_id]))
                        return $quantitiesMap['prevDayInv'][$data->base_product_id];
                    else
                        return 0;
                },
            ),
            array(
                'header' => 'order_qty',
                'type' => 'raw',
                'class'=>'DataColumn',
                'evaluateHtmlOptions'=>true,
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;', 'id'=> '"order_{$data->base_product_id}"'),
                //'cssClassExpression' => '$data->base_product_id',
                'value'=>function($data) use ($quantitiesMap){
                    if(isset($quantitiesMap['orderSum'][$data->base_product_id]))
                        return $quantitiesMap['orderSum'][$data->base_product_id];
                    else
                        return 0;
                },
            ),
            array(
                'header' => 'transferIn_qty',
                'type' => 'raw',
                'class'=>'DataColumn',
                'evaluateHtmlOptions'=>true,
                'headerHtmlOptions' => array('style' => 'width:10%;' ),
                'htmlOptions' => array('style' => 'width:10%;', 'id'=> '"transferIn_{$data->base_product_id}"'),
                'value'=>function($data) use ($quantitiesMap){
                    if(isset($quantitiesMap['transferInSum'][$data->base_product_id]))
                        return $quantitiesMap['transferInSum'][$data->base_product_id];
                    else
                        return 0;
                },
            ),
            array(
                'header' => 'transferOut_qty',
                'type' => 'raw',
                'class'=>'DataColumn',
                'evaluateHtmlOptions'=>true,
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;', 'id'=> '"transferOut_{$data->base_product_id}"'),
                'value'=>function($data) use ($quantitiesMap){
                    if(isset($quantitiesMap['transferOutSum'][$data->base_product_id]))
                        return $quantitiesMap['transferOutSum'][$data->base_product_id];
                    else
                        return 0;
                },
            ),
            array(
                'header' => 'purchase_qty',
                'type' => 'raw',
                'class'=>'DataColumn',
                'evaluateHtmlOptions'=>true,
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;', 'id'=> '"purchase_{$data->base_product_id}"'),
                'value'=>function($data) use ($quantitiesMap){
                    if(isset($quantitiesMap['purchaseSum'][$data->base_product_id]))
                        return $quantitiesMap['purchaseSum'][$data->base_product_id];
                    else
                        return 0;
                },
            ),
            array(
                'header' => 'Extra Inv',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;', ),
                'value' => function ($data) use ($quantitiesMap) {
                    $s_inv = $data->schedule_inv;
                    $cur_inv = $data->present_inv;
                    $order_sum = getIfExist($quantitiesMap,'orderSum', $data);
                    $transfer_out = getIfExist($quantitiesMap,'transferOutSum', $data);
                    $extra_inv =$data->InvHeader->extra_inv * ($order_sum-$cur_inv+$transfer_out+$s_inv)/100;
                    $data->extra_inv = $extra_inv;
                    return CHtml::textField('extra_inv[]', $data->extra_inv, array('class'=>'inv-input id-field', 'id'=>'extra-inv_'.$data->base_product_id, 'readonly'=>'readonly' ));
                },
            ),
            array(
                'header' => 'Curr Inv',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;'),
                'value' => function ($data) {
                    return CHtml::textField('present_inv[]', $data->present_inv, array('class'=>'inv-input', 'id'=>'pres-inv_'.$data->base_product_id,  'onchange'=>'onInvChange('.$data->base_product_id.')'));
                },
            ),
            array(
                'header' => 'wastage',
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;', ),
                'value' => function ($data) {
                    return CHtml::textField('wastage[]', $data->wastage, array('class'=>'inv-input', 'id'=>'wastage_'.$data->base_product_id, 'onchange'=>'onInvChange('.$data->base_product_id.')'));
                },
                'type' => 'raw',
            ),
            array(
                'header' => 'wastage_others',
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;', ),
                'value' => function ($data) {
                    return CHtml::textField('wastage_others[]', $data->wastage_others, array('class'=>'inv-input', 'id'=>'wastage-others_'.$data->base_product_id, 'onchange'=>'onInvChange('.$data->base_product_id.')'));
                },
                'type' => 'raw',
            ),
            array(
                'header' => 'balance',
                'class'=>'DataColumn',
                'evaluateHtmlOptions'=>true,
                'headerHtmlOptions' => array('style' => 'width:40%;'),
                'htmlOptions' => array('style' => 'width:40%;', 'id'=> '"balance_{$data->base_product_id}"'),
                'value' => function ($data)  use ($quantitiesMap) {

                    $s_inv = $data->schedule_inv;
                    $cur_inv = $data->present_inv;
                    $order_sum = getIfExist($quantitiesMap,'orderSum', $data);
                    $purchase = getIfExist($quantitiesMap,'purchaseSum', $data);
                    $trans_in = getIfExist($quantitiesMap,'transferInSum', $data);
                    $trans_out = getIfExist($quantitiesMap,'transferOutSum', $data);

                    $extra_inv = $data->extra_inv;
                    $wastage = $data->wastage;
                    $balance = $s_inv-$cur_inv+$order_sum+$trans_out+$extra_inv+$wastage-$purchase-$trans_in;
                    return CHtml::label($balance, $data->balance,array('class'=>'title', 'id'=>'balance_'.$data->base_product_id,));
                },
                'type' => 'raw',
            ),
            array(
                'name' => 'inv_id',
                'type'=> 'raw',
                'headerHtmlOptions'=>array('style'=>'width:0%; display:none'),
                'filterHtmlOptions'=>array('style'=>'width:0%; display:none'),
                'htmlOptions'=>array('style'=>'width:0%; display:none'),
                'value' => function ($data) {
                    return CHtml::textField('inv_hd_id[]', $data->InvHeader->id);
                },
            ),
        ),
    ));


    ?>

    <!--<div class="order_bottomdetails" align="right">
        <?php /*echo $form->labelEx($model,'total_payable_amount'); */?>
        <?php /*echo $form->textField($model,'total_payable_amount',array('size'=>60,'maxlength'=>255, 'id'=>'sumAmount')); */?>
        <?php /*echo $form->error($model,'total_payable_amount'); */?>
    </div>-->
    <?php /*echo $form->hiddenField($model,'warehouse_id', array('value' => $w_id)); */?><!--
    <?php /*echo $form->hiddenField($model,'inv_id', array('value' => $w_id)); */?>
    --><?php /*echo $form->hiddenField($model,'created_at'); */?>


    <div class="row buttons">
        <?php
        if($update==true){
            echo CHtml::submitButton('Update', array('name'=>'inventory-update'));
        }
        else{
            echo CHtml::submitButton('Create', array('name'=>'inventory-create'));
        }
        ?>


        <a href="index.php?r=transferHeader/admin&w_id=<?php echo $w_id;?>" class="button_new" style="width: auto;" target="_blank"  >Back</a>

    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->


<script type="text/javascript">

    $(document).ready(function() {
    });

    function onInvChange(bp_id){
        console.log('bp-id '+ bp_id);
        var wastage = parseFloat($("#wastage_"+bp_id).val().trim());
        var presInv = parseFloat($("#pres-inv_"+bp_id).val().trim());
        var schInv = parseFloat($("#sch-inv_"+bp_id).val().trim());
        if(schInv!=null){
            schInv=0;
        }
        var extraInv = parseFloat($("#extra-inv_"+bp_id).val().trim());
        var order = parseFloat($("#order_"+bp_id).html().trim());

        /*$('.order_'+bp_id).each(function () {
            console.log
            order = $(this).html().trim;
        });*/
        var tranferOut = parseFloat($("#transferOut_"+bp_id).html().trim());
        var transferIn = parseFloat($("#transferIn_"+bp_id).html().trim());
        var purchase = parseFloat($("#purchase_"+bp_id).html().trim());
        var balance = 0;
        balance = schInv+order+tranferOut+wastage+extraInv-transferIn-presInv-purchase;
        console.log('sch '+schInv);
        console.log('presInv '+presInv);
        console.log('wastage '+wastage);
        console.log('extraInv '+extraInv);
        console.log('order '+order);
        console.log('tranferOut '+tranferOut);
        console.log('transferIn '+transferIn);
        console.log('purchase '+purchase);
        console.log('balance '+balance);
        $("#balance_"+bp_id).html(balance);
    }


</script>

