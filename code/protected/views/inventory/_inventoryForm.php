<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 14/9/16
 * Time: 9:11 AM
 */

?>

<?php
if(isset($update) && $update==true){
    $update=true;
}
else{
    $update = false;
}
$showSubmit = true;
if($model->date < date('Y-m-d')){
    $showSubmit = false;
}
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

    <!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->
-
    <?php echo $form->errorSummary($model->errors); ?>



    <div class="row">
        <?php echo $form->labelEx($model,'date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'attribute'=>'date',
            'value'=>$model->date,

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

    <div class = "row" style="float:right">
    <?php 
    $url = Yii::app()->controller->createUrl("Inventory/downloadWastageReport",array('w_id' => $w_id));
    echo CHtml::button('Download Report', array('onclick' => "onClickDownloadReport('".$url."')")); 
    ?>
    </div>

    <?php $this->endWidget();
$balance = 0;

    if(!$editOnly){
        $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'inv-grid',
            'itemsCssClass' => 'table table-striped table-bordered table-hover',
            'dataProvider'=>$totalInvData,
            'columns'=>array(

                array(
                    'header' => 'Schd Inv',
                    'name' => 'schedule_inv',
                    'headerHtmlOptions' => array('style' => 'width:15%;'),
                    'htmlOptions' => array('style' => 'width:15%;'),
                    'value' => 'round($data["schedule_inv"], 2)',
                    'type' => 'raw',
                ),
                array(
                    'header' => 'Prev Day Inv',
                    'name' => 'prev_day_inv',
                    'headerHtmlOptions' => array('style' => 'width:15%;'),
                    'htmlOptions' => array('style' => 'width:15%;'),
                    'value' => 'round($data["prev_day_inv"], 2)',
                    'type' => 'raw',
                ),
                array(
                    'header' => 'Purchase(+)',
                    'name' => 'total_order',
                    'headerHtmlOptions' => array('style' => 'width:15%;'),
                    'htmlOptions' => array('style' => 'width:15%;'),
                    'value' => function ($data) use ($quantitiesMap) {
                        return round($quantitiesMap['totalPurchase'], 2);
                    },
                    'type' => 'raw',
                ),
                array(
                    'header' => 'Transfer-In(+)',
                    'name' => 'total_order',
                    'headerHtmlOptions' => array('style' => 'width:15%;'),
                    'htmlOptions' => array('style' => 'width:15%;'),
                    'value' => function ($data) use ($quantitiesMap) {
                        return round($quantitiesMap['totalTransferIn'], 2);
                    },
                    'type' => 'raw',
                ),
                array(
                    'header' => 'Order(-)',
                    'name' => 'total_order',
                    'headerHtmlOptions' => array('style' => 'width:15%;'),
                    'htmlOptions' => array('style' => 'width:15%;'),
                    'value' => function ($data) use ($quantitiesMap) {
                        return round($quantitiesMap['totalOrder'], 2);
                    },
                    'type' => 'raw',
                ),

                array(
                    'header' => 'Transfer-Out(-)',
                    'name' => 'total_order',
                    'headerHtmlOptions' => array('style' => 'width:15%;'),
                    'htmlOptions' => array('style' => 'width:15%;'),
                    'value' => function ($data) use ($quantitiesMap) {
                        return round($quantitiesMap['totalTransferOut'], 2);
                    },
                    'type' => 'raw',
                ),
                array(
                    'header' => 'Order Inv(-)',
                    'name' => 'present_inv',
                    'headerHtmlOptions' => array('style' => 'width:15%;'),
                    'htmlOptions' => array('style' => 'width:15%;'),
                    'value' => function ($data) {
                        return round($data['present_inv'], 2);
                    },
                    'type' => 'raw',
                ),
                array(
                    'header' => 'Liquid Inv(-)',
                    'name' => 'liquid_inv',
                    'headerHtmlOptions' => array('style' => 'width:15%;'),
                    'htmlOptions' => array('style' => 'width:15%;'),
                    'value' => function ($data) {
                        return round($data['liquid_inv'], 2);
                    },
                    'type' => 'raw',
                ),
                array(
                    'header' => 'Liquid wastage(-)',
                    'name' => 'liquid_wastage',
                    'headerHtmlOptions' => array('style' => 'width:15%;'),
                    'htmlOptions' => array('style' => 'width:15%;'),
                    'value' => function ($data)  {
                        return round($data['liquidation_wastage'], 2);
                    },
                    'type' => 'raw',
                ),
                array(
                    'header' => 'Wastage(-)',
                    'name' => 'wastage',
                    'headerHtmlOptions' => array('style' => 'width:15%;'),
                    'htmlOptions' => array('style' => 'width:15%;'),
                    'value' => function ($data)  {
                        return round($data['wastage'], 2);
                    },
                    'type' => 'raw',
                ),
                array(
                    'header' => 'Balance',
                    'name' => 'balance',
                    'headerHtmlOptions' => array('style' => 'width:15%;'),
                    'htmlOptions' => array('style' => 'width:15%;'),
                    'value' => function ($data) use ($quantitiesMap) {
                        $balance = $quantitiesMap['totalPurchase'] +  $quantitiesMap['totalTransferIn'] - $quantitiesMap['totalOrder'] - $quantitiesMap['totalTransferOut'] - $data['present_inv'] - $data['liquid_inv'] - $data['liquidation_wastage'] - $data['wastage'];
                        return round($balance, 2);
                    },
                    'type' => 'raw',
                ),

            ),
        ));
    }

    ?>



    <?php
     $form=$this->beginWidget('CActiveForm', array(
        'id'=>'purchase-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    ));



    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'warehouse-item-grid',
        'itemsCssClass' => 'table table-striped table-bordered table-hover',

        'rowCssClassExpression' => '$data->getCssClass()',

        'rowHtmlOptionsExpression' => 'array("id" => "bp_".$data->base_product_id)',
        'afterAjaxUpdate' => 'onStartUp',
        'dataProvider'=>$dataProvider,
        'filter'=>$model,
        'columns'=>array(
            array(
                'header' => 'show child',
                /*'headerHtmlOptions' => array('style' => 'width:15%;'),*/
                'htmlOptions' => array('style' => 'width:15%;', 'class' => 'expand-bt'),
                'value' => function($data){

                    if(isset($data->parent_id) && $data->parent_id == 0){
                        return CHtml::button("+",array("onclick"=> "toggleChild(".$data->base_product_id.")" ));
                    }
                    else{
                        return "";
                    }
                        
                },
                'type' => 'raw',
            ),
            array(
                'header' => 'id',
                'name' => 'base_product_id[]',
                'value' => function ($data) {
                    return CHtml::textField('base_product_id[]', $data->base_product_id, array('class'=>'id-field readOnlyInput', 'readonly'=>'readonly', 'id'=>'base-product-id_'.$data->base_product_id));
                },
                'type' => 'raw',
            ),
            /*array(
                'header' => 'date',
                'name' => 'date',
                'value' => function ($data) {
                    return CHtml::textField('date[]', substr($data->date,5), array('class'=>'id-field', 'readonly'=>'readonly'));
                },
                'type' => 'raw',
            ),*/
            array(
                'header' => 'Grade',
                'name' => 'grade',
                'headerHtmlOptions' => array(),
                'htmlOptions' => array('style' => 'width:40%;', 'id' => 'grade'),
                'value' => '$data->grade',
            ),

            array(
                'header' => 'Title',
                'name' => 'item_title',
                'headerHtmlOptions' => array('style' => 'width:40%;'),
                'htmlOptions' => array('style' => 'width:40%;', 'id' => 'title'),
                'value' => '$data->item_title',

                /*'value' => function ($data) {
                    return CHtml::label($data->BaseProduct->title, $data->BaseProduct->title,array('class'=>'title'));
                },*/
                'type' => 'raw',
            ),
            array(
                'header' => 'Schd Inv()',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;'),
                //'visible' => !$editOnly,
                'value' => function ($data) use ($quantitiesMap) {
                    $sch_inv_kg = 0;
                    if (isset($quantitiesMap['avgOrder'][$data->base_product_id]) && isset($data->schedule_inv)){
                        $avgOrderInKg = $quantitiesMap['avgOrder'][$data->base_product_id];
                        $sch_inv_type = $data->schedule_inv_type;
                        $sch_inv_no = $data->schedule_inv;
                        if($sch_inv_type == 'days'){
                            $sch_inv_kg = $sch_inv_no * $avgOrderInKg;
                        }
                        elseif($sch_inv_type == 'percents'){
                            $sch_inv_kg = $sch_inv_no * $avgOrderInKg/100;
                        }

                    }
                    $data->schedule_inv_absolute = $sch_inv_kg;
                    return CHtml::textField('schedule_inv[]', $data->schedule_inv_absolute, array('class'=>'inv-input id-field readOnlyInput', 'id'=>'sch-inv_'.$data->base_product_id,'readonly'=>'readonly'));
                },
            ),

            array(
                'header' => 'Prev Day Inv()',
                'type' => 'raw',
                'class'=>'DataColumn',
                'evaluateHtmlOptions'=>true,
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;', 'id'=> '"prev-day-inv_{$data->base_product_id}"'),
                'visible' => !$editOnly,
                'value'=>function($data) use ($quantitiesMap){
                    /*if(isset($quantitiesMap['prevDayInv'][$data->base_product_id])){
                        $data->prev_day_inv = $quantitiesMap['prevDayInv'][$data->base_product_id];
                    }
                    else{
                        $data->prev_day_inv = 0;
                    }*/
                    $data->prev_day_inv = empty($quantitiesMap['prevDayInv'][$data->base_product_id]) ? 0 : $quantitiesMap['prevDayInv'][$data->base_product_id];
                    return $data->prev_day_inv;
                },
            ),
            array(
                'header' => 'Purchase(+)',
                'type' => 'raw',
                'class'=>'DataColumn',
                'evaluateHtmlOptions'=>true,
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;', 'id'=> '"purchase_{$data->base_product_id}"'),
                'visible' => !$editOnly,
                'value'=>function($data) use ($quantitiesMap){
                    if(isset($quantitiesMap['purchaseSum'][$data->base_product_id]))
                        return $quantitiesMap['purchaseSum'][$data->base_product_id];
                    else
                        return 0;
                },
            ),
            array(
                'header' => 'Transfer-In(+)',
                'type' => 'raw',
                'class'=>'DataColumn',
                'evaluateHtmlOptions'=>true,
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;', 'id'=> '"transferIn_{$data->base_product_id}"'),
                'visible' => !$editOnly,
                'value'=>function($data) use ($quantitiesMap){
                    if(isset($quantitiesMap['transferInSum'][$data->base_product_id]))
                        return $quantitiesMap['transferInSum'][$data->base_product_id];
                    else
                        return 0;
                },
            ),
            array(
                'header' => 'order(-)',
                'class'=>'DataColumn',
                'evaluateHtmlOptions'=>true,
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;', 'id'=> '"order_{$data->base_product_id}"'),
                'visible' => !$editOnly,
                'value'=>function($data) use ($quantitiesMap){
                    if(isset($quantitiesMap['orderSum'][$data->base_product_id]))
                        return $quantitiesMap['orderSum'][$data->base_product_id];
                    else
                        return 0;
                },
            ),

            array(
                'header' => 'Transfer-Out(-)',
                'type' => 'raw',
                'class'=>'DataColumn',
                'evaluateHtmlOptions'=>true,
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;', 'id'=> '"transferOut_{$data->base_product_id}"'),
                'visible' => !$editOnly,
                'value'=>function($data) use ($quantitiesMap){
                    if(isset($quantitiesMap['transferOutSum'][$data->base_product_id]))
                        return $quantitiesMap['transferOutSum'][$data->base_product_id];
                    else
                        return 0;
                },
            ),

            array(
                'header' => 'Extra Inv()',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;'),
                //'visible' => !$editOnly,
                'value' => function ($data) use ($quantitiesMap) {
                    $s_inv = $data->schedule_inv_absolute;
                    $prev_day_inv = $data->prev_day_inv;
                    $order_sum = getIfExist($quantitiesMap,'orderSum', $data);
                    $transfer_out = getIfExist($quantitiesMap,'transferOutSum', $data);
                    $data->extra_inv_absolute =$data->extra_inv * ($order_sum-$prev_day_inv+$transfer_out+$s_inv)/100;
                    if($data->extra_inv_absolute < 0){
                        $data->extra_inv_absolute = 0;
                    }
                    return CHtml::textField('extra_inv[]', $data->extra_inv_absolute, array('class'=>'inv-input id-field readOnlyInput', 'id'=>'extra-inv_'.$data->base_product_id, 'readonly'=>'readonly' ));
                },
            ),
            array(
                'header' => 'Order Inv(-)',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;'),
                'value' => function ($data) {
                    $bp_id_of_parent = $data->parent_id > 0 ? $data->parent_id : $data->base_product_id;
                    return CHtml::textField('present_inv[]', empty($data->present_inv) ? 0.00:$data->present_inv, array('class'=>'inv-input inputs', 'id'=>'pres-inv_'.$data->base_product_id, 'onchange'=>'onInvChange('.$data->base_product_id.', '.$bp_id_of_parent.')'));
                },
            ),
            array(
                'header' => 'Liquid Inv(-)',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;'),
                'value' => function ($data) {
                    $bp_id_of_parent = $data->parent_id > 0 ? $data->parent_id : $data->base_product_id;
                    return CHtml::textField('liquid_inv[]', empty($data->liquid_inv) ? 0.00:$data->liquid_inv, array('class'=>'inv-input inputs', 'id'=>'liquid-inv_'.$data->base_product_id, 'onchange'=>'onInvChange('.$data->base_product_id.', '.$bp_id_of_parent.')'));
                },
            ),
            array(
                'header' => 'Liquid Wastage(-)',
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;', ),
                'value' => function ($data) {
                    $bp_id_of_parent = $data->parent_id > 0 ? $data->parent_id : $data->base_product_id;
                    return CHtml::textField('liquidation_wastage[]', empty($data->liquidation_wastage) ? 0.00:$data->liquidation_wastage, array('class'=>'inv-input inputs', 'id'=>'wastage-others_'.$data->base_product_id, 'onchange'=>'onInvChange('.$data->base_product_id.', '.$bp_id_of_parent.')'));
                },
                'type' => 'raw',
            ),
            array(
                'header' => 'Wastage(-)',
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;'),
                'value' => function ($data) {
                    $bp_id_of_parent = $data->parent_id > 0 ? $data->parent_id : $data->base_product_id;
                    return CHtml::textField('wastage[]',  empty($data->wastage) ? 0.00:$data->wastage, array('class'=>'inv-input inputs', 'id'=>'wastage_'.$data->base_product_id, 'onchange'=>'onInvChange('.$data->base_product_id.', '.$bp_id_of_parent.')'));
                },
                'type' => 'raw',
            ),
            /*array(
                'header' => 'Sec Sale(-)',
                'headerHtmlOptions' => array('style' => 'width:10%;'),
                'htmlOptions' => array('style' => 'width:10%;'),
                'value' => function ($data) {
                    $bp_id_of_parent = $data->parent_id > 0 ? $data->parent_id : $data->base_product_id;
                    return CHtml::textField('secondary_sale[]',  empty($data->secondary_sale) ? 0.00:$data->secondary_sale, array('class'=>'inv-input inputs', 'id'=>'secondary-sale_'.$data->base_product_id, 'onchange'=>'onInvChange('.$data->base_product_id.', '.$bp_id_of_parent.')'));
                },
                'type' => 'raw',
            ),*/
            array(
                'header' => 'Balance(=)',
                'class'=>'DataColumn',
                'evaluateHtmlOptions'=>true,
                'visible' => !$editOnly,
                'headerHtmlOptions' => array('style' => 'width:40%;'),
                'htmlOptions' => array('style' => 'width:40%;', 'id'=> '"balance_{$data->base_product_id}"'),

                'value' => function ($data)  use ($quantitiesMap) {

                    //$s_inv = empty($data->schedule_inv_absolute) ? 0 : $data->schedule_inv_absolute ;
                    //$prev_day_inv =  empty($data->prev_day_inv) ? 0 : $data->prev_day_inv ;
                    $cur_inv =  empty($data->present_inv) ? 0 : $data->present_inv ;
                    $liq_inv =  empty($data->liquid_inv) ? 0 : $data->liquid_inv ;
                    $order_sum = getIfExist($quantitiesMap,'orderSum', $data);
                    $purchase = getIfExist($quantitiesMap,'purchaseSum', $data);
                    $trans_in = getIfExist($quantitiesMap,'transferInSum', $data);
                    $trans_out = getIfExist($quantitiesMap,'transferOutSum', $data);

                    //$extra_inv =  empty($data->extra_inv_absolute) ? 0 : $data->extra_inv_absolute ;
                    $wastage = empty($data->wastage) ? 0 : $data->wastage ;
                    $wastage_others = empty($data->liquidation_wastage) ? 0 : $data->liquidation_wastage ;
                    $balance =    $purchase+$trans_in -  ($order_sum+$trans_out+$cur_inv+$liq_inv+$wastage+$wastage_others);
                    $data->balance = $balance;
                    if(empty($data->balance)){
                        $data->balance = 0;
                    }
                    return $data->balance;
                },
                'type' => 'raw',
            ),
            array(
                'name' => 'balance',
                'type'=> 'raw',
                'headerHtmlOptions'=>array('style'=>'width:0%; display:none'),
                'filterHtmlOptions'=>array('style'=>'width:0%; display:none'),
                'htmlOptions'=>array('style'=>'width:0%; display:none'),
                'value' => function ($data) {
                    return CHtml::textField('balance[]', $data->balance, array('class' => 'readOnlyInput', 'id' => 'balance-input_'.$data->base_product_id));
                },
            ),
            array(
                'name' => 'id',
                'type'=> 'raw',
                'headerHtmlOptions'=>array('style'=>'width:0%; display:none'),
                'filterHtmlOptions'=>array('style'=>'width:0%; display:none'),
                'htmlOptions'=>array('style'=>'width:0%; display:none'),
                'value' => function ($data) {
                    return CHtml::textField('inv_hd_id[]', $data->id, array('class' => 'readOnlyInput'));
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
    <?php echo $form->hiddenField($model,'warehouse_id', array('value' => $w_id)); ?>
    <?php echo $form->hiddenField($model,'created_at'); ?>
    <?php echo $form->hiddenField($model,'date', array('value' => $model->date)); ?>


    <div class="row buttons">
        <?php
        //if($showSubmit) {
        if(true) {
            if ($update == true) {
                echo CHtml::submitButton('Update', array('name' => 'inventory-update'));
            } else {
                echo CHtml::submitButton('Create', array('name' => 'inventory-create'));
            }
        }
        ?>


        <a href="index.php?r=transferHeader/admin&w_id=<?php echo $w_id;?>" class="button_new" style="width: auto;" target="_blank"  >Back</a>

    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->


<script type="text/javascript">


    $(document).ready(function() {
        onStartUp();

    });

    function onStartUp(){
        $('.inputs').keydown(function (e) {
            if (e.which === 13) {
                var index = $('.inputs').index(this);
                if (e.shiftKey) {
                    $('.inputs').eq(index - 1).focus();
                }
                else {
                    $('.inputs').eq(index + 1).focus();
                }
                return false;
            }
        });

        $('.readOnlyInput').keydown(function (e) {
            if (e.which === 13) {
                return false;
            }
        });

        createItemTotalRow();
        //updateItemTotalRow();
    }

    function toggleChild(bp_id){
        $(".parent-id_"+bp_id).each(function ( ){
            if(!$(this).hasClass("unsorted")){
                console.log("reached toggle");
                $(this).toggle();
            }

        })
    }

    function onInvChange(bp_id, parent_id){
        //console.log('bp-id '+ bp_id);

        var editOnly = false;
        if($("#order_"+bp_id).length == 0) {
            editOnly = true;
        }

        var schInv = parseFloat($("#sch-inv_"+bp_id).val().trim()) || 0;
        var extraInv = parseFloat($("#extra-inv_"+bp_id).val().trim());
        var wastage = parseFloat($("#wastage_"+bp_id).val().trim()) || 0;
        var wastage_others = parseFloat($("#wastage-others_"+bp_id).val().trim());
        var presInv = parseFloat($("#pres-inv_"+bp_id).val().trim());
        var liquidInv = parseFloat($("#liquid-inv_"+bp_id).val().trim());

        if(!editOnly){

            var order = parseFloat($("#order_"+bp_id).html().trim());
            var prevDayInv = parseFloat($("#prev-day-inv_"+bp_id).html().trim());
            var tranferOut = parseFloat($("#transferOut_"+bp_id).html().trim());
            var transferIn = parseFloat($("#transferIn_"+bp_id).html().trim());
            var purchase = parseFloat($("#purchase_"+bp_id).html().trim());
            var balance = 0;
            balance = transferIn+prevDayInv+purchase -(schInv+order+extraInv+tranferOut+presInv+liquidInv+wastage+wastage_others);
            $("#balance_"+bp_id).html(balance);
            $("#balance-input_"+bp_id).val(balance);
        }

        /*console.log('sch '+schInv);
        console.log('prevDayInv '+prevDayInv);
        console.log('presInv '+presInv);
        console.log('liquidInv '+liquidInv);
        console.log('wastage '+wastage);
        console.log('wastage_others '+wastage_others);
        console.log('extraInv '+extraInv);
        console.log('order '+order);
        console.log('tranferOut '+tranferOut);
        console.log('transferIn '+transferIn);
        console.log('purchase '+purchase);
        console.log('balance '+balance);*/

        updateItemTotalRow(parent_id)
    }

    function createItemTotalRow() {
        $(".parent").each( function () {


            var parent_id = $(this).attr('id').split("_")[1];
            updateItemTotalRow(parent_id);

            $(this).find("input[type=text] ").each(function(){
               $(this).attr('readonly', 'readonly');
            });
        });

        var firstParentIndex =$(".parent").first().index();
        $(".child").each(function () {
            //console.log("child-index"+$(this).index()+"parent"+firstParentIndex);
            if($(this).index() < firstParentIndex){
                //console.log("here");
                $(this).show();
            }
        });
    }

    function updateItemTotalRow(parent_id) {

        var totalSchdInv = 0;
        var totalPrevDayInv = 0;
        var totalPurchase = 0;
        var totalTransfIn= 0;
        var totaltransfOut = 0;
        var totalOrder = 0;
        var totalExtraInv = 0;
        var totalOrderInv = 0;
        var totalLiqInv = 0;
        var totalLiqWastage = 0;
        var totalWastage = 0;
        var totalBalance = 0;

        var editOnly = false;

        if($("#order_"+parent_id).length == 0) {
            editOnly = true;
        }

        $(".item_"+parent_id).each( function() {
            var bp_id = $(this).attr('id').split("_")[1];
            if (bp_id==parent_id) return;
            totalSchdInv += parseFloat($("#sch-inv_"+bp_id).val().trim());
            totalExtraInv += parseFloat($("#extra-inv_"+bp_id).val().trim());
            totalWastage += parseFloat($("#wastage_"+bp_id).val().trim());
            totalLiqWastage += parseFloat($("#wastage-others_"+bp_id).val().trim());
            totalOrderInv += parseFloat($("#pres-inv_"+bp_id).val().trim());
            totalLiqInv += parseFloat($("#liquid-inv_"+bp_id).val().trim());

            if(!editOnly){

                totalOrder += parseFloat($("#order_"+bp_id).html().trim());
                totalPrevDayInv += parseFloat($("#prev-day-inv_"+bp_id).html().trim());
                totaltransfOut += parseFloat($("#transferOut_"+bp_id).html().trim());
                totalTransfIn += parseFloat($("#transferIn_"+bp_id).html().trim());
                totalPurchase += parseFloat($("#purchase_"+bp_id).html().trim());
                totalBalance += parseFloat($("#balance_"+bp_id).html().trim());
            }


        });

        if(!editOnly){

            $("#prev-day-inv_"+parent_id).html(totalPrevDayInv);
            $("#purchase_"+parent_id).html(totalPurchase);
            $("#transferIn_"+parent_id).html(totalTransfIn);
            $("#transferOut_"+parent_id).html(totaltransfOut);
            $("#order_"+parent_id).html(totalOrder);

            $("#balance_"+parent_id).html(totalBalance);
            $("#balance-input_"+parent_id).val(totalBalance);
        }
        $("#sch-inv_"+parent_id).val(totalSchdInv);
        $("#extra-inv_"+parent_id).val(totalExtraInv);
        $("#pres-inv_"+parent_id).val(totalOrderInv);
        $("#liquid-inv_"+parent_id).val(totalLiqInv);
        $("#wastage-others_"+parent_id).val(totalLiqWastage);
        $("#wastage_"+parent_id).val(totalWastage);

    }
    
    function onClickDownloadReport(url){
        //document.location.href
        var date = $("#date").val().trim();
        url = url + "&date="+date;
        //window.location.assign(url);
        //console.log(url);
        window.open(url, '_blank');
    }


</script>

