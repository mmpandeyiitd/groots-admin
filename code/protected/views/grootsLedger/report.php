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
           <h4>Reports</h4>
            <div class="right_date">
    <?php
                
                $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
                    'model' => $model,
                    'attribute' => 'created_at',
                    'value' => $model->created_at,
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'showAnim' => 'fold',
                        'debug' => true,
                        'maxDate' => "60",
                    ), //DateTimePicker options 
                    'htmlOptions' => array('readonly' => 'true'),
                ));
                echo $form->error($model, 'created_at');
                ?>
               
                <label>To</label>
             
                <?php

                $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
                    'model' => $model,
                    'attribute' => 'inv_created_at',
                    'value' => $model->inv_created_at,
                    'options' => array(
                        //  'dateFormat' => 'yy-mm-dd',
                        'showAnim' => 'fold',
                        'debug' => true,
                        'maxDate' => "60",
                    //'minDate' => 0,
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
           <h4>Report By client</h4>
            <div class="right_date">
             
             
               
                <label>Date</label> 
             
                <?php

                $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
                    'model' => $model,
                    'name' =>'tocdate',
                    'options' => array(
                        //  'dateFormat' => 'yy-mm-dd',
                        'showAnim' => 'fold',
                        'debug' => true,
                        'maxDate' => "60",
                    //'minDate' => 0,
                    ), //DateTimePicker options 
                    'htmlOptions' => array('readonly' => 'true'),
                ));
               
                ?>    
                <input name="client" class="button_new" type="submit" value="Download" />
               
               </div>
               </form>  






       <?php $this->endWidget(); ?>
       </div>
</div><!-- form -->
      