<form>
<?php
echo 'Select Date'."\t";
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    //'model' => $model,
    'name' => 'text',
    //'attribute' => 'deliverySummaryDeliveryDate',
    'flat' => false, //remove to hide the datepicker
    'options' => array(
        'showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
        // 'minDate' => 0,
        'dateFormat' => 'yy-mm-dd',
        //'minDate'=>-5,
        'maxDate' => "+3M",
    ),
    'value' => date('Y-m-d'),
    'htmlOptions' => array(
        'style' => 'float:center;', 'readonly' => 'true',
    ),

));
echo '<br>'.'<br>'.'<br>';
echo ' Enter Text Subject'."\t".CHtml::textArea('Subject','', array('style' => 'float:center;'));
echo '<br>';
echo CHtml::submitButton('Submit');
?>
</form>
