
<div class="form create_styleform"  > 


    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'dashboard-page-form',
       'enableAjaxValidation' => false,
    ));
    ?>
<?php if (Yii::app()->user->hasFlash('error')): ?><div class="errorSummary" style="color: "><?php echo Yii::app()->user->getFlash('error'); ?></div><?php endif; ?>
    
        
        <div class="dashboard-table">
            <form method="post">
           <h4 style="width:20%">Reports</h4>
            <div class="right_date" style="width:80%">
                <label>From Date</label>
                <?php

                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'name' => 'created_at',
                    'attribute' => 'created_at',
                    'value' => $model->created_at,
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'showAnim' => 'fold',
                        'debug' => true,
                        //'maxDate' => "60",
                    ), //DateTimePicker options 
                    'htmlOptions' => array('readonly' => 'true'),
                ));
                echo $form->error($model, 'created_at');
                ?>


                <label>To Date</label>
                <?php

                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'name' => 'inv_created_at',
                    'attribute' => 'inv_created_at',
                    'value' => $model->inv_created_at,
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'showAnim' => 'fold',
                        'debug' => true,
                        //'maxDate' => "60",
                    ), //DateTimePicker options
                    'htmlOptions' => array('readonly' => 'true'),
                ));
                echo $form->error($model, 'inv_created_at');
                ?>

                <input name="filter" class="button_new" type="submit" value="Download" />
               
               </div>
               </form>  






       
       </div>

       <div class="dashboard-table">
            <form method="post">
           <h4 style="width:20%">Report By client</h4>
            <div class="right_date" style="width:80%">
             
             
               
                <label>Date</label> 
             
                <?php

                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'name' =>'tocdate',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'showAnim' => 'fold',
                        'debug' => true,
                        //'maxDate' => "60",
                    //'minDate' => 0,
                    ), //DateTimePicker options 
                    'htmlOptions' => array('readonly' => 'true'),
                ));
               
                ?>    
                <input name="client" class="button_new" type="submit" value="Download" />
               
               </div>
               </form>  







       </div>

	<div class="dashboard-table">
            <form method="post">
           <h4 style="width:20%">collection</h4>
            <div class="right_date" style="width:80%">
                <label>From Date</label>
                <?php

                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                   // 'model' => $model,
                    'name' => 'collection_from',
                    'attribute' => 'collection_from',
                    //'value' => $model->created_at,
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'showAnim' => 'fold',
                        'debug' => true,
                        //'maxDate' => "60",
                    ), //DateTimePicker options 
                    'htmlOptions' => array('readonly' => 'true'),
                ));
                //echo $form->error($model, 'created_at');
                ?>


                <label>To Date</label>
                <?php

                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    //'model' => $model,
                    'name' => 'collection_to',
                    'attribute' => 'collection_to',
                    //'value' => $model->inv_created_at,
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'debug' => true,
                        //'maxDate' => "60",
                    ), //DateTimePicker options
                    'htmlOptions' => array('readonly' => 'true'),
                ));
                echo $form->error($model, 'inv_created_at');
                ?>

                <input name="collection" class="button_new" type="submit" value="Download" />
               
               </div>
               </form>

	</div>	
    <div class="dashboard-table">
        <form method="post">
            <h4 style="width:20%">Total Wastage Report</h4>
            <div class="right_date" style="width:80%">



                <label>Date</label>

                <?php

                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'name' =>'date',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'showAnim' => 'fold',
                        'debug' => true,
                        //'maxDate' => "60",
                        //'minDate' => 0,
                    ), //DateTimePicker options
                    'htmlOptions' => array('readonly' => 'true'),
                ));


                ?>
                <input name="total-wastage" class="button_new" type="submit" value="Download" />

            </div>
        </form>

    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
      