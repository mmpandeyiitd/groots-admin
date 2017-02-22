<?php
$this->breadcrumbs=array(
'Groots Ledger'=>array('admin&w_id=2'),
'Past Collection',
);
?>

<form name="myform" method="post"
      action="<?php echo Yii::app()->getBaseUrl() . '/index.php?r=Grootsledger/pastDateCollection&w_id=2'; ?>">
    <h5>
        Select Date
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            //'model' => $model,
            'name' => 'date',
            //'attribute' => 'created_at',
            'value' => $date,
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'showAnim' => 'fold',
                'debug' => true,
                //'maxDate' => "60",
            ), //DateTimePicker options
        ));
        ?>
        <br/>
        <?php
        echo CHtml::submitButton('Submit');
        ?>
        <br/>
        <br/>
        <div>
            <?php echo CHtml::submitButton('Download Daily Report', array('name' => 'dailyReport')); ?>
            &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
            <?php echo CHtml::submitButton('Download Non Daily Report', array('name' => 'nonDailyReport')) ?>
        </div>


    </h5>
    <h2> Daily Retailers</h2>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'todayscollection',
        'dataProvider' => $dailyDataProvider,
        'columns' => array(
            'id',
            'name',
            'status',
            'total_payable_amount',
            'current_due_date',
        )));
    ?>
    <h2>Non Daily Retailers</h2>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'todayscollection',
        'dataProvider' => $nonDailyDataProvider,
        'columns' => array(
            'id',
            'name',
            'status',
            'collection_frequency',
            'total_payable_amount',
            'current_due_date',
        )));
    ?>


    <div>
        <?php echo "<br>" ?>
        <!--<a href="index.php?r=Grootsledger/admin" class="button_new" style="width: auto;" target="_blank"  >Back</a>-->
        <a href="index.php?r=Grootsledger/admin" class="button_new" style="width: auto;" target="_blank"  >Back</a>
    </div>

</form>
