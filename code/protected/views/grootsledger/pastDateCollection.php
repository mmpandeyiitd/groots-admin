<?php
$this->breadcrumbs=array(
'Groots Ledger'=>array('admin&w_id='.$w_id),
'Past Collection',
);
?>



<form name="myform" method="post" action="<?php echo Yii::app()->getBaseUrl() . '/index.php?r=Grootsledger/pastDateCollection&w_id='.$w_id; ?>">

    <h2> Interval Report</h2>
    <div class="dashboard-table">
        <h4 style="width:20%">Interval Collection</h4>
        <div class="right_date" style="width:80%">
            <label for = "ledger_from">From</label>
            <?php

            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                // 'model' => $model,
                'name' => 'ledger_from',
                'attribute' => 'ledger_from',
                //'value' => $model->created_at,
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                    'showAnim' => 'fold',
                    'debug' => true,
                    //'mcollection_fromaxDate' => "60",
                ), //DateTimePicker options
                'htmlOptions' => array('readonly' => 'true'),
            ));
            //echo $form->error($model, 'created_at');
            ?>


            <label for = "purchase_to">To</label>
            <?php

            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                //'model' => $model,
                'name' => 'ledger_to',
                'attribute' => 'ledger_to',
                //'value' => $model->inv_created_at,
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                    'debug' => true,
                    //'maxDate' => "60",
                ), //DateTimePicker options
                'htmlOptions' => array('readonly' => 'true'),
            ));

            echo CHtml::submitButton('Download', array('onclick' => 'onIntervalReportDownload(event)'));
            ?>

        </div>
    </div>
    <br><br><br><br>
    <p>
        <h2> Past Date Ledger</h2>
    </p>

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




        <br>
        <br>
    </h5>
    <h3> Daily Retailers</h3>
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
    <h3>Non Daily Retailers</h3>
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
        <a href="index.php?r=Grootsledger/admin&w_id=<?php echo $w_id; ?>"   class="button_new" style="width: auto;" target="_blank"  >Back</a>
    </div>

</form>


<script type = "text/javascript">

    function onIntervalReportDownload(event) {
        var fromDate = $('#ledger_from').val();
        var toDate = $('#ledger_to').val();
        if(!fromDate){
            alert('Please Select From Date');
            event.preventDefault();
        }
        else if(!toDate){
            alert('Please Select to Date');
            event.preventDefault();
        }
    }

</script>