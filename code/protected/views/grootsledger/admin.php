<?php
 
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'dashboard-page-form',
        'enableAjaxValidation' => false,
    ));
   ?>

 <div class="dashboard-table">
                
                <h4>Download Groots Ledger</h4>
                <div class="right_date">    
                    <input  type="submit" name="downloadbutton" class="button_new" value="Download" />

                </div>

            </div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'grootsledger-grid',
	'itemsCssClass' => 'table table-striped table-bordered table-hover',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'order_id',
		'order_number',
		'user_id',
		'agent_name',
		'total_payable_amount',
		array(
            'name'=>'MIN_DUE_AMOUNT',
            'header'=>'MIN_DUE_AMOUNT',
            'value'=>'$data->MIN_DUE_AMOUNT',
            'filter' => false,
        ),

        array(
           'class' => 'ext.editable.EditableColumn',
           'name' => 'paid_value',
            'filter' => false,
           'headerHtmlOptions' => array('style' => 'width: 110px'),
           'editable' => array(
                  'url'        => $this->createUrl('Grootsledger/update'),
                  'placement'  => 'left',
                  'inputclass' => 'span3',  
                   'success'   => 'js: function(data) {
                                  if(typeof data == "object" && !data.success) return data.msg;
                                    }'    ,

              )  )             
       ,
		
	),
)); 


        
?>
<?php $this->endWidget(); ?>
