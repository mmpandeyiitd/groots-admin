<?php
/**
 * Created by PhpStorm.
 * User: manmohan
 * Date: 9/9/16
 * Time: 2:17 PM
 */
?>

<?php
    if(isset($update) && $update==true){
        $update=true;
    }
    else{
        $update = false;
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


<div class="row">
    <?php echo $form->labelEx($model,'paid_amount'); ?>
    <?php echo $form->textField($model,'paid_amount',array('size'=>60,'maxlength'=>255)); ?>
    <?php echo $form->error($model,'paid_amount'); ?>
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
    <?php echo $form->labelEx($model,'payment_method'); ?>
    <?php echo $form->dropDownList($model,'payment_method',
        CHtml::listData(RetailerPayment::paymentTypes(),'value', 'value'),
        array('empty' => 'Select a Payment method'));

    ?>
    <?php echo $form->error($model,'payment_type'); ?>
</div>

    <div class="row">
        <?php echo $form->labelEx($model,'payment_status'); ?>
        <?php echo $form->dropDownList($model,'payment_status',
            CHtml::listData(RetailerPayment::paymentTypes(),'value', 'value'),
            array('empty' => 'Select a Payment status'));

        ?>
        <?php echo $form->error($model,'payment_status'); ?>
    </div>

<div class="row">
    <?php echo $form->labelEx($model,'status'); ?>
    <?php echo $form->dropDownList($model,'status',
        CHtml::listData(RetailerPayment::status(),'value', 'value'));

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
                        'class'=>'cb_item'
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
        'dataProvider'=>$items,
        //'filter'=>$model,
        'columns'=>array(
            array(
                'header' => 'id',
                'name' => 'base_product_id[]',
                'value' => '$data->base_product_id',
                'type' => 'raw',
            ),
            array(
                'header' => 'title',
                'headerHtmlOptions' => array('style' => 'width:40%;'),
                'htmlOptions' => array('style' => 'width:40%;'),
                'value' => function ($data) {
                    return CHtml::label($data->title, $data->title,array('class'=>'input'));
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
                'header' => 'Received Quantity',
                'headerHtmlOptions' => array('style' => 'width:15%;'),
                'htmlOptions' => array('style' => 'width:15%;'),
                'value' => function ($data) {
                    return CHtml::textField('received_qty[]', $data->received_qty, array('class'=>'input'));
                },
                'type' => 'raw',
            ),
            array(
                'header' => 'Price',
                'headerHtmlOptions' => array('style' => 'width:15%;'),
                'htmlOptions' => array('style' => 'width:15%;'),
                'value' => function ($data) {
                    return CHtml::textField('price[]', $data->price, array('class'=>'input'));
                },
                'type' => 'raw',
            ),

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


<?php echo $form->hiddenField($model,'id'); ?>
<?php echo $form->hiddenField($model,'created_at'); ?>


<div class="row buttons">
    <?php
    if($update==true){
        echo CHtml::submitButton('Update', array('name'=>'update'));
    }
    else{
        echo CHtml::submitButton('Create', array('name'=>'create'));
    }
    ?>


    <a href="index.php?r=purchaseHeader/admin" class="button_new" style="width: auto;" target="_blank"  >Back</a>

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
                        $(this).html(prodId);
                    }
                    else if(i==1) {
                        $(this).find('label').each(function () {
                            $(this).html(title);
                        });
                    }
                    i++;
                });
                row.insertAfter(lastRow);
                $(this).prop('checked',false);
            }
        });
        $("#alpha-nav-div").css('display', 'none');
    }

</script>