<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 13/9/16
 * Time: 1:15 PM
 */

?>

<?php
if(isset($update) && $update==true){
    $update=true;
    $source_wid=$model->source_warehouse_id;
}
else{
    $update = false;
    $source_wid=$w_id;
}

$disabled = "";
if($update == true) {
    $disabled = "disabled";
}

?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'purchase-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model->errors); ?>

    <div class="row" style="display: inline;">
        <?php echo $form->labelEx($model,'source_warehouse_id'); ?>
        <?php echo $form->dropDownList($model,
            'source_warehouse_id',
            CHtml::listData(Warehouse::model()->findAllByAttributes(array('status' => 1), array('select'=>'id,name', 'order' => 'name')),'id','name'),
            array('empty' => 'Select a warehouse','disabled'=>$disabled, 'options'=>array($source_wid=>array('selected'=>'selected')))
        );
        ?>
        <?php echo $form->error($model,'source_warehouse_id'); ?>
    </div>

    <div class="row" style="display: inline;">
        <?php echo $form->labelEx($model,'dest_warehouse_id'); ?>
        <?php echo $form->dropDownList($model,
            'dest_warehouse_id',
            CHtml::listData(Warehouse::model()->findAllByAttributes(array('status' => 1), array('select'=>'id,name',  'order' => 'name')),'id','name'),
            array('empty' => 'Select a warehouse', 'disabled'=>$disabled, 'options'=>array($model->dest_warehouse_id =>array('selected'=>'selected')))
        );
        ?>
        <?php echo $form->error($model,'source_warehouse_id'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model,'delivery_date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'attribute'=>'delivery_date',

            'id'=>'delivery_date',
            //'value'=> date('Y-m-d'),
            'options'=>array(
                'dateFormat' => 'yy-mm-dd',
                'showAnim'=>'fold',
            ),
            'htmlOptions'=>array(
                'style'=>'height:20px;'
            ),
        )); ?>
        <?php echo $form->error($model,'delivery_date'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status',
            CHtml::listData(TransferHeader::status(),'value', 'value'));

        ?>
        <?php echo $form->error($model,'status'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'comment'); ?>
        <?php echo $form->textArea($model,'comment', array('cols'=>200, 'rows'=>4, 'style'=>'width:400px;')); ?>
        <?php echo $form->error($model,'comment'); ?>
    </div>
    <div>
        <?php
        echo CHtml::button("Add Items for Purchase", array("onclick" => "showAddItemBox()"));
        ?>
    </div>
    <div id="alpha-nav-div" style="display:none;">
        <ul id="alphabetical-nav" style="list-style: none;">
            <?php foreach ($otherItems as $item){
                ?>
                <li style="" >

                    <?php echo CHtml::CheckBox('cb_'.$item['bp_id'],'', array (
                        'value'=>'on',
                        'class'=>'cb_item',
                        'id' => 'cb_'.$item['bp_id'],
                    )); ?>

                    <span class="title" id="title_<?php echo $item['bp_id']; ?>"><?php echo $item['title']; ?><span>

                </li>
                <?php
            }
            ?>

        </ul>
        <?php
        echo CHtml::button("Add", array("onclick" => "addItemToOrder()"));
        ?>
    </div>

    <?php

    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'purchase-header-grid',
        'itemsCssClass' => 'table table-striped table-bordered table-hover',
        'dataProvider'=>$dataProvider,
        //'filter'=>$model,
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
                'header' => 'title',
                'headerHtmlOptions' => array('style' => 'width:40%;'),
                'htmlOptions' => array('style' => 'width:40%;'),
                'value' => function ($data) {
                    return CHtml::label($data->BaseProduct->title, $data->BaseProduct->title,array('class'=>'title'));
                },
                'type' => 'raw',
            ),
            array(
                'header' => 'Order Quantity',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'width:15%;'),
                'htmlOptions' => array('style' => 'width:15%;'),
                'value' => function ($data) {
                    return CHtml::textField('order_qty[]', $data->order_qty, array('class'=>'input'));
                },
            ),
            array(
                'header' => 'Delivered Quantity',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'width:15%;'),
                'htmlOptions' => array('style' => 'width:15%;'),
                'value' => function ($data) {
                    return CHtml::textField('delivered_qty[]', $data->delivered_qty, array('class'=>'input'));
                },
            ),
            array(
                'header' => 'Received Quantity',
                'headerHtmlOptions' => array('style' => 'width:15%;'),
                'htmlOptions' => array('style' => 'width:15%;'),
                'value' => function ($data) {
                    return CHtml::textField('received_qty[]', $data->received_qty, array('class'=>'input'));
                },
                'type' => 'raw',
            ),
            /*array(
                'header' => 'Price',
                'headerHtmlOptions' => array('style' => 'width:15%;'),
                'htmlOptions' => array('style' => 'width:15%;'),
                'value' => function ($data) {
                    return CHtml::textField('price[]', $data->price, array('class'=>'input price', 'id'=>'price_'.$data->base_product_id, 'onchange'=>'onPriceChange(
                    '.$data->base_product_id.')'));
                },
                'type' => 'raw',
            ),*/

            /*
            'delivery_date',
            'total_payable_amount',
            'comment',
            'invoice_number',
            'created_at',
            'updated_at',
            */

        ),
    ));

    ?>

    <!--<div class="order_bottomdetails" align="right">
        <?php /*echo $form->labelEx($model,'total_payable_amount'); */?>
        <?php /*echo $form->textField($model,'total_payable_amount',array('size'=>60,'maxlength'=>255, 'id'=>'sumAmount')); */?>
        <?php /*echo $form->error($model,'total_payable_amount'); */?>
    </div>-->
    <?php echo $form->hiddenField($model,'dest_warehouse_id', array('value' => $w_id)); ?>
    <?php echo $form->hiddenField($model,'created_at'); ?>


    <div class="row buttons">
        <?php
        if($update==true){
            echo CHtml::submitButton('Update', array('name'=>'transfer-update'));
        }
        else{
            echo CHtml::submitButton('Create', array('name'=>'transfer-create'));
        }
        ?>


        <a href="index.php?r=transferHeader/admin&w_id=<?php echo $w_id;?>" class="button_new" style="width: auto;" target="_blank"  >Back</a>

    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->


<script type="text/javascript">

    $(document).ready(function() {
        $('#alphabetical-nav').listnav({
            initLetter: 'A',
            includeOther: true,
            filterSelector: '.title',
            includeNums: true,
            removeDisabled: true,
            allText: 'Complete Item list'
        });

    });

    function showAddItemBox(){
        console.log("button clicked");
        $("#alpha-nav-div").css('display', 'block');
    }

    function addItemToOrder(){
        console.log("addItemToOrder");
        $(".cb_item").each(function(){
            console.log("each fun");
            if($(this).prop('checked')==true){
                var prodId = $(this).attr('id').split("_")[1];
                var title =$('#title_'+prodId).html().split("<span>")[0];
                console.log(prodId+title);
                lastRow = $('.table tbody>tr:last');
                row = $('.table tbody>tr:last').prev('tr').clone();
                var i = 0;
                row.find('td').each (function() {
                    if(i==0){
                        console.log("here123");
                        $(this).find("input").val(prodId);
                    }
                    else if(i==1) {
                        $(this).find('label').each(function () {
                            $(this).html(title);
                        });
                    }
                    else{
                        $(this).find("input").each(function () {
                            $(this).val('');
                        })
                    }

                    i++;
                });
                row.insertAfter(lastRow);
                $(this).prop('checked',false);
            }
        });
        $("#alpha-nav-div").css('display', 'none');
    }

    function onPriceChange($bp_id) {
        updateTotalAmount()
    }
    function  updateTotalAmount() {
        var sumAmount = 0;
        $(".price").each(function(){
            sumAmount += Number($(this).val());
        });
        $("#sumAmount").val(sumAmount);
    }

</script>