<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 9/9/16
 * Time: 2:17 PM
 */
?>

<?php
    $showSubmit = true;
    if(isset($update) && $update==true){
        $update=true;
        if($model->delivery_date < date('Y-m-d')){
            $showSubmit = false;
        }
    }
    else{
        $update = false;
    }

$readOnlyReceived = 'readonly';
$readOnlyProcured = 'readonly';
$visibleReceived = false;
$visibleProcured = false;
if($this->checkAccess('SuperAdmin')){
    $readOnlyReceived = false;
    $readOnlyProcured = false;
    $visibleReceived = true;
    $visibleProcured = true;
}
elseif($this->checkAccessByData('ProcurementEditor', array('warehouse_id'=>$w_id))){
    $readOnlyProcured = false;
    $readOnlyReceived = 'readonly';
    $visibleReceived = false;
    $visibleProcured = true;
}
elseif($this->checkAccessByData('PurchaseEditor', array('warehouse_id'=>$w_id))){
    $readOnlyReceived = false;
    $readOnlyProcured = 'readonly';
    $visibleReceived = true;
    $visibleProcured = false;
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
    <?php echo $form->labelEx($model,'vendor_id'); ?>
    <?php echo $form->dropDownList($model,
    'vendor_id',
    CHtml::listData(Vendor::model()->findAllByAttributes(array('allocated_warehouse_id' => $w_id, 'status'=>1), array('select'=>'id,name','order' => 'name')),'id','name'),
    array( 'options'=>array($model->vendor_id=>array('selected'=>'selected')))
    );
    ?>
    <?php echo $form->error($model,'vendor_id'); ?>
</div>

<div class="row" >
    <?php echo $form->labelEx($model,'paid_amount'); ?>
    <?php echo $form->textField($model,'paid_amount',array('size'=>60,'maxlength'=>255, 'class'=>'inputs')); ?>
    <?php echo $form->error($model,'paid_amount'); ?>
</div>

<div class="row">
    <?php
    $delivery_date = substr($model->attributes['delivery_date'], 0, 10);
    if(!isset($delivery_date) || empty($delivery_date)){
        $model->delivery_date = Utility::getDefaultDeliveryDate();
    }
    echo $form->labelEx($model,'delivery_date'); ?>
    <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
        'model'=>$model,
        'attribute'=>'delivery_date',

        'id'=>'delivery_date',
        //'value'=> $delivery_date,
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
    <?php echo $form->labelEx($model,'payment_method'); ?>
    <?php echo $form->dropDownList($model,'payment_method',
        CHtml::listData(PurchaseHeader::paymentMethod(),'value', 'value'),
        array('empty' => 'Select a Payment method'));

    ?>
    <?php echo $form->error($model,'payment_type'); ?>
</div>

    <div class="row">
        <?php echo $form->labelEx($model,'payment_status'); ?>
        <?php echo $form->dropDownList($model,'payment_status',
            CHtml::listData(PurchaseHeader::paymentStatus(),'value', 'value'),
            array('empty' => 'Select a Payment status'));

        ?>
        <?php echo $form->error($model,'payment_status'); ?>
    </div>

<div class="row">
    <?php echo $form->labelEx($model,'status'); ?>
    <?php echo $form->dropDownList($model,'status',
        CHtml::listData(PurchaseHeader::status(),'value', 'value'));

    ?>
    <?php echo $form->error($model,'status'); ?>
</div>

<div class="row">
    <?php echo $form->label($model,'comment'); ?>
    <?php echo $form->textArea($model,'comment', array('cols'=>200, 'rows'=>4, 'style'=>'width:400px;')); ?>
    <?php echo $form->error($model,'comment'); ?>
<!--</div>
    <div>
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
/*        }
        */?>

    </ul>
    <?php
/*    echo CHtml::button("Add", array("onclick" => "addItemToOrder()"));
    */?>
</div>-->

<?php

    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'purchase-header-grid',
        'itemsCssClass' => 'table table-striped table-bordered table-hover',
        'rowCssClassExpression' => '$data->getCssClass()',
        'rowHtmlOptionsExpression' => 'array("id" => "bp_".$data->base_product_id)',
        'afterAjaxUpdate' => 'onStartUp',
        'dataProvider'=>$dataProvider,
        'filter'=>$inv_header,
        'columns'=>array(
            array(
                'header' => 'show child',
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
                'header' => 'To Be Procured Qty',
                'type' => 'raw',
                'visible' => $visibleProcured,
                'headerHtmlOptions' => array('style' => 'width:15%;'),
                'htmlOptions' => array('style' => 'width:15%;'),
                'value' => function ($data) use ($readOnlyProcured, $purchaseLineMap) {
                    if(isset($purchaseLineMap[$data->base_product_id])){
                        $data->tobe_procured_qty = $purchaseLineMap[$data->base_product_id]['tobe_procured_qty'];
                    }
                    return CHtml::label($data->tobe_procured_qty, $data->tobe_procured_qty, array('id'=>'tobe-procured_'.$data->base_product_id));
                },
            ),

            array(
                'header' => 'Vendors',
                'type' => 'raw',
                'value' => function($data){
                    return 
                    return CHtml::activeDropDownList($data , 'vendor_id', VendorDao::getVendorProductList(), array('options' => array($data->vendor_id=>array('selected'=>true)), 'style' => 'width:220.5px;'));
                }
                )

            array(
                'header' => 'Procured Quantity',
                'type' => 'raw',
                'visible' => $visibleProcured,
                'headerHtmlOptions' => array('style' => 'width:15%;'),
                'htmlOptions' => array('style' => 'width:15%;'),
                'value' => function ($data) use ($readOnlyProcured, $purchaseLineMap) {
                    if(isset($purchaseLineMap[$data->base_product_id])){
                        $data->order_qty = $purchaseLineMap[$data->base_product_id]['order_qty'];
                    }
                    return CHtml::textField('order_qty[]', $data->order_qty, array('class'=>'input inputs', 'readonly'=> $readOnlyProcured, 'id'=>'order_'.$data->base_product_id, 'onchange'=>'updateItemTotalRow('.$data->parent_id.')'));
                },
            ),
            array(
                'header' => 'Received Quantity',
                'headerHtmlOptions' => array('style' => 'width:15%;'),
                'htmlOptions' => array('style' => 'width:15%;'),
                'visible' => $visibleReceived,
                'value' => function ($data) use ($readOnlyReceived, $purchaseLineMap) {
                    if(isset($purchaseLineMap[$data->base_product_id])){
                        $data->received_qty = $purchaseLineMap[$data->base_product_id]['received_qty'];
                    }
                    return CHtml::textField('received_qty[]', $data->received_qty, array('class'=>'input received-inputs', 'readonly'=> $readOnlyReceived, 'id'=>'received_'.$data->base_product_id, 'onchange'=>'updateItemTotalRow('.$data->parent_id.')'));
                },
                'type' => 'raw',
            ),
            /*array(
                'header' => 'Price',
                'headerHtmlOptions' => array('style' => 'width:15%;'),
                'htmlOptions' => array('style' => 'width:15%;'),
                'value' => function ($data) use ($readOnlyProcured) {
                    return CHtml::textField('price[]', $data->price, array('class'=>'input price inputs', 'readonly'=> $readOnlyProcured, 'id'=>'price_'.$data->base_product_id, 'onchange'=>'onPriceChange(
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
        <?php /*echo $form->textField($model,'total_payable_amount',array('size'=>60,'maxlength'=>255, 'id'=>'sumAmount', 'class'=>'inputs')); */?>
        <?php /*echo $form->error($model,'total_payable_amount'); */?>
    </div>-->
<?php echo $form->hiddenField($model,'warehouse_id', array('value' => $w_id)); ?>
<?php echo $form->hiddenField($model,'created_at'); ?>


<div class="row buttons">
    <?php
    if($showSubmit) {
        if ($update == true) {
            echo CHtml::submitButton('Update', array('name' => 'purchase-update'));
        } else {
            echo CHtml::submitButton('Create', array('name' => 'purchase-create'));
        }
    }
    ?>


    <a href="index.php?r=purchaseHeader/admin&w_id=<?php echo $w_id;?>" class="button_new" style="width: auto;" target="_blank"  >Back</a>

</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<script type="text/javascript">

    $(document).ready(function() {

        /*$('#alphabetical-nav').listnav({
            initLetter: 'A',
            includeOther: true,
            filterSelector: '.title',
            includeNums: true,
            removeDisabled: true,
            allText: 'Complete Item list'
        });*/

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

        $('.received-inputs').keydown(function (e) {
            if (e.which === 13) {
                var index = $('.received-inputs').index(this);
                if (e.shiftKey) {
                    $('.received-inputs').eq(index - 1).focus();
                }
                else {
                    $('.received-inputs').eq(index + 1).focus();
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

    }

    function toggleChild(bp_id){
        $(".parent-id_"+bp_id).each(function ( ){
            if(!$(this).hasClass("unsorted")){
                console.log("reached toggle");
                $(this).toggle();
            }

        })
    }

    function createItemTotalRow() {
        $(".parent").each( function () {


            var parent_id = $(this).attr('id').split("_")[1];
            updateItemTotalRow(parent_id);

            $(this).find("input[type=text] ").each(function(){
                $(this).attr('readonly', 'readonly');
            });


        });
    }

    function updateItemTotalRow(parent_id) {

        var totalTobeProcured = 0;
        var totalOrder = 0;
        var totalReceived = 0;
        console.log(parent_id);
        $(".item_"+parent_id).each( function() {
            var bp_id = $(this).attr('id').split("_")[1];

            if (bp_id==parent_id) return;
            if($("#tobe-procured_"+bp_id).length > 0){
                totalTobeProcured += parseFloat($("#tobe-procured_"+bp_id).html().trim()) || 0;
            }
            if($("#order_"+bp_id).length > 0){
                totalOrder += parseFloat($("#order_"+bp_id).val().trim()) || 0;
            }
            if($("#received_"+bp_id).length > 0){
                totalReceived += parseFloat($("#received_"+bp_id).val().trim()) || 0;
            }



        });
        console.log(totalOrder);
        if($("#tobe-procured_"+parent_id).length > 0){
            $("#tobe-procured_"+parent_id).html(totalTobeProcured);
        }
        if($("#order_"+parent_id).length > 0){
            $("#order_"+parent_id).val(totalOrder);
        }
        if($("#received_"+parent_id).length > 0){
            $("#received_"+parent_id).val(totalReceived);
        }




    }

    function showAddItemBox(){
        console.log("button clicked");
        $("#alpha-nav-div").css('display', 'block');
    }

    function addItemToOrder(){
        console.log("addItemToOrder");
        $(".cb_item").each(function(){
            if($(this).prop('checked')==true){
                var prodId = $(this).attr('id').split("_")[1];
                var title =$('#title_'+prodId).html().split("<span>")[0];
                //console.log(prodId+title);
                lastRow = $('.table tbody>tr:last');
                row = $('.table tbody>tr:last').prev('tr').clone();
                var i = 0;
                row.find('td').each (function() {
                    if(i==0){
                        //console.log("here123");
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
        onStartUp();
    }
    
    /*function onPriceChange($bp_id) {
        updateTotalAmount()
    }
    function  updateTotalAmount() {
        var sumAmount = 0;
        $(".price").each(function(){
            sumAmount += Number($(this).val());
        });
        $("#sumAmount").val(sumAmount);
    }*/

</script>