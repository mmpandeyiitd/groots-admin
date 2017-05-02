<form>
    <?php
    echo 'Select Date';
    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
        //'model'=>$vendor,
        'name' => 'date',
        'attribute'=>'date',
        //'value' => $vendorPayment->date,
        'id'=>'date',
        'options'=>array(
            'dateFormat' => 'yy-mm-dd',
            'showAnim'=>'fold',
        ),
        'htmlOptions'=>array(
            'style'=>'height:20px;'
        ),
    ));
    echo CHtml::dropDownList('vendor_list', 0,VendorDao::allVendorDropDown(), array('style' => 'width:220.5px;'));
    ?>

</form>
